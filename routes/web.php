<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetsController;

Route::match(['get', 'post'],'/', [PetsController::class, 'index']);
