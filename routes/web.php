<?php

require __DIR__.'/public.php';
require __DIR__.'/admin.php';

Route::get('/', function () {
    return redirect('/'.config('app.locale'));
});
