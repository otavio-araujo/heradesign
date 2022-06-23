<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Rotas para gerar a Proposta em PDF */
Route::get('/pdf/{record}', [PDFController::class, 'pdf'])->name('proposal.pdf');
