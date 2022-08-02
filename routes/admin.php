<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Livewire\Admin\Appointments\CreateAppointment;
use App\Http\Livewire\Admin\Appointments\EditAppointment;
use App\Http\Livewire\Admin\Appointments\ListAppointments;
use App\Http\Livewire\Admin\Blog\Categories\ListBlogCategories;
use App\Http\Livewire\Admin\Blog\Posts\CreateBlogPost;
use App\Http\Livewire\Admin\Blog\Posts\EditBlogPost;
use App\Http\Livewire\Admin\Blog\Posts\ListBlogPosts;
use App\Http\Livewire\Admin\Clients\CreateClient;
use App\Http\Livewire\Admin\Clients\EditClient;
use App\Http\Livewire\Admin\Clients\ListClients;
use App\Http\Livewire\Admin\Faqs\ListFaqs;
use App\Http\Livewire\Admin\Invoices\CreateInvoice;
use App\Http\Livewire\Admin\Invoices\EditInvoice;
use App\Http\Livewire\Admin\Invoices\ListInvoices;
use App\Http\Livewire\Admin\Invoices\ViewInvoice;
use App\Http\Livewire\Admin\Messages\ListContactMessages;
use App\Http\Livewire\Admin\Pages\CreatePage;
use App\Http\Livewire\Admin\Pages\EditPage;
use App\Http\Livewire\Admin\Pages\ListPages;
use App\Http\Livewire\Admin\Plans\CreatePlan;
use App\Http\Livewire\Admin\Plans\EditPlan;
use App\Http\Livewire\Admin\Plans\ListPlans;
use App\Http\Livewire\Admin\Profile\UpdateProfile;
use App\Http\Livewire\Admin\Services\ListServices;
use App\Http\Livewire\Admin\Settings\Permissions\ListPermissions;
use App\Http\Livewire\Admin\Settings\Roles\ListRoles;
use App\Http\Livewire\Admin\Settings\Taxes\ListTaxes;
use App\Http\Livewire\Admin\Settings\UpdateSetting;
use App\Http\Livewire\Admin\Settings\Users\ViewUsers;
use App\Http\Livewire\Admin\Subscribes\ListSubscribes;
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
Route::get('tasks/{task}/edit', EditTask::class)->name('tasks.edit');

Route::get('clients', ListClients::class)->name('clients');
Route::get('clients/create', CreateClient::class)->name('clients.create');
Route::get('clients/{id}/edit', EditClient::class)->name('clients.edit');

Route::get('appointments', ListAppointments::class)->name('appointments');
Route::get('appointments/create', CreateAppointment::class)->name('appointments.create');
Route::get('appointments/{appointment}/edit', EditAppointment::class)->name('appointments.edit');

Route::get('plans', ListPlans::class)->name('plans');
Route::get('plans/create', CreatePlan::class)->name('plans.create');
Route::get('plans/{plan}/edit', EditPlan::class)->name('plans.edit');

Route::get('faqs', ListFaqs::class)->name('faqs');
Route::get('contact-messages', ListContactMessages::class)->name('contact-messages');

Route::get('blog/categories', ListBlogCategories::class)->name('blog.categories');
Route::get('blog/posts', ListBlogPosts::class)->name('blog.posts');
Route::get('blog/posts/create', CreateBlogPost::class)->name('blog.posts.create');
Route::get('blog/posts/{post}/edit', EditBlogPost::class)->name('blog.posts.edit');

Route::get('pages', ListPages::class)->name('pages');
Route::get('pages/create', CreatePage::class)->name('pages.create');
Route::get('pages/{page}/edit', EditPage::class)->name('pages.edit');

Route::get('profile', UpdateProfile::class)->name('profile');

Route::get('subscribes', ListSubscribes::class)->name('subscribes');

Route::get('settings/generals', UpdateSetting::class)->name('settings.generals');
Route::get('settings/taxes', ListTaxes::class)->name('settings.taxes');
Route::get('settings/roles', ListRoles::class)->name('settings.roles');
Route::get('settings/permissions', ListPermissions::class)->name('settings.permissions');
Route::get('settings/users', ViewUsers::class)->name('settings.users');

Route::get('income/services', ListServices::class)->name('income.services');
Route::get('income/invoices', ListInvoices::class)->name('income.invoices');
Route::get('income/invoices/{id}/view', ViewInvoice::class)->name('income.invoices.view');
Route::get('income/invoices/{id}/print', [InvoiceController::class, 'print'])->name('income.invoices.print');
Route::get('income/invoices/{id}/pdf', [InvoiceController::class, 'pdf'])->name('income.invoices.pdf');
Route::get('income/invoices/create', CreateInvoice::class)->name('income.invoices.create');
Route::get('income/invoices/{invoice}/edit', EditInvoice::class)->name('income.invoices.edit');
