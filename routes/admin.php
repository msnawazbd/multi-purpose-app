<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Livewire\Admin\Appointments\CreateAppointment;
use App\Http\Livewire\Admin\Appointments\EditAppointment;
use App\Http\Livewire\Admin\Appointments\ListAppointments;
use App\Http\Livewire\Admin\Clients\CreateClient;
use App\Http\Livewire\Admin\Clients\ListClients;
use App\Http\Livewire\Admin\Profile\UpdateProfile;
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
Route::get('clients', ListClients::class)->name('clients');
Route::get('clients/create', CreateClient::class)->name('clients.create');
Route::get('appointments', ListAppointments::class)->name('appointments');
Route::get('appointments/create', CreateAppointment::class)->name('appointments.create');
Route::get('appointments/{appointment}/edit', EditAppointment::class)->name('appointments.edit');
Route::get('profile', UpdateProfile::class)->name('profile');
Route::get('settings', UpdateSetting::class)->name('settings');
