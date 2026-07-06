<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RamalController;
use App\Http\Controllers\RecordingController;
use App\Http\Controllers\NewRamalController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CondominioController;
use App\Http\Middleware\IsAdmin;

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

Route::get('/users', [UsersController::class, 'index']);
Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
Route::post('/users', [UsersController::class, 'store'])->name('users.store');
Route::get('/users/{idUser}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::put('/users/{idUser}', [UsersController::class, 'update'])->name('users.update');
Route::delete('/users/{idUser}', [UsersController::class, 'destroy'])->name('users.destroy');

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

// Rotas de Condominios - Apenas para Administradores
Route::middleware([IsAdmin::class])->group(function () {
    Route::get('/condominios', [CondominioController::class, 'index'])->name('condominios.index');
    Route::get('/condominios/create', [CondominioController::class, 'create'])->name('condominios.create');
    Route::post('/condominios', [CondominioController::class, 'store'])->name('condominios.store');
    Route::get('/condominios/{id}/edit', [CondominioController::class, 'edit'])->name('condominios.edit');
    Route::put('/condominios/{id}', [CondominioController::class, 'update'])->name('condominios.update');
    Route::delete('/condominios/{id}', [CondominioController::class, 'destroy'])->name('condominios.destroy');
});