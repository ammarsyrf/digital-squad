<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CertificateController;

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    // Shared Dashboard & Notification Routes
    Route::get('/notifications/{notifikasi}/read', [DashboardController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [DashboardController::class, 'markAllRead'])->name('notifications.read_all');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::get('/verification/certificates', [AdminController::class, 'certificateVerification'])->name('verification.certificates');
        Route::post('/verification/certificates/{sertifikat}/approve', [AdminController::class, 'approveCertificate'])->name('verification.certificates.approve');
        Route::post('/verification/certificates/{sertifikat}/reject', [AdminController::class, 'rejectCertificate'])->name('verification.certificates.reject');

        Route::get('/verification/umkm', [AdminController::class, 'umkmVerification'])->name('verification.umkm');
        Route::post('/verification/umkm/{umkm}/approve', [AdminController::class, 'approveUmkm'])->name('verification.umkm.approve');
        Route::post('/verification/umkm/{umkm}/reject', [AdminController::class, 'rejectUmkm'])->name('verification.umkm.reject');

        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/export', [AdminController::class, 'exportUsers'])->name('users.export');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

        Route::get('/skill-categories', [AdminController::class, 'skillCategories'])->name('skill-categories');
        Route::get('/skill-categories/create', [AdminController::class, 'createSkillCategory'])->name('skill-categories.create');
        Route::post('/skill-categories', [AdminController::class, 'storeSkillCategory'])->name('skill-categories.store');
        Route::get('/skill-categories/{category}/edit', [AdminController::class, 'editSkillCategory'])->name('skill-categories.edit');
        Route::put('/skill-categories/{category}', [AdminController::class, 'updateSkillCategory'])->name('skill-categories.update');
        Route::delete('/skill-categories/{category}', [AdminController::class, 'deleteSkillCategory'])->name('skill-categories.delete');

        Route::post('/skill-tests/bulk-status', [AdminController::class, 'bulkUpdateSkillTestStatus'])->name('skill-tests.bulk-status'); // Bulk Action Route

        Route::get('/skill-tests/create', [AdminController::class, 'createSkillTest'])->name('skill-tests.create');
        Route::post('/skill-tests', [AdminController::class, 'storeSkillTest'])->name('skill-tests.store');
        Route::get('/skill-tests/{test}/edit', [AdminController::class, 'editSkillTest'])->name('skill-tests.edit');
        Route::put('/skill-tests/{test}', [AdminController::class, 'updateSkillTest'])->name('skill-tests.update');
        Route::delete('/skill-tests/{test}', [AdminController::class, 'deleteSkillTest'])->name('skill-tests.delete');
        Route::get('/skill-tests', [AdminController::class, 'skillTests'])->name('skill-tests');
        Route::get('/messages', [MessageController::class, 'index'])->name('messages');
        Route::get('/notifications', [DashboardController::class, 'notifications'])->name('notifications');
        Route::get('/profile', [ProfileController::class, 'admin'])->name('profile');
        Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    });

    // Talent Routes
    Route::prefix('talent')->name('talent.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'talent'])->name('dashboard');
        Route::get('/messages', [MessageController::class, 'index'])->name('messages');
        Route::get('/skill-tests', [DashboardController::class, 'skillTests'])->name('skill-tests');
        Route::get('/skill-tests/{category}', [DashboardController::class, 'takeTest'])->name('skill-tests.take');
        Route::post('/skill-tests/{category}', [DashboardController::class, 'submitTest'])->name('skill-tests.submit');
        Route::get('/applications', [JobController::class, 'talentApplications'])->name('applications');
        Route::get('/jobs', [JobController::class, 'talentIndex'])->name('jobs');
        Route::get('/jobs/{lowongan}', [JobController::class, 'show'])->name('jobs.show');
        Route::post('/jobs/{lowongan}/apply', [JobController::class, 'apply'])->name('jobs.apply');
        Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates');
        Route::post('/certificates', [CertificateController::class, 'store'])->name('certificates.store');
        Route::post('/certificates/{sertifikat}', [CertificateController::class, 'update'])->name('certificates.update');
        Route::delete('/certificates/{sertifikat}', [CertificateController::class, 'destroy'])->name('certificates.destroy');
        Route::get('/profile', [ProfileController::class, 'talent'])->name('profile');
        Route::post('/profile', [ProfileController::class, 'updateTalent'])->name('profile.update');
        Route::get('/notifications', [DashboardController::class, 'notifications'])->name('notifications');
        Route::get('/umkm/{umkm}', [ProfileController::class, 'showUmkm'])->name('umkm.show');
        Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    });

    // UMKM Routes
    Route::prefix('umkm')->name('umkm.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'umkm'])->name('dashboard');
        Route::get('/messages', [MessageController::class, 'index'])->name('messages');
        Route::get('/jobs', [JobController::class, 'umkmIndex'])->name('jobs');
        Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{lowongan}/edit', [JobController::class, 'edit'])->name('jobs.edit');
        Route::post('/jobs/{lowongan}', [JobController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{lowongan}', [JobController::class, 'destroy'])->name('jobs.destroy');
        Route::get('/applicants', [JobController::class, 'applicants'])->name('applicants');
        Route::get('/notifications', [DashboardController::class, 'notifications'])->name('notifications');
        Route::post('/applicants/{lamaran}/status', [JobController::class, 'updateApplicantStatus'])->name('applicants.status');
        Route::post('/applicants/{lamaran}/schedule', [JobController::class, 'scheduleInterview'])->name('applicants.schedule');
        Route::get('/profile', [ProfileController::class, 'umkm'])->name('profile');
        Route::post('/profile', [ProfileController::class, 'updateUmkm'])->name('profile.update');
        Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    });

    // Shared Message Routes
    Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
});