<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;

Route::controller(AccountController::class)->prefix('accounts')->group(function () {
    Route::post('create', 'store')->name('account.store');
});
