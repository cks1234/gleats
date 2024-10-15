<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\TestReportCertificateController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin,manager,contractor'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/users/{user}/licenses', [LicenseController::class, 'index'])->name('licenses.index');
    Route::get('api/users/{id}/licenses', [UserController::class, 'get_licenses']);
    Route::get('/users/{user}/licenses/create', [LicenseController::class, 'create'])->name('licenses.create');
    Route::post('/users/{user}/licenses', [LicenseController::class, 'store'])->name('licenses.store');
    Route::get('/licenses/{license}/edit', [LicenseController::class, 'edit'])->name('licenses.edit');
    Route::put('/licenses/{license}', [LicenseController::class, 'update'])->name('licenses.update');
    Route::delete('/licenses/{license}', [LicenseController::class, 'destroy'])->name('licenses.destroy');

    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::get('/clients/{client}/addresses', [AddressController::class, 'index'])->name('clients.addresses.index');
    Route::get('/clients/{client}/addresses/create', [AddressController::class, 'create'])->name('clients.addresses.create');
    Route::post('/clients/{client}/addresses', [AddressController::class, 'store'])->name('clients.addresses.store');
    Route::get('/clients/{client}/addresses/{address}/edit', [AddressController::class, 'edit'])->name('clients.addresses.edit');
    Route::put('/clients/{client}/addresses/{address}', [AddressController::class, 'update'])->name('clients.addresses.update');
    Route::delete('/clients/{client}/addresses/{address}', [AddressController::class, 'destroy'])->name('clients.addresses.destroy');
    Route::get('/api/clients/{client}/addresses', [AddressController::class, 'get_client_addresses']);

    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
    Route::put('/jobs/{job}/change_status', [JobController::class, 'change_status'])->name('jobs.change_status');

    Route::get('/trcs', [TestReportCertificateController::class, 'index'])->name('trc.index');
    Route::get('/my_trcs', [TestReportCertificateController::class, 'my_trcs'])->name('trc.my_trcs');
    Route::get('/trc/create', [TestReportCertificateController::class, 'create'])->name('trc.create');
    Route::get('/trc/preview', [TestReportCertificateController::class, 'preview'])->name('trc.preview');
    Route::post('/trc', [TestReportCertificateController::class, 'store'])->name('trc.store');
    Route::get('/trc/{id}', [TestReportCertificateController::class, 'show'])->name('trc.show');
    Route::get('/my_trc/{id}', [TestReportCertificateController::class, 'my_trc_show'])->name('trc.my_trc_show');
    Route::post('/trc/{id}/sign', [TestReportCertificateController::class, 'sign'])->name('trc.sign');
    Route::post('/trc/{id}/reject', [TestReportCertificateController::class, 'reject'])->name('trc.reject');
    Route::post('/trc/{id}/pending', [TestReportCertificateController::class, 'pending'])->name('trc.pending');
    Route::get('/trc/{id}/pdf', [TestReportCertificateController::class, 'generatePdf'])->name('trc.pdf');
});

Route::middleware('auth')->group(function () {
    Route::get('/my_licenses', [LicenseController::class, 'my_licenses'])->name('licenses.my_licenses');
    Route::get('/my_jobs', [JobController::class, 'my_jobs'])->name('jobs.my_jobs');
    Route::get('/my_jobs/{job}', [JobController::class, 'my_job_show'])->name('jobs.my_jobs_show');
});

require __DIR__.'/auth.php';
