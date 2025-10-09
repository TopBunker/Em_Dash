<?php

use App\Http\Controllers\ResumeController;
use App\Livewire\Paginator;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', Paginator::class);

Route::view('/terms-of-use', 'terms-of-use')->name('terms');
Route::view('/privacy-policy', 'privacy-policy')->name('privacy');

// Protected Routes
Route::get('/resume/download', [ResumeController::class, 'download'])->name('resume.download')->middleware('signed') ;