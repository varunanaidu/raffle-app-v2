<?php

namespace App\Services;

use Google_Client;
use Google_Service_Sheets;

class GoogleSheetService
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(WRITEPATH . 'credentials/google-sheet.json');
        $this->client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);

        $this->service = new Google_Service_Sheets($this->client);
    }

    /**
     * Fetch sheet data by spreadsheetId and range
     *
     * @param string $spreadsheetId
     * @param string $range (e.g. 'Form Responses 1')
     * @return array
     */
    public function getSheetData(string $spreadsheetId, string $range): array
    {
        try {
            $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            if (empty($values)) {
                return [];
            }

            return $values; // Let controller decide to skip header if needed
        } catch (\Exception $e) {
            log_message('error', 'GoogleSheetService error: ' . $e->getMessage());
            return [];
        }
    }
}
