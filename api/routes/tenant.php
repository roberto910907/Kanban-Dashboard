<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
  'api',
  InitializeTenancyBySubdomain::class,
  PreventAccessFromCentralDomains::class,
])
  ->prefix('api')
  ->group(function () {
      Route::controller(ColumnController::class)->prefix('columns')->group(function () {
          Route::get('list', 'list')->name('column.list');
          Route::post('add', 'store')->name('column.store');
          Route::delete('/{column}/delete', 'delete')->name('column.delete');
      });

      Route::controller(CardController::class)->prefix('cards')->group(function () {
          Route::get('/{column}/list', 'list')->name('card.list');
          Route::post('/{column}/add', 'store')->name('card.store');
          Route::put('/update/{card}', 'update')->name('card.update');
          Route::put('/update/{card}/position', 'updatePosition')->name('card.update_position');
          Route::put('/update/{card}/column', 'updateColumn')->name('card.update_column');
      });
  });
