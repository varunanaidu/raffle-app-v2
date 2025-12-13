<?php

namespace App\Controllers;

use App\Models\RegistrantModel;

class Registration extends BaseController
{
    public function index(): string
    {
        return view('registration');
    }

    public function submit()
    {
        $request = service('request');
        $isAJAX = $request->isAJAX() || $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest';
        
        // Set response type ke JSON untuk AJAX request di awal
        if ($isAJAX) {
            $this->response->setContentType('application/json');
        }
        
        try {
            
            $validation = \Config\Services::validation();
            $validation->setRules([
                'name' => 'required|min_length[3]',
                'bisnis_unit' => 'required',
                'phone_number' => 'required|min_length[10]'
            ]);

            if (!$validation->withRequest($request)->run()) {
                if ($isAJAX) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Mohon lengkapi semua field yang wajib diisi',
                        'errors' => $validation->getErrors()
                    ]);
                }
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            // Check database connection
            if (!$this->checkDatabaseExtension()) {
                $errorMsg = $this->getDatabaseErrorMessage();
                if ($isAJAX) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => $errorMsg
                    ]);
                }
                return redirect()->back()->withInput()->with('error', $errorMsg);
            }

            // Test database connection
            try {
                $db = \Config\Database::connect();
                $db->initialize();
                // Test query untuk memastikan koneksi berfungsi
                $db->query("SELECT 1");
            } catch (\Exception $dbError) {
                $errorMessage = $dbError->getMessage();
                log_message('error', 'Database connection error: ' . $errorMessage);
                
                // Pesan error yang lebih informatif
                $errorMsg = 'Error koneksi database. ';
                
                if (strpos($errorMessage, 'Access denied') !== false) {
                    $errorMsg .= 'Username atau password salah. ';
                } elseif (strpos($errorMessage, "doesn't exist") !== false || strpos($errorMessage, 'Unknown database') !== false) {
                    $errorMsg .= 'Database tidak ditemukan. Pastikan database sudah dibuat. ';
                } elseif (strpos($errorMessage, "Can't connect") !== false) {
                    $errorMsg .= 'Tidak dapat terhubung ke MySQL server. Pastikan MySQL sudah berjalan. ';
                } elseif (strpos($errorMessage, 'mysqli') !== false && strpos($errorMessage, 'not loaded') !== false) {
                    $errorMsg .= 'Extension mysqli tidak diaktifkan. ';
                    $errorMsg .= 'Buka file php.ini, cari "extension=mysqli" dan hapus tanda ";" di depannya, lalu restart Apache/XAMPP. ';
                    $errorMsg .= 'Atau buka: ' . base_url('check_php.php') . ' untuk panduan lengkap. ';
                } else {
                    $errorMsg .= $errorMessage . ' ';
                }
                
                $errorMsg .= 'Periksa konfigurasi di app/Config/Database.php';
                
                if ($isAJAX) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => $errorMsg,
                        'debug' => ENVIRONMENT !== 'production' ? $errorMessage : null
                    ]);
                }
                return redirect()->back()->withInput()->with('error', $errorMsg);
            }

            $model = new RegistrantModel();
            
            $data = [
                'name' => $request->getPost('name'),
                'bisnis_unit' => $request->getPost('bisnis_unit'),
                'phone_number' => $request->getPost('phone_number')
            ];

            $insertId = $model->insert($data);
            
            if (!$insertId) {
                $errors = $model->errors();
                $errorMsg = !empty($errors) ? implode(', ', $errors) : 'Gagal menyimpan data ke database';
                
                log_message('error', 'Registration insert failed: ' . $errorMsg);
                
                if ($isAJAX) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => $errorMsg,
                        'errors' => $errors
                    ]);
                }
                return redirect()->back()->withInput()->with('error', $errorMsg);
            }
            
            if ($isAJAX) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Registrasi berhasil!',
                    'redirect' => '/register/success'
                ]);
            }
            
            return redirect()->to('/register/success');
            
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            $errorTrace = $e->getTraceAsString();
            
            log_message('error', 'Registration error: ' . $errorMessage . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            log_message('error', 'Trace: ' . $errorTrace);
            
            // Selalu tampilkan detail error untuk debugging
            $errorMsg = 'Terjadi kesalahan saat menyimpan data: ' . $errorMessage;
            
            // Cek apakah error terkait database
            if (strpos($errorMessage, 'database') !== false || 
                strpos($errorMessage, 'connection') !== false ||
                strpos($errorMessage, 'Access denied') !== false) {
                $errorMsg = 'Error koneksi database. Pastikan database sudah dikonfigurasi dengan benar di app/Config/Database.php';
            }
            
            if ($isAJAX) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $errorMsg,
                    'debug' => [
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'message' => $errorMessage
                    ]
                ]);
            }
            return redirect()->back()->withInput()->with('error', $errorMsg);
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $errorTrace = $e->getTraceAsString();
            
            log_message('error', 'Registration fatal error: ' . $errorMessage . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            log_message('error', 'Trace: ' . $errorTrace);
            
            $errorMsg = 'Terjadi kesalahan fatal saat menyimpan data: ' . $errorMessage;
            
            if ($isAJAX) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $errorMsg,
                    'debug' => [
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'message' => $errorMessage
                    ]
                ]);
            }
            return redirect()->back()->withInput()->with('error', $errorMsg);
        }
    }

    public function success(): string
    {
        return view('success');
    }
}

