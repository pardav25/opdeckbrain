<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/deck-builder', function () {
    return view('deck-builder-page');
});
