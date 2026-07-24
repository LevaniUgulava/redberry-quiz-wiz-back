<?php

use App\Http\Controllers\FilterController;
use Illuminate\Support\Facades\Route;

Route::prefix('filter')->group(function () {
    Route::get('/difficulties', [FilterController::class, 'difficulties'])->name('filter.difficulties');
    Route::get('/categories', [FilterController::class, 'categories'])->name('filter.categories');
});
