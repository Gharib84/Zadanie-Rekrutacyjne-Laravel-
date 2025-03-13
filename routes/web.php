<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetsController;

Route::get('/', [PetsController::class, 'index']);
