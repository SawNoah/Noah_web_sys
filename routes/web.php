<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\EmployeeController;
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

Route::get('/', function () {
    return view('home');
});

Route::post('/cookie/create', [CookieController::class, 'store']);
Route::get('/cookie', [CookieController::class, 'index']);

Route::post('/employee/create', [EmployeeController::class, 'store']);
Route::get('/employee', [EmployeeController::class, 'index']);
