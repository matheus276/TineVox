<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RamalController;

Route::get('/ramais', [RamalController::class, 'index']);