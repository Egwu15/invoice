<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserBusinessIsRegistered;
use App\Http\Middleware\RedirectUserWithBusiness;
use Livewire\Volt\Volt;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified',  EnsureUserBusinessIsRegistered::class])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Volt::route('business/create', 'business')
    ->middleware([RedirectUserWithBusiness::class, 'auth'])
    ->name('business.create');

Route::middleware([EnsureUserBusinessIsRegistered::class, 'auth'])->group(function () {


    Volt::route('customer/create', 'pages.customer.create-customer-form')
        ->name('customer.create');

    Volt::route('customer', 'pages.customer.view-customer')
        ->name('customer.view');

    Volt::route('customer/edit/{customer}', 'pages.customer.edit-customer')
        ->name('customer.edit');

    Volt::route('item/create', 'pages.item.create-item')
        ->name('item.create');
});



require __DIR__ . '/auth.php';
