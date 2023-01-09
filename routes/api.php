<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;

Route::controller(ColumnController::class)->prefix('columns')->group(function () {
    Route::get('list', 'list')->name('column.list');
    Route::post('add', 'store')->name('column.store');
    Route::delete('/{column}/delete', 'delete')->name('column.delete');
});

Route::controller(CardController::class)->prefix('cards')->group(function () {
    Route::get('/{column}/list', 'list')->name('card.list');
    Route::post('/{column}/add', 'store')->name('card.store');
    Route::put('/update/{card}/position', 'updatePosition')->name('card.update_position');
    Route::put('/update/{card}/column', 'updateColumn')->name('card.update_column');
});
