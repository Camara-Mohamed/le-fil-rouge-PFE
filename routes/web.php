<?php

require __DIR__.'/admin.php';
require __DIR__.'/public.php';

Route::get('/', function () {
    return redirect('/'.config('app.locale'));
});
