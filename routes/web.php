<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route untuk melihat daftar project dan task, bisa diakses semua user yang sudah login
    Route::get('/project', [ProjectController::class, 'index'])->name('project.index');
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

    Route::middleware(['auth', 'isAdmin'])->group(function () {
        Route::get('/project/create', [ProjectController::class, 'create'])->name('project.create');
        Route::post('/project', [ProjectController::class, 'store'])->name('project.store');
        Route::get('/project/{project}/edit', [ProjectController::class, 'edit'])->name('project.edit');
        Route::put('/project/{project}', [ProjectController::class, 'update'])->name('project.update');
        Route::delete('/project/{project}', [ProjectController::class, 'destroy'])->name('project.destroy');
        Route::get('/project/{project}', [ProjectController::class, 'show'])->name('project.show');
        Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::patch('/tasks/{task}/transfer', [TaskController::class, 'transfer'])->name('tasks.transfer');
        // Route approval absence
        Route::get('/administration/absence/approval', [AbsenceController::class, 'approvalList'])->name('absence.approval');
        Route::post('/administration/absence/{id}/approve', [AbsenceController::class, 'approve'])->name('absence.approve');
        Route::post('/administration/absence/{id}/reject', [AbsenceController::class, 'reject'])->name('absence.reject');
        Route::get('/administration/absence/{id}', [AbsenceController::class, 'show'])->name('absence.show');

        // SDM Management (hanya admin)
        Route::prefix('sdm')->name('sdm.')->group(function () {
            Route::get('/', [\App\Http\Controllers\SdmController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\SdmController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\SdmController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [\App\Http\Controllers\SdmController::class, 'edit'])->name('edit');
            Route::put('/{user}', [\App\Http\Controllers\SdmController::class, 'update'])->name('update');
            Route::delete('/{user}', [\App\Http\Controllers\SdmController::class, 'destroy'])->name('destroy');
        });
    });

    Route::middleware(['auth', 'isEmployee'])->group(function () {
        Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    });

    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/user/{user}', [ActivityController::class, 'getUserActivities'])->name('activities.user');

    // API routes for AJAX calls
    Route::get('/api/activities/chart-data', [ActivityController::class, 'getChartData'])->name('activities.chart-data');
    Route::get('/api/activities/user-activities', [ActivityController::class, 'getUserActivities'])->name('activities.user-activities');

    Route::prefix('administration')->name('administration.')->group(function () {
        Route::get('/absence', [AbsenceController::class, 'index'])->name('absence.index');
    });

    Route::prefix('absence')->middleware(['adminOrEmployee'])->group(function () {
        Route::get('/create', [AbsenceController::class, 'create'])->name('absence.create');
        Route::post('/', [AbsenceController::class, 'store'])->name('absence.store');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Transfer Task
    Route::get('/tasks/transfer/form/{project}', [TaskController::class, 'showTransferForm'])->name('task.transfer.form');
    Route::post('/tasks/transfer/submit', [TaskController::class, 'submitTransfer'])->name('task.transfer.submit');
    Route::get('/tasks/view', [TaskController::class, 'view'])->name('tasks.view');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::get('/project/view', [ProjectController::class, 'view'])->name('project.view');
});
