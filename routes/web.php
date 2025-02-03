<?php

use App\Http\Controllers\PdfController;
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

    Route::prefix('customer')->group(function () {
        Volt::route('/create', 'pages.customer.create-customer-form')
            ->name('customer.create');

        Volt::route('/', 'pages.customer.view-customer')
            ->name('customer.view');

        Volt::route('edit/{customer}', 'pages.customer.edit-customer')
            ->name('customer.edit');
    });


    Route::prefix('item')->group(function () {

        Volt::route('/create', 'pages.item.create-item')
            ->name('item.create');

        Volt::route('/', 'pages.item.view-item')
            ->name('item.view');

        Volt::route('edit/{item}', 'pages.item.edit-item')
            ->name('item.edit');
    });

    Route::prefix('invoice')->group(function () {
        Volt::route('/create', 'pages.invoice.create-invoice')
            ->name('invoice.create');

        Volt::route('/', 'pages.invoice.view-invoice')
            ->name('invoice.view');

        Volt::route('details/{invoice}', 'pages.invoice.invoice-detail')
            ->name('invoice.detail');

        Volt::route('send/{invoice}', 'pages.invoice.invoiceTemplates.template1')
            ->name('invoice.send');
        Route::get('/download', [PdfController::class, 'download'])->name('download');
        Route::get('/sendMail', [PdfController::class, 'sendMail'])->name('sendMail');    });
});



require __DIR__ . '/auth.php';
