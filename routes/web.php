<?php

use App\Livewire\Paginator;
use Illuminate\Support\Facades\Route;


Route::get('/', Paginator::class);

Route::view('/terms-of-use', 'terms-of-use')->name('terms');
Route::view('/privacy-policy', 'privacy-policy')->name('privacy');