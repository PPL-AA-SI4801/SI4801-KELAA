<?php

use App\Http\Controllers\ClaimController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ClaimController::class, 'index'])->name('claims.index');
Route::get('/klaim-masuk', [ClaimController::class, 'index'])->name('claims.inbox');
