<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrosController;


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

Route::get('/', function(){return redirect('registros');});

Route::resource('registros', RegistrosController::class);

Route::post('consulta_cep', [RegistrosController::class, 'consultaCep'])->name('consulta_cep');
