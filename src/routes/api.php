<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionPinController;
use App\Http\Controllers\WalletController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'auth'], function () {
    Route::post('login',  [AuthController::class,'postLogin'])->name('login');
    Route::post('register', [AuthController::class,'create'])->name('auth.registration');
});


Route::prefix('otp')->group(function () {
    Route::post('/generate', [AuthController::class,'SendSms'])->name('user.update_profile');
    Route::post('/verify', [AuthController::class,'VerifySms'])->name('user.update_profile');
});

Route::middleware('auth:api')->group(function () {
    Route::get('/logout',  [AuthController::class,'logout']);
    Route::post('/complete', [AuthController::class,'UpdateReg']);
    Route::post('/transaction-pin/create', [TransactionPinController::class,'create']);
    Route::post('/transaction-pin/update', [TransactionPinController::class,'update']);
    Route::post('/transaction-pin/validate', [TransactionPinController::class,'validate']);
});


Route::prefix('profile')->middleware('auth:api')->group(function () {
    Route::get('/logout',  [AuthController::class,'logout'])->name('logout');
    Route::post('/', [ProfileController::class,'update'])->name('user.update_profile');
    Route::get('/', [ProfileController::class,'get'])->name('user.get_profile');
    Route::post('/password', [ProfileController::class,'updatePassword'])->name('password.update');
});



Route::prefix('wallets')->middleware('auth:api')->group(function () {
    Route::post('/', [WalletController::class,'create'])->name('user.update_profile');
    Route::post('/transfer', [WalletController::class,'transfer']);
    Route::get('/', [WalletController::class,'index'])->name('user.update_profile');
    Route::get('holder/{id}', [WalletController::class,'getWalletOwner'])->name('user.update_profile');
});

Route::prefix('transactions')->middleware('auth:api')->group(function () {

    Route::get('/', [TransactionController::class,'index']);
});


Route::prefix('transfers')->middleware('auth:api')->group(function () {
    Route::post('/', [AccountController::class,'transfer'])->name('create.transfer');
});
