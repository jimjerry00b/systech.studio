<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvanceTransactionController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HouseRentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;


// Public pages — accessible whether or not the admin is logged in
Route::get('/', HomeController::class)->name('home');
Route::get('/landing-page', [HomeController::class, 'landingPage'])->name('landing.page');

Route::get('/about', AboutController::class)->name('about');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Only the login routes redirect already-authenticated admins to the dashboard
Route::middleware('guest')->group(function(){
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'loginPost'])->name('login.post');
});


Route::middleware('admin')->group(function(){
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('houses/inactive', [HouseRentController::class, 'inactive'])->name('houses.inactive');
    Route::get('houses/{house}/statement', [HouseRentController::class, 'statement'])->name('houses.statement');
    Route::resource('houses', HouseRentController::class);
    Route::resource('houses.bills', BillController::class)
        ->shallow()
        ->only(['store', 'update', 'destroy']);
    Route::get('bills/{bill}/receipt', [BillController::class, 'receipt'])->name('bills.receipt');

    Route::get('contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::patch('contact-messages/{contactMessage}/read', [ContactMessageController::class, 'markRead'])->name('contact-messages.read');
    Route::delete('contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

    Route::post('houses/{house}/advances', [AdvanceTransactionController::class, 'store'])->name('advances.store');
    Route::delete('advances/{advance}', [AdvanceTransactionController::class, 'destroy'])->name('advances.destroy');
    Route::get('advances/{advance}/receipt', [AdvanceTransactionController::class, 'receipt'])->name('advances.receipt');
});