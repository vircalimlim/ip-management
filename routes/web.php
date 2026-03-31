<?php

use App\Http\Controllers\IpRecordController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register')
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth:sanctum'])->group(function () {
    // Route::get('/ip-record', function () {
    //     return Inertia::render('IpRecord');
    // })->middleware(['verified'])->name('ip-record');
    Route::get('/ip-record',            [IpRecordController::class, 'index'])->name('ip-record.index');
    Route::post('/ip-record',           [IpRecordController::class, 'store'])->name('ip-record.store');
    Route::put('/ip-record/{id}',       [IpRecordController::class, 'update'])->name('ip-record.update');
    Route::delete('/ip-record/{id}',    [IpRecordController::class, 'destroy'])->name('ip-record.destroy');
});

Route::middleware(['auth:sanctum', RoleMiddleware::class . ':superadmin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
