<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Livewire\Web\Contact\ContactUs;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', HomeController::class)->name('home');
Route::get('/contact-us', ContactUs::class)->name('contact-us');
