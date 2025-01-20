<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller 
{
    private $dataSource = 'https://bit.ly/48ejMhW';
    private $cacheTimeout = 3600; // 1 hour

    private function fetchData()
    {
        return Cache::remember('api_data', $this->cacheTimeout, function () {
            try {
                $client = new Client();
                $response = $client->get($this->dataSource);
                $jsonData = json_decode($response->getBody(), true);
                
                if (!isset($jsonData['DATA'])) {
                    return null;
                }

                // Parse the CSV-like data
                $lines = explode("\n", $jsonData['DATA']);
                $headers = explode("|", array_shift($lines)); // Remove and parse headers
                
                $data = [];
                foreach ($lines as $line) {
                    if (empty($line)) continue;
                    $values = explode("|", $line);
                    $data[] = array_combine($headers, $values);
                }
                
                return $data;
            } catch (GuzzleException $e) {
                return null;
            }
        });
    }

    public function searchByName($nama): JsonResponse 
    {
        $data = $this->fetchData();
        if (!$data) {
            return response()->json(['error' => 'Unable to fetch data'], 500);
        }
        
        $result = collect($data)->where('NAMA', $nama)->first();
        return response()->json($result ?: ['message' => 'No data found']);
    }

    public function searchByNIM($nim): JsonResponse 
    {
        $data = $this->fetchData();
        if (!$data) {
            return response()->json(['error' => 'Unable to fetch data'], 500);
        }
        
        $result = collect($data)->where('NIM', $nim)->first();
        return response()->json($result ?: ['message' => 'No data found']);
    }

    public function searchByDate($ymd): JsonResponse 
    {
        $data = $this->fetchData();
        if (!$data) {
            return response()->json(['error' => 'Unable to fetch data'], 500);
        }
        
        $results = collect($data)->where('YMD', $ymd)->values();
        return response()->json(
            $results->isEmpty() 
                ? ['message' => 'No data found'] 
                : ['count' => $results->count(), 'data' => $results->all()]
        );
    }
}