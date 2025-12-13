<?php namespace App\Controllers;

use App\Models\PrizeModel;
use App\Models\RegistrantModel;
use App\Models\WinnerModel;
use App\Libraries\GoogleSheetSync;

class Admin extends BaseController
{
    protected function checkDatabase()
    {
        if (!$this->checkDatabaseExtension()) {
            $error = $this->getDatabaseErrorMessage();
            return view('admin/error', [
                'error' => $error,
                'title' => 'Database Error'
            ]);
        }
        
        // Test database connection
        try {
            $db = \Config\Database::connect();
            $db->initialize();
            $db->query("SELECT 1");
        } catch (\Exception $e) {
            $errorMsg = 'Tidak dapat terhubung ke database: ' . $e->getMessage();
            log_message('error', 'Database connection error: ' . $errorMsg);
            return view('admin/error', [
                'error' => $errorMsg . '. Pastikan database sudah dibuat dan dikonfigurasi dengan benar di app/Config/Database.php',
                'title' => 'Database Connection Error'
            ]);
        }
        
        return null;
    }

    public function index()
    {
        $errorView = $this->checkDatabase();
        if ($errorView) return $errorView;
        
        return view('admin/dashboard');
    }

    public function prizes()
    {
        $errorView = $this->checkDatabase();
        if ($errorView) {
            return view('admin/prizes', [
                'prizes' => [],
                'prize' => [],
                'error' => $this->getDatabaseErrorMessage()
            ]);
        }

        $model = new PrizeModel();
        
        try {
            // Gunakan findAll() tanpa select eksplisit untuk menghindari error kolom tidak ada
            $prizes = $model->orderBy('id', 'DESC')->findAll();
            
            // Map kolom database ke format yang digunakan view (support backward compatibility)
            $data['prizes'] = array_map(function($prize) {
                return [
                    'id' => $prize['id'] ?? 0,
                    'name' => $prize['name'] ?? $prize['prize_name'] ?? '',
                    'stock' => $prize['stock'] ?? 0,
                    'image' => $prize['image'] ?? $prize['images'] ?? '',
                    'raffled' => $prize['raffled'] ?? 0,
                    'is_grandprize' => $prize['is_grand_prize'] ?? $prize['is_grandprize'] ?? 0,
                ];
            }, $prizes ?: []);
        } catch (\Exception $e) {
            $data['prizes'] = [];
            log_message('error', 'Error loading prizes: ' . $e->getMessage());
            $data['error'] = 'Error loading prizes: ' . $e->getMessage();
        }
        
        $data['prize'] = []; // Untuk form edit
        
        return view('admin/prizes', $data);
    }

    public function savePrize()
    {
        $prizeModel = new PrizeModel();

        $id = $this->request->getPost('id');
        $data = [
            'name' => $this->request->getPost('name'),
            'prize_name' => $this->request->getPost('name'), // Untuk backward compatibility
            'stock' => $this->request->getPost('stock'),
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $uploadPath = ROOTPATH . 'public/uploads/prizes/';

            // Ensure directory exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Move uploaded image
            $image->move($uploadPath, $newName);
            $data['image'] = $newName;
            $data['images'] = $newName; // Untuk backward compatibility

            // If editing and old image exists, optionally delete old one
            if ($id) {
                $existing = $prizeModel->find($id);
                if ($existing) {
                    $oldImage = $existing['images'] ?? $existing['image'] ?? '';
                    if (!empty($oldImage)) {
                        $oldPath = $uploadPath . $oldImage;
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                }
            }
        }

        if ($id) {
            $prizeModel->update($id, $data);
        } else {
            $prizeModel->insert($data);
        }

        return redirect()->to('/admin/prizes')->with('message', 'Hadiah berhasil disimpan.');
    }

    public function deletePrize($id)
    {
        $model = new PrizeModel();
        $model->delete($id);
        return redirect()->to('/admin/prizes');
    }

    public function registrants()
    {
        $errorView = $this->checkDatabase();
        if ($errorView) {
            return $errorView;
        }

        $data = ['registrants' => [], 'error' => null];

        try {
            $model = new RegistrantModel();
            $registrants = $model->orderBy('id', 'DESC')->findAll();
            
            // Pastikan data dalam format yang benar
            $data['registrants'] = is_array($registrants) ? $registrants : [];
        } catch (\Exception $e) {
            log_message('error', 'Error loading registrants: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            $data['registrants'] = [];
            $errorMsg = 'Error loading registrants: ' . $e->getMessage();
            if (ENVIRONMENT !== 'production') {
                $errorMsg .= ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine();
            }
            $data['error'] = $errorMsg;
        } catch (\Throwable $e) {
            log_message('error', 'Fatal error loading registrants: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            $data['registrants'] = [];
            $errorMsg = 'Fatal error: ' . $e->getMessage();
            if (ENVIRONMENT !== 'production') {
                $errorMsg .= ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine();
            }
            $data['error'] = $errorMsg;
        }
        
        return view('admin/registrants', $data);
    }

    public function raffleControl()
    {
        return view('admin/raffle_control');
    }

    public function winners()
    {
        $errorView = $this->checkDatabase();
        if ($errorView) {
            return view('admin/winners', [
                'winners' => [],
                'error' => $this->getDatabaseErrorMessage()
            ]);
        }

        try {
            $winnerModel = new WinnerModel();
            $registrantModel = new RegistrantModel();
            $prizeModel = new PrizeModel();

            $winners = $winnerModel->orderBy('created_at', 'DESC')->findAll();
            $data = [];

            foreach ($winners as $winner) {
                $registrant = $registrantModel->find($winner['registrant_id']);
                $prize = $prizeModel->find($winner['prize_id']);

                $data[] = [
                    'id'         => $winner['id'],
                    'name'       => $registrant['name'] ?? 'Unknown',
                    'email'      => $registrant['email'] ?? '',
                    'phone_number' => $registrant['phone_number'] ?? '',
                    'company'    => $registrant['company'] ?? $registrant['bisnis_unit'] ?? '',
                    'prize'      => $prize['name'] ?? $prize['prize_name'] ?? 'Deleted Prize',
                    'status'     => $winner['status'] ?? 'Pending',
                    'created_at' => $winner['created_at'],
                ];
            }

            return view('admin/winners', ['winners' => $data]);
        } catch (\Exception $e) {
            log_message('error', 'Error loading winners: ' . $e->getMessage());
            return view('admin/winners', [
                'winners' => [],
                'error' => 'Error loading winners: ' . $e->getMessage()
            ]);
        }
    }

    public function updateWinnerStatus()
    {
        $winnerId = $this->request->getPost('winner_id');
        
        if (!$winnerId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Winner ID is required'
            ]);
        }

        try {
            $winnerModel = new WinnerModel();
            $winner = $winnerModel->find($winnerId);
            
            if (!$winner) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Winner not found'
                ]);
            }

            // Update status to "Done"
            $winnerModel->update($winnerId, ['status' => 'Done']);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Winner status updated to Done'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error updating winner status: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error updating status: ' . $e->getMessage()
            ]);
        }
    }

    public function postSaveWinner()
    {
        $request = service('request');

        $registrantId = $request->getPost('registrant_id');
        $prizeId = $request->getPost('prize_id');  // now from POST data

        if (!$registrantId || !$prizeId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid data']);
        }

        $winnerModel = new WinnerModel();
        $winnerModel->save([
            'registrant_id' => $registrantId,
            'prize_id'      => $prizeId,
            'status'        => 'Pending',
        ]);

        $prizeModel = new PrizeModel();
        $prizeModel->update($prizeId, ['raffled' => 1]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function selectPrize()
    {
        $errorView = $this->checkDatabase();
        if ($errorView) return $errorView;

        try {
            $prizeModel = new PrizeModel();
            $prizes = $prizeModel->select('id, name, prize_name, image, images, stock, raffled, is_grand_prize, is_grandprize')
                                 ->where('(is_grand_prize = 0 OR is_grandprize = 0 OR (is_grand_prize IS NULL AND is_grandprize IS NULL))')
                                 ->findAll();
            
            // Normalize data untuk view
            $prizes = array_map(function($prize) {
                return [
                    'id' => $prize['id'],
                    'name' => $prize['name'] ?? $prize['prize_name'] ?? '',
                    'image' => $prize['image'] ?? $prize['images'] ?? '',
                    'stock' => $prize['stock'] ?? 0,
                    'raffled' => $prize['raffled'] ?? 0,
                    'is_grand_prize' => $prize['is_grand_prize'] ?? $prize['is_grandprize'] ?? 0,
                ];
            }, $prizes);

            return view('admin/select_prize', ['prizes' => $prizes]);
        } catch (\Exception $e) {
            log_message('error', 'Error loading select prize: ' . $e->getMessage());
            return view('admin/select_prize', [
                'prizes' => [],
                'error' => 'Error loading prizes: ' . $e->getMessage()
            ]);
        }
    }

   public function savePrizeSelection()
    {
        $prizeId = $this->request->getPost('prize_id');
        $session = session();
        $session->set('raffle_prize_id', $prizeId);

        if ($this->request->isAJAX()) {
            return $this->response->setStatusCode(200)->setBody('OK');
        }

        return redirect()->to('/admin/select-prize');
    }

    public function raffle()
    {
        $errorView = $this->checkDatabase();
        if ($errorView) return $errorView;

        try {
            $session = session();
            $selectedPrizeId = $session->get('raffle_prize_id');

            if (!$selectedPrizeId) {
                return redirect()->to('/admin/select-prize');
            }

            $prizeModel = new PrizeModel();
            $registrantModel = new RegistrantModel();
            $winnerModel = new WinnerModel();

        $selectedPrize = $prizeModel->find($selectedPrizeId);
        if (!$selectedPrize) {
            return redirect()->to('/admin/select-prize');
        }

        // Get all winners of this prize
        $alreadyWinners = $winnerModel->findAll();
        $excludedIds = array_column($alreadyWinners, 'registrant_id');

        //  Get only registrants who have NOT won any prize yet
        if (!empty($excludedIds)) {
            $registrants = $registrantModel
                ->whereNotIn('id', $excludedIds)
                ->findAll();
        } else {
            $registrants = $registrantModel->findAll();
        }

            $names = array_map(function ($row) {
                $company = $row['company'] ?? $row['bisnis_unit'] ?? '-';
                return $row['name'] . '|' . $row['id'] . '|' . ($row['phone_number'] ?? '-') . '|' . $company;
            }, $registrants);

            return view('admin/raffle', [
                'selectedPrizeId'    => $selectedPrizeId,
                'selectedPrizeStock' => $selectedPrize['stock'],
                'names'              => $names,
                'prizeName'          => $selectedPrize['name'] ?? $selectedPrize['prize_name'] ?? '',
                'isRaffled'          => $selectedPrize['raffled'] ?? 0 
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error loading raffle: ' . $e->getMessage());
            return redirect()->to('/admin/select-prize')->with('error', 'Error loading raffle: ' . $e->getMessage());
        }
    }

    public function saveWinnerBatch()
    {
        $rawInput = $this->request->getBody();
        $json = json_decode($rawInput, true);

        $prizeId = $json['prize_id'] ?? null;
        $winners = $json['winners'] ?? null;

        if (!$prizeId || !is_array($winners) || empty($winners)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Invalid prize ID or winner list.'
            ]);
        }

        $winnerModel = new WinnerModel();
        $registrantModel = new RegistrantModel();
        $prizeModel = new PrizeModel();

        $prize = $prizeModel->find($prizeId);
        if (!$prize || ($prize['raffled'] ?? 0) == 1) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'This prize has already been raffled.'
            ]);
        }

        $existingWinners = $winnerModel->select('registrant_id')->findAll();
        $alreadyWonIds = array_column($existingWinners, 'registrant_id');

        $insertData = [];
        foreach ($winners as $winner) {
            if (!isset($winner['id'])) continue;

            $registrantId = $winner['id'];
            if (in_array($registrantId, $alreadyWonIds)) continue;

            $insertData[] = [
                'registrant_id' => $registrantId,
                'prize_id' => $prizeId,
                'status' => 'Pending',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $alreadyWonIds[] = $registrantId;
        }

        if (empty($insertData)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'All selected winners have already won prizes.'
            ]);
        }

        $winnerModel->insertBatch($insertData);
        $prizeModel->update($prizeId, ['raffled' => 1]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function updateWinnerBatch()
    {
        $rawInput = $this->request->getBody();
        $json = json_decode($rawInput, true);

        $prizeId = $json['prize_id'] ?? null;
        $winners = $json['winners'] ?? null;

        if (!$prizeId || !is_array($winners)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Invalid prize ID or winner list.'
            ]);
        }

        $winnerModel = new WinnerModel();
        $registrantModel = new RegistrantModel();
        $prizeModel = new PrizeModel();

        $prize = $prizeModel->find($prizeId);
        if (!$prize) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Prize not found.'
            ]);
        }

        // Delete existing winners for this prize
        $winnerModel->where('prize_id', $prizeId)->delete();

        // Filter valid winners
        $validWinners = array_filter($winners, function($w) {
            return isset($w['id']) && $w['id'];
        });

        if (empty($validWinners)) {
            // No winners to save, reset raffled status
            $prizeModel->update($prizeId, ['raffled' => 0]);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Winners cleared.']);
        }

        $existingWinners = $winnerModel->select('registrant_id')->where('prize_id !=', $prizeId)->findAll();
        $alreadyWonIds = array_column($existingWinners, 'registrant_id');

        $insertData = [];
        foreach ($validWinners as $winner) {
            $registrantId = $winner['id'];
            if (in_array($registrantId, $alreadyWonIds)) continue;

            $insertData[] = [
                'registrant_id' => $registrantId,
                'prize_id' => $prizeId,
                'status' => 'Pending',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $alreadyWonIds[] = $registrantId;
        }

        if (!empty($insertData)) {
            $winnerModel->insertBatch($insertData);
        }
        
        $prizeModel->update($prizeId, ['raffled' => 1]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function selectGrandPrize()
    {
        $errorView = $this->checkDatabase();
        if ($errorView) return $errorView;

        try {
            $prizeModel = new PrizeModel();
            $grandPrizes = $prizeModel->select('id, name, prize_name, image, images, stock, raffled, is_grand_prize, is_grandprize')
                                      ->where('(is_grand_prize = 1 OR is_grandprize = 1)')
                                      ->findAll();
            
            // Normalize data untuk view
            $grandPrizes = array_map(function($prize) {
                return [
                    'id' => $prize['id'],
                    'name' => $prize['name'] ?? $prize['prize_name'] ?? '',
                    'image' => $prize['image'] ?? $prize['images'] ?? '',
                    'stock' => $prize['stock'] ?? 0,
                    'raffled' => $prize['raffled'] ?? 0,
                    'is_grand_prize' => $prize['is_grand_prize'] ?? $prize['is_grandprize'] ?? 0,
                ];
            }, $grandPrizes);

            return view('admin/select-grandprize', ['grandPrizes' => $grandPrizes]);
        } catch (\Exception $e) {
            log_message('error', 'Error loading grand prize: ' . $e->getMessage());
            return view('admin/select-grandprize', [
                'grandPrizes' => [],
                'error' => 'Error loading grand prizes: ' . $e->getMessage()
            ]);
        }
    }

    public function saveGrandPrizeSelection()
    {
        $prizeId = $this->request->getPost('prize_id');
        $session = session();
        $session->set('raffle_prize_id', $prizeId);

        if ($this->request->isAJAX()) {
            return $this->response->setStatusCode(200)->setBody('OK');
        }

        return redirect()->to('/admin/select-grandprize');
    }

    public function grandPrize($prizeId)
    {
        $errorView = $this->checkDatabase();
        if ($errorView) return $errorView;

        try {
            $prizeModel = new PrizeModel();
            $registrantModel = new RegistrantModel();
            $winnerModel = new WinnerModel();

            $selectedPrize = $prizeModel->find($prizeId);

        if ($selectedPrize['raffled'] ?? 0) {
            return redirect()->to('/admin/select-grandprize')->with('error', 'Grand prize sudah diundi.');
        }

        if (!$selectedPrize) {
            return redirect()->to('/admin/prizes')->with('error', 'Prize not found');
        }

        $selectedPrizeStock = $selectedPrize['stock'];

        $existingWinners = $winnerModel->select('registrant_id')->findAll();
        $alreadyWonIds = array_column($existingWinners, 'registrant_id');

        if (!empty($alreadyWonIds)) {
            $eligibleRegistrants = $registrantModel
                ->whereNotIn('id', $alreadyWonIds)
                ->findAll();
        } else {
            $eligibleRegistrants = $registrantModel->findAll();
        }

        $names = [];
        foreach ($eligibleRegistrants as $r) {
            $company = $r['company'] ?? $r['bisnis_unit'] ?? '-';
            $names[] = $r['name'] . '|' . $r['id'] . '|' . $r['phone_number'] . '|' . $company;
        }

        $nextPrize = $prizeModel
            ->where('raffled', 0)
            ->where('id >', $prizeId)
            ->orderBy('id', 'asc')
            ->first();
        $nextPrizeId = $nextPrize ? $nextPrize['id'] : null;

            return view('admin/grandprize', [
                'selectedPrize'       => $selectedPrize,
                'prizeName'           => $selectedPrize['name'] ?? $selectedPrize['prize_name'] ?? '',
                'selectedPrizeId'     => $selectedPrize['id'],
                'selectedPrizeStock'  => $selectedPrizeStock,
                'names'               => $names,
                'nextPrizeId'         => $nextPrizeId,
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error loading grand prize: ' . $e->getMessage());
            return redirect()->to('/admin/select-grandprize')->with('error', 'Error loading grand prize: ' . $e->getMessage());
        }
    }

    public function syncGoogleSheet()
    {
        helper('text');

        $sheetService = new \App\Services\GoogleSheetService();
        $registrantModel = new RegistrantModel();

        $spreadsheetId = '1XW10bVxZgbJ-rxLwPh1GM2ZPutwQ7uVf_L7DTOb1isQ';
        $range = 'Form Responses 1';

        $values = $sheetService->getSheetData($spreadsheetId, $range);

        $new = 0;

        foreach (array_slice($values, 1) as $row) { // Skip header row
            if (count($row) < 5) continue;

            $inputedTime = $row[0];
            $name = $row[1];
            $email = $row[2];
            $phone = $row[3];
            $company = $row[4];

            if ($registrantModel->where('email', $email)->countAllResults() > 0) continue;

            $registrantModel->save([
                'inputed_time' => $inputedTime,
                'name'         => $name,
                'email'        => $email,
                'phone_number' => $phone,
                'company'      => $company,
            ]);

            $new++;
        }

        return redirect()->to('/admin/registrants')->with('message', "$new new registrants synced.");
    }
}
