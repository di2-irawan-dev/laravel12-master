<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', \App\Livewire\Dashboard::class)->name('dashboard');

    Route::get('account/profile', \App\Livewire\Account\Profile::class)->name('account.profile');
    Route::get('account/change-password', \App\Livewire\Account\ChangePassword::class)->name('account.change-password');

    Route::get('user', \App\Livewire\User\Index::class)->name('user');
});
