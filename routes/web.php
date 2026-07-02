<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RamalController;
use App\Http\Controllers\RecordingController;
use App\Http\Controllers\NewRamalController;
use App\Http\Controllers\LogsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'form']);
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/api/ramais', [RamalController::class, 'index']);

Route::get('/recording', [RecordingController::class, 'index']);

Route::get('/logs', [LogsController::class, 'index']);

Route::get('/recording/download/{arquivo}', [RecordingController::class, 'download'])
    ->where('arquivo', '.*')
    ->name('recording.download');

Route::get('/recording/play/{arquivo}', [RecordingController::class, 'play'])
    ->where('arquivo', '.*')
    ->name('recording.play');


Route::get('/new_ramal', [NewRamalController::class, 'index'])
    ->name('ramal.form');

Route::post('/new_ramal', [NewRamalController::class, 'criar_ramal'])
    ->name('ramal.criar');