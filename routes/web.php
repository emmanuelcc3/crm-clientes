<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clientes\ClienteController;
use App\Http\Controllers\Clientes\ClienteExportController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// CRUD de clientes (solo una vez)
Route::resource('clientes', ClienteController::class)->middleware('auth');


// Exportar a Excel y PDF
Route::get('/clientes/export/excel', [ClienteExportController::class, 'exportExcel'])->name('clientes.export.excel');
Route::get('/clientes/export/pdf', [ClienteExportController::class, 'exportPDF'])->name('clientes.export.pdf');