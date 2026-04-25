<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/dashboard', function (){
    return view('admin.dashboard');
})->name('dashboard');
