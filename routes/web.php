<?php

use App\Http\Controllers\auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/action/login', [AuthController::class, 'actionLogin'])->name('action.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
// Routing admin
Route::middleware(['role:admin'])->group(function () {

    Route::get('/admin', function () {
        return view('admin.index');
    });
    Route::get('/position', function () {
        return view('admin.position');
    });
    Route::get('/employee', function () {
        return view('admin.pegawai');
    });
    Route::get('/user', function () {
        return view('admin.pengguna');
    });
    Route::get('/payroll', function () {
        return view('admin.payroll');
    });
    Route::get('/admin/attendance', function () {
        return view('admin.attendance');
    })->name('admin.attendance');
    Route::get('/admin/profile', function () {
        return view('admin.profile');
    })->name('admin.profile');
});

// END ROUTING ADMIN

// Routing user
Route::middleware(['role:user'])->group(function () {

    Route::get('/attendance', function () {
        return view('user.kehadiran');
    })->name('user.attendance');

    Route::get('/profile', function () {
        return view('user.profile_page');
    })->name('user.profile');
});
