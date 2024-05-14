<?php

namespace App\Helpers;

use Laravel\Octane\Facades\Octane;
use Carbon\Carbon;

class TableHelper {
    public static function alignPools($pools): void {
        $table = Octane::table('pools');

        foreach ($pools as $key => $value) {
            $table->set($key, [
                'value' => $value,
            ]);
        }
    }

    public static function addPriceValue($price): void {
        if(!Octane::table('data')->exists("writeIndex")) {
            Octane::table('data')->set("writeIndex", [
                'value' => 1,
            ]);
        }

        $currentIndex = Octane::table('data')->get("writeIndex")["value"];
        $maxSize = env("PRICE_TABLE_MAX_SIZE", 180);

        if ($currentIndex >= $maxSize) {
            Octane::table('data')->set("writeIndex", [
                'value' => 1,
            ]);
        } else {
            Octane::table('data')->incr("writeIndex", "value");
        }

        $timestamp = Carbon::now()->getTimestamp();

        Octane::table('prices')->set("item{$currentIndex}", [
            'price' => round($price),
            'timestamp' => $timestamp
        ]);
    }

    public static function getAllPrices(): array {
        $rows = [];
        $table = Octane::table('prices');

        foreach ($table as $key => $value) {
            $rows[] = [$value['timestamp']*1000, $value['price']];
        }

        usort($rows, function($a, $b) {
            return strcmp($a[0], $b[0]);
        });
        return $rows;
    }

    public static function getAllPools(): array {
        $rows = [];
        $table = Octane::table('pools');

        foreach ($table as $key => $value) {
            $rows[] = [$key, $value['value']];
        }

        usort($rows, function($a, $b) {
            return strnatcmp($b[1], $a[1]);
        });

        $labels = array_column($rows, 0);
        $data = array_column($rows, 1);

        return [$labels, $data];
    }
}
