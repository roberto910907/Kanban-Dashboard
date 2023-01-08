<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;

Route::controller(ColumnController::class)->prefix('columns')->group(function () {
    Route::get('list', 'list')->name('column.list');
    Route::post('add', 'store')->name('column.store');
});

Route::controller(CardController::class)->prefix('cards')->group(function () {
    Route::get('/{column}/list', 'list')->name('card.list');
    Route::post('/{column}/add', 'store')->name('card.store');
});
