<?php

namespace App\Http\Controllers;

use App\Helpers\CacheHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Helpers\MiscHelper;
use App\Helpers\TableHelper;
use Carbon\Carbon;

class ModuleController extends Controller
{
    public function getBitcoinPrice(Request $request) {
        $unpaused = filter_var($request->query('unpaused'), FILTER_VALIDATE_BOOLEAN) ?? false;

        $latestPrice = Cache::store('octane')->get("latest_price");
        $penultimatePrice = Cache::store('octane')->get("penultimate_price");
        $isHigher = null;
        if(!is_null($penultimatePrice)) {
            $isHigher = $latestPrice > $penultimatePrice;
        }
        $latestPrice = MiscHelper::formatNumber($latestPrice, 2);

        return view("components.modules.bitcoin_price", ['latestPrice' => $latestPrice, 'isHigher' => $isHigher, 'unpaused' => $unpaused]);
    }

    public function getGraph() {
        $vals = TableHelper::getAllPrices();

        return view("components.modules.graph", ["data" => $vals]);
    }

    public function getBlockchainStats() {
        $hashrate = CacheHelper::readCache("hashrate");
        $avgHashes = CacheHelper::readCache("avg_hashes");
        $blockFindProb = CacheHelper::readCache("block_find_prob");
        $avgInterval = CacheHelper::readCache("avg_interval");
        $unconfirmedTx = CacheHelper::readCache("unconfirmed_tx");

        // if some property is not present in the cache
        if(in_array(null, [$hashrate, $avgHashes, $blockFindProb, $avgInterval, $unconfirmedTx], true)) {
            [$hashrate, $avgHashes, $blockFindProb, $avgInterval, $unconfirmedTx] = CacheHelper::renewBlockchainStats();
        }

        $hashrate = MiscHelper::formatNumber($hashrate);
        $avgHashes = MiscHelper::formatNumber($avgHashes);
        $blockFindProb = MiscHelper::formatSmallDecimalNumber($blockFindProb);
        $avgInterval = MiscHelper::formatNumber($avgInterval);
        $unconfirmedTx = MiscHelper::formatNumber($unconfirmedTx);

        return view("components.modules.blockchain_stats", [
            "hashrate" => $hashrate,
            "avgHashes" => $avgHashes,
            "blockFindProb" => $blockFindProb,
            "avgInterval" => $avgInterval,
            "unconfirmedTx" => $unconfirmedTx,
        ]);
    }

    public function getLastBlock(Request $request) {
        $hash = CacheHelper::readCache("last_block_hash");
        $height = CacheHelper::readCache("last_block_height");
        $timestamp = CacheHelper::readCache("last_block_timestamp");
        $txCount = CacheHelper::readCache("last_block_tx_count");

        // if some property is not present in the cache
        if(in_array(null, [$hash, $height, $timestamp, $txCount], true)) {
            [$hash, $height, $timestamp, $txCount] = CacheHelper::renewLastBlock();
        }

        $height = MiscHelper::formatNumber($height);
        $txCount = MiscHelper::formatNumber($txCount);
        $carbon = Carbon::createFromTimestamp($timestamp)->setTimezone('Europe/Prague');
        $time = $carbon->format("H:i:s");
        $date = $carbon->format("d. m. Y");

        return view("components.modules.last_block", ["hash" => $hash, "height" => $height, "time" => $time, "date" => $date, "txCount" => $txCount]);
    }

    public function getPools() {
        list($labels, $data) = TableHelper::getAllPools();

        return view("components.modules.pools", ["data" => $data, "labels" => $labels]);
    }

    public function getLongTerm() {
        $last24hTx = CacheHelper::readCache("last_24h_tx");
        $last24hBtcSent = CacheHelper::readCache("last_24h_btc_sent");
        $totalBlocks = CacheHelper::readCache("total_blocks");
        $totalBtc = CacheHelper::readCache("total_btc");

        // if some property is not present in the cache
        if(in_array(null, [$last24hTx, $last24hBtcSent, $totalBlocks, $totalBtc], true)) {
            [$last24hTx, $last24hBtcSent, $totalBlocks, $totalBtc] = CacheHelper::renewLongTerm();
        }

        $last24hTx = MiscHelper::formatNumber($last24hTx);
        $last24hBtcSent = MiscHelper::formatNumber($last24hBtcSent);
        $totalBlocks = MiscHelper::formatNumber($totalBlocks);
        $totalBtc = MiscHelper::formatNumber($totalBtc);
        $maximumBtc = MiscHelper::formatNumber(config("constants.MAXIMUM_BTC"));

        return view("components.modules.long_term", ["last24hTx" => $last24hTx, "last24hBtcSent" => $last24hBtcSent, "totalBlocks" => $totalBlocks, "totalBtc" => $totalBtc, "maximumBtc" => $maximumBtc]);
    }
}
