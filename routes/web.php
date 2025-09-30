<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/employes', [EmployeController::class, 'index'])->name('employes.index');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
    Route::get('/companies/{company}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::post('/companies/{company}', [CompanyController::class, 'update'])->name('companies.update');
    Route::put('/companies/{company}', [CompanyController::class, 'update'])->name('companies.update');
    Route::delete('/companies/{company}', [CompanyController::class, 'destroy'])->name('companies.destroy');
    Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('companies.show');

    Route::get('/employes/create', [EmployeController::class, 'create'])->name('employes.create');
    Route::post('/employes', [EmployeController::class, 'store'])->name('employes.store');
    Route::get('/employes/{employe}/edit', [EmployeController::class, 'edit'])->name('employes.edit');
    Route::put('/employes/{employe}', [EmployeController::class, 'update'])->name('employes.update');
    Route::delete('/employes/{employe}', [EmployeController::class, 'destroy'])->name('employes.destroy');
    Route::get('/employes/{employe}', [EmployeController::class, 'show'])->name('employes.show');
});

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::resource('companies', CompanyController::class);
//     Route::post('/companies/{company}', [CompanyController::class, 'update'])->name('companies.update');
//     Route::resource('employes', EmployeController::class);
// });

require __DIR__ . '/auth.php';
