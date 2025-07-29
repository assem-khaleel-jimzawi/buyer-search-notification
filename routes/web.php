<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', [SearchController::class, 'form'])->name('search.form');
Route::post('/search', [SearchController::class, 'handle'])->name('search.handle');