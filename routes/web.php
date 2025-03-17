<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetsController;

Route::match(['get', 'post'],'/', [PetsController::class, 'index'])->name('pets.index');
Route::post('/store', [PetsController::class, 'store'])->name('pets.store');