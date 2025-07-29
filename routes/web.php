<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Models\Part;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', [SearchController::class, 'form'])->name('search.form');
Route::post('/search', [SearchController::class, 'handle'])->name('search.handle');

Route::get('/api/search', function (Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'query' => 'required|string|max:255',
    ]);

    $matches = Part::whereFullText('name', $validated['query'])->get();

    return response()->json($matches);
});