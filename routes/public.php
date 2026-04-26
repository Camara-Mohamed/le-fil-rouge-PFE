<?php

Route::get('/', function () {
    return view('public.home');
})->name('public.home');

Route::get('/courses', function () {
    return view('public.courses.index');
})->name('public.courses.index');

Route::get('/camps', function () {
    return view('public.camps.index');
})->name('public.camps.index');

Route::get('/about', function () {
    return view('public.about');
})->name('public.about');

Route::get('/news', function () {
    return view('public.news.index');
})->name('public.news.index');

Route::get('/contact', function () {
    return view('public.contact');
})->name('public.contact');

Route::get('/volunteer', function () {
    return view('public.volunteer');
})->name('public.volunteer');
