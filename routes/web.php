<?php

use App\Livewire\Paginator;
use Illuminate\Support\Facades\Route;


Route::get('/', Paginator::class);