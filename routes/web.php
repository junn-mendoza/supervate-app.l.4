<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// tile
Route::livewire('ideas', 'pages::ideas.generate')->name('ideas');
Route::livewire('customers', 'pages::customers.generate')->name('customers');
Route::livewire('problems', 'pages::problems.generate')->name('problems');
Route::livewire('solutions', 'pages::solutions.generate')->name('solutions');
Route::livewire('prototypes', 'pages::prototypes.generate')->name('prototypes');
Route::livewire('alternatives', 'pages::alternatives.generate')->name('alternatives');
Route::livewire('businesses', 'pages::businesses.generate')->name('businesses');
Route::livewire('customerinterview', 'pages::customerinterviews.generate')->name('customerinterview');
Route::livewire('audioanalyses', 'pages::audioanalyses.generate')->name('audioanalyses');
Route::livewire('projectexport', 'pages::projectexports.generate')->name('projectexport');
Route::livewire('projects', 'pages::projectoverview.list')->name('projects');
Route::livewire('template', 'pages::template.generate')->name('template');

Route::livewire('favourites', 'pages::favourites.table')->name('favourites');
Route::livewire('sharedwithme', 'pages::sharewithme.table')->name('sharedwithme');
Route::livewire('dashboard', 'pages::dashboard.view')->name('dashboard');

Route::livewire('settings', 'pages::settings.view')->name('settings');
Route::livewire('help', 'pages::help.view')->name('help');
Route::livewire('upgrade', 'pages::upgrade.view')->name('upgrade');
// test
Route::livewire('test', 'pages::test.test')->name('test');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
