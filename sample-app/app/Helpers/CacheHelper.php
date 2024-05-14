<?php

namespace App\Helpers;

use Laravel\Octane\Facades\Octane;
use Illuminate\Support\Facades\Cache;

class CacheHelper {

    public static function readCache($property): mixed {
        if(!Cache::store("octane")->has($property)) {
            return null;
        }
        return Cache::store('octane')->get($property);
    }

    public static function renewBlockchainStats(): array {
        [$hashrate, $avgHashes, $blockFindProb, $avgInterval, $unconfirmedTx] = Octane::concurrently([
            fn() => FetchHelper::fetchEndpoint(env("ENDPOINT_HASHRATE", null)),
            fn() => FetchHelper::fetchEndpoint(env("ENDPOINT_AVG_HASHES_NEEDED", null)),
            fn() => FetchHelper::fetchEndpoint(env("ENDPOINT_BLOCK_FIND_PROB", null)),
            fn() => FetchHelper::fetchEndpoint(env("ENDPOINT_AVG_INTERVAL", null)),
            fn() => FetchHelper::fetchEndpoint(env("ENDPOINT_UNCONFIRMED_TX", null)),
        ]);

        $interval = env("RENEW_INTERVAL_BLOCKCHAIN_STATS", 60);

        Cache::store("octane")->put("hashrate", $hashrate, $interval);
        Cache::store("octane")->put("avg_hashes", $avgHashes, $interval);
        Cache::store("octane")->put("block_find_prob", $blockFindProb, $interval);
        Cache::store("octane")->put("avg_interval", $avgInterval, $interval);
        Cache::store("octane")->put("unconfirmed_tx", $unconfirmedTx, $interval);

        return [$hashrate, $avgHashes, $blockFindProb, $avgInterval, $unconfirmedTx];
    }

    public static function renewLastBlock(): array {
        [$lastMinedBlock] = Octane::concurrently([
            fn() => FetchHelper::fetchEndpoint(env('ENDPOINT_LAST_BLOCK', null)),
        ]);

        $interval = env("RENEW_INTERVAL_LAST_BLOCK", 60);

        $hash = $lastMinedBlock["hash"] ?? "";
        $height = $lastMinedBlock["height"] ?? 0;
        $timestamp = $lastMinedBlock["time"] ?? 0;
        $txCount = count($lastMinedBlock["txIndexes"] ?? []);

        Cache::store('octane')->put('last_block_hash', $hash, $interval);
        Cache::store('octane')->put('last_block_height', $height, $interval);
        Cache::store('octane')->put('last_block_timestamp', $timestamp, $interval);
        Cache::store('octane')->put('last_block_tx_count', $txCount, $interval);

        return [$hash, $height, $timestamp, $txCount];
    }

    public static function renewLongTerm(): array {
        $totalBlocks = null;
        $totalBtc = null;

        [$last24hTx, $last24hBtcSent, $stats] = Octane::concurrently([
            fn() => FetchHelper::fetchEndpoint(env('ENDPOINT_LAST_24H_TX', null)),
            fn() => FetchHelper::fetchEndpoint(env('ENDPOINT_LAST_24H_BTC_SENT', null)),
            fn() => FetchHelper::fetchEndpoint(env('ENDPOINT_STATS', null)),
        ]);

        $interval = env("RENEW_INTERVAL_LONG_TERM", 3600);

        $last24hBtcSent = MiscHelper::convertSatsToBTC($last24hBtcSent);

        Cache::store('octane')->put('last_24h_tx', $last24hTx, $interval);
        Cache::store('octane')->put('last_24h_btc_sent', $last24hBtcSent, $interval);

        if(!is_null($stats)) {
            $totalBlocks = $stats["n_blocks_total"] ?? 0;
            $totalBtc = $stats["totalbc"] ?? 0;

            $totalBtc = MiscHelper::convertSatsToBTC($totalBtc);

            Cache::store('octane')->put('total_blocks', $totalBlocks, $interval);
            Cache::store('octane')->put('total_btc', $totalBtc, $interval);
        }

        return [$last24hTx, $last24hBtcSent, $totalBlocks, $totalBtc];
    }
}
