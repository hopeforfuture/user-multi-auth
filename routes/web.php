<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function() {
    Route::get('/', [AdminController::class, 'login'])->middleware(['guest:admin','nocache'])->name('admin.start');
    Route::post('/', [AdminController::class, 'login'])->name('admin.login');
    Route::get('/dashboard', [AdminController::class, 'view_profile'])->middleware(['IsAdmin', 'nocache'])->name('admin.dashboard');
    Route::get('/logout', [AdminController::class, 'logout'])->middleware(['IsAdmin', 'nocache'])->name('admin.logout');

    Route::post('/lead/remove/{id}', [AdminController::class, 'lead_delete'])->middleware(['IsAdmin', 'nocache'])->name('admin.delete.lead');
    Route::get('/lead/edit/{id}', [AdminController::class, 'edit_lead'])->middleware(['IsAdmin','nocache'])->name('admin.edit.lead');
    Route::post('/lead/edit/{id}', [AdminController::class, 'edit_lead'])->middleware(['IsAdmin','nocache'])->name('admin.update.lead');
    Route::get('/lead/view/{id}', [AdminController::class, 'view_lead'])->middleware(['IsAdmin','nocache'])->name('admin.view.lead');
    Route::get('/lead/list/{cust_id?}', [AdminController::class, 'leads'])->middleware(['IsAdmin', 'nocache'])->name('admin.lead.list');
    //Route::get('/lead/list', [AdminController::class, 'leads'])->middleware(['IsAdmin', 'nocache'])->name('admin.lead.list');

    Route::get('/customer/list', [AdminController::class, 'customers'])->middleware(['IsAdmin', 'nocache'])->name('admin.customer.list');
    Route::get('/customer/edit/{id}', [AdminController::class, 'edit_customer'])->middleware(['IsAdmin','nocache'])->name('admin.edit.customer');
    Route::post('/customer/edit/{id}', [AdminController::class, 'edit_customer'])->middleware(['IsAdmin','nocache'])->name('admin.update.customer');
    Route::post('/customer/remove/{id}', [AdminController::class, 'customer_delete'])->middleware(['IsAdmin', 'nocache'])->name('admin.delete.customer');
    Route::get('/customer/view/{id}', [AdminController::class, 'view_customer'])->middleware(['IsAdmin','nocache'])->name('admin.view.customer');
});

Route::prefix('customer')->group(function() {
    Route::get('/', [CustomerController::class, 'login'])->middleware(['guest:customer','nocache'])->name('customer.start');
    Route::get('/profile', [CustomerController::class, 'profile_view'])->middleware(['IsCustomer','nocache'])->name('customer.dashboard');
    Route::post('/', [CustomerController::class, 'login'])->name('customer.login');
    Route::get('/signup', [CustomerController::class, 'register'])->middleware(['guest:customer','nocache'])->name('customer.signup');
    Route::post('/signup', [CustomerController::class, 'register'])->middleware(['guest:customer','nocache'])->name('customer.save');
    Route::get('/logout', [CustomerController::class, 'logout'])->middleware(['IsCustomer', 'nocache'])->name('customer.logout');
    
    Route::get('/lead/list', [CustomerController::class, 'leads'])->middleware(['IsCustomer', 'nocache'])->name('customer.lead');
    Route::post('/lead/remove/{id}', [CustomerController::class, 'lead_delete'])->middleware(['IsCustomer', 'nocache'])->name('customer.delete.lead');
    Route::get('/lead/edit/{id}', [CustomerController::class, 'edit_lead'])->middleware(['IsCustomer','nocache'])->name('customer.edit.lead');
    Route::post('/lead/edit/{id}', [CustomerController::class, 'edit_lead'])->middleware(['IsCustomer','nocache'])->name('customer.update.lead');
    Route::get('/lead/view/{id}', [CustomerController::class, 'view_lead'])->middleware(['IsCustomer','nocache'])->name('customer.view.lead');

});

Route::prefix('lead')->group(function() {
    Route::get('/', [LeadController::class, 'login'])->middleware(['guest:lead','nocache'])->name('lead.start');
    Route::get('/profile', [LeadController::class, 'profile_view'])->middleware(['IsLead','nocache'])->name('lead.dashboard');
    Route::post('/', [LeadController::class, 'login'])->name('lead.login');
    Route::get('/signup', [LeadController::class, 'register'])->middleware(['guest:lead','nocache'])->name('lead.signup');
    Route::post('/signup', [LeadController::class, 'register'])->middleware(['guest:lead','nocache'])->name('lead.save');
    Route::get('/logout', [LeadController::class, 'logout'])->middleware(['IsLead', 'nocache'])->name('lead.logout');
});
