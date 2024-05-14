<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ModuleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PageController::class, 'getHome'])->name('home');

Route::prefix('modules')->group(function () {
    Route::get('/bitcoin_price', [ModuleController::class, 'getBitcoinPrice'])->name('modules.bitcoin_price');
    Route::get('/graph', [ModuleController::class, 'getGraph'])->name('modules.graph');
    Route::get('/blockchain_stats', [ModuleController::class, 'getBlockchainStats'])->name('modules.blockchain_stats');
    Route::get('/last_block', [ModuleController::class, 'getLastBlock'])->name('modules.last_block');
    Route::get('/pools', [ModuleController::class, 'getPools'])->name('modules.pools');
    Route::get('/long_term', [ModuleController::class, 'getLongTerm'])->name('modules.long_term');
});
