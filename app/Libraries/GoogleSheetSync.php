<?php namespace App\Libraries;

use Google_Client;
use Google_Service_Sheets;
use App\Models\RegistrantModel;

class GoogleSheetSync
{
    protected $sheetId = '1XW10bVxZgbJ-rxLwPh1GM2ZPutwQ7uVf_L7DTOb1isQ'; 
    protected $range = 'Form Responses 1'; 

    public function importFromSheet()
    {
        $client = new Google_Client();
        $client->setAuthConfig(WRITEPATH . 'credentials/google-sheet.json');
        $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);

        $service = new Google_Service_Sheets($client);

        $response = $service->spreadsheets_values->get($this->sheetId, $this->range);
        $values = $response->getValues();

        $model = new RegistrantModel();

        if (!empty($values)) {
            foreach ($values as $row) {
                if (!isset($row[0])) continue;

                $name = $row[0];
                $email = $row[1] ?? null;

                // Avoid duplicate names (or use email for better uniqueness)
                if (!$model->where('name', $name)->first()) {
                    $model->insert([
                        'name'  => $name,
                        'email' => $email,
                    ]);
                }
            }
        }
        
    }
}
