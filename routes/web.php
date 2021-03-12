<?php

use App\Http\Controllers\ImePayController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('ime-pay/form', [ImePayController::class, 'form'])->name('ime-pay.form');
Route::post('ime-pay/cancel', [ImePayController::class, 'cancel'])->name('ime-pay.cancel');
Route::post('ime-pay/response', [ImePayController::class, 'response'])->name('ime-pay.response');
