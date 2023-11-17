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

Route::get('/create', function () {
    return view('create');
})->name('create.form');



Route::post('/cookie/create', [CookieController::class, 'store']);
Route::get('/cookie', [CookieController::class, 'index']);

Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
Route::post('/employee/create', [EmployeeController::class, 'store'])->name('employee.create');
Route::delete('/employee/{employee}', [EmployeeController::class, 'destroy']);
Route::get('/employee/{employee}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
Route::put('/employee/{employee}', [EmployeeController::class, 'update'])->name('employee.update');
