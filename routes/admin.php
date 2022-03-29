<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Livewire\Admin\Appointments\CreateAppointment;
use App\Http\Livewire\Admin\Appointments\EditAppointment;
use App\Http\Livewire\Admin\Appointments\ListAppointments;
use App\Http\Livewire\Admin\Clients\CreateClient;
use App\Http\Livewire\Admin\Clients\EditClient;
use App\Http\Livewire\Admin\Clients\ListClients;
use App\Http\Livewire\Admin\Profile\UpdateProfile;
use App\Http\Livewire\Admin\Settings\UpdateSetting;
use App\Http\Livewire\Admin\Tasks\CreateTask;
use App\Http\Livewire\Admin\Tasks\EditTask;
use App\Http\Livewire\Admin\Tasks\ListTasks;
use App\Http\Livewire\Admin\Users\ListUsers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('dashboard', DashboardController::class)->name('dashboard');
Route::get('users', ListUsers::class)->name('users');
Route::get('tasks', ListTasks::class)->name('tasks');
Route::get('tasks/create', CreateTask::class)->name('tasks.create');
Route::get('tasks/{id}/edit', EditTask::class)->name('tasks.edit');
Route::get('clients', ListClients::class)->name('clients');
Route::get('clients/create', CreateClient::class)->name('clients.create');
Route::get('clients/{id}/edit', EditClient::class)->name('clients.edit');
Route::get('appointments', ListAppointments::class)->name('appointments');
Route::get('appointments/create', CreateAppointment::class)->name('appointments.create');
Route::get('appointments/{appointment}/edit', EditAppointment::class)->name('appointments.edit');
Route::get('profile', UpdateProfile::class)->name('profile');
Route::get('settings', UpdateSetting::class)->name('settings');
