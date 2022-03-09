<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Livewire\Admin\Appointments\CreateAppointment;
use App\Http\Livewire\Admin\Appointments\EditAppointment;
use App\Http\Livewire\Admin\Appointments\ListAppointments;
use App\Http\Livewire\Admin\Settings\UpdateSetting;
use App\Http\Livewire\Admin\Users\ListUsers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('dashboard', DashboardController::class)->name('dashboard');
Route::get('users', ListUsers::class)->name('users');
Route::get('appointments', ListAppointments::class)->name('appointments');
Route::get('appointments/create', CreateAppointment::class)->name('appointments.create');
Route::get('appointments/{appointment}/edit', EditAppointment::class)->name('appointments.edit');
Route::get('settings', UpdateSetting::class)->name('settings');
