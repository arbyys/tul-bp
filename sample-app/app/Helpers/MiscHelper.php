<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Laravel\Octane\Facades\Octane;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MiscHelper {
    public static function formatNumber($number, $decimals=0): ?string {
        if(!is_numeric($number)) {
            return null;
        }

        if(is_float($number)) {
            $number = round($number, 2);
        }
        return number_format($number, $decimals, '.', ',');
    }

    public static function formatSmallDecimalNumber($number): string {
        $stripped = sprintf("%.30f", $number);
        list($integer_str, $decimal_str) = explode('.', $stripped);
        $decimal_shortened = preg_replace('/(0*)([1-9]{3}).*/', '${1}${2}', $decimal_str);
        return $integer_str . '.' . $decimal_shortened;
    }

    public static function convertSatsToBTC($number): float|int {
        return $number / config("constants.SATS_IN_BTC");
    }
}
