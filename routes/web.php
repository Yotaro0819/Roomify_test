<?php

use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('address', [AddressController::class, 'index']);


Route::get('/accommodation/create', [AccommodationController::class, 'create'])->name('accommodation.create');
Route::post('/accommodation', [AccommodationController::class, 'store'])->name('accommodation.store');
Route::get('/accommodation/{id}', [AccommodationController::class, 'show'])->name('accommodation.show');


Route::get('tag/{id}', [TagController::class, 'show'])->name('tag.show');
