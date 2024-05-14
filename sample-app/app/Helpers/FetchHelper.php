<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchHelper {

    public static function fetchEndpoint($endpoint): mixed {
        if(is_null($endpoint)){
            return null;
        }
        try {
            $response = Http::get($endpoint);

            if ($response->successful()) {
                return $response->json();
            }
            throw new Exception("Response was not succesfull with error code {$response->status()}");
        } catch (\Exception $e) {
            Log::error("Error while fetching endpoint {$endpoint}: " . $e->getMessage());
            return null;
        }
    }
}
