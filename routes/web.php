<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Clientes\ClienteController;
use App\Http\Controllers\Usuarios\UsuarioController;
use App\Http\Controllers\Clientes\ClienteExportController;
use App\Http\Controllers\Roles\RolePermissionController;
use App\Http\Controllers\Roles\RoleController;


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// CRUD de clientes (solo una vez)
Route::resource('clientes', ClienteController::class)->middleware('auth');
Route::post('/usuarios/{id}/restaurar', [UsuarioController::class, 'restaurar'])->name('usuarios.restaurar')->middleware('auth');


// CRUD de usuarios
Route::resource('usuarios', UsuarioController::class)->middleware('auth');
Route::post('clientes/{id}/restaurar', [ClienteController::class, 'restaurar'])->name('clientes.restaurar')->middleware('auth');

// CRUD de roles 
Route::resource('roles', RoleController::class)->middleware('auth');

// CRUD de etiquetas
Route::resource('etiquetas', \App\Http\Controllers\Etiquetas\EtiquetaController::class)->names('etiquetas')->middleware('auth');
Route::post('etiquetas/{id}/restaurar', [\App\Http\Controllers\Etiquetas\EtiquetaController::class, 'restaurar'])->name('etiquetas.restaurar')->middleware('auth');


// Exportar a Excel y PDF
Route::get('/clientes/export/excel', [ClienteExportController::class, 'exportExcel'])
    ->middleware(['auth', 'permission:clientes.exportar'])
    ->name('clientes.export.excel');

Route::get('/clientes/export/pdf', [ClienteExportController::class, 'exportPDF'])
    ->middleware(['auth', 'permission:clientes.exportar'])
    ->name('clientes.export.pdf');


// Asignar permisos a roles (nuevo módulo de permisos)
Route::middleware(['auth'])->group(function () {
    Route::get('/roles/{role}/permisos', [RolePermissionController::class, 'edit'])->name('roles.permisos.edit');
    Route::post('/roles/{role}/permisos', [RolePermissionController::class, 'update'])->name('roles.permisos.update');
});