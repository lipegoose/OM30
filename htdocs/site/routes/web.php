<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacientesController;


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

Route::get('/', function(){return redirect('pacientes');});

Route::get('pacientes/table_data', [PacientesController::class, 'tableData']);
Route::post('pacientes/importar', [PacientesController::class, 'importar'])->name('pacientes.importar');
Route::resource('pacientes', PacientesController::class);

Route::post('consulta_cep', [PacientesController::class, 'consultaCep'])->name('consulta_cep');
