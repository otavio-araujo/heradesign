<?php

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
Route::get('/report/1', function () {
    return view('reports.proposta1');
});

Route::get('/report/2', function () {
    return view('reports.proposta2');
});

Route::get('/pdf/1', [PDFController::class, 'pdf']);
