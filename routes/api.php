<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/test_employees", [EmployeeController::class, 'get_employees']);
Route::post("/cookies", [CookieController::class, 'create_cookie']);

Route::get("/test-employee", function () {
    return response()->json([
        'message' => 'Employee List API'
    ]);
});



Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::group(['middleware' => 'jwt'], function () {
    Route::get("/employee", [EmployeeController::class, 'get_employees']);
    Route::post("/employee", [EmployeeController::class, 'create_employee']);
    Route::delete("/employee/{employee}", [EmployeeController::class, 'delete_employee']);
    Route::put('/employee/{employee}', [EmployeeController::class, 'update_employee']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
