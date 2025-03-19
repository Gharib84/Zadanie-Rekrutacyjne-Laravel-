<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetsController;

Route::match(['get', 'post'],'/', [PetsController::class, 'index'])->name('pets.index');
Route::post('/store', [PetsController::class, 'store'])->name('pets.store');
Route::delete('/destroy/{id}', [PetsController::class, 'destroy'])->name('pets.destroy');
Route::match(['get', 'post'],'/edit/{id}',[PetsController::class,'edit'])->name('pet.edit');