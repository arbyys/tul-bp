<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class IntervalTaskHelper {

    public static function every10Seconds(): void {
        $price1 = FetchHelper::fetchEndpoint(env('ENDPOINT_PRICE_1', null));
        $price2 = FetchHelper::fetchEndpoint(env('ENDPOINT_PRICE_2', null));

        if(!is_null($price1) && !is_null($price2)) {
            $price1_parsed = $price1['USD']['last'];
            $price2_parsed = $price2['data']['amount'];

            $mean = ($price1_parsed + $price2_parsed) / 2;

            $latest = Cache::store('octane')->get('latest_price');
            Cache::store('octane')->put('penultimate_price', $latest);
            Cache::store('octane')->put('latest_price', $mean);

            TableHelper::addPriceValue($mean);
        }
    }

    public static function every1Hour(): void {
        $pools = FetchHelper::fetchEndpoint(env('ENDPOINT_POOLS', null));

        if(!is_null($pools)) {
            TableHelper::alignPools($pools);
        }
    }
}
