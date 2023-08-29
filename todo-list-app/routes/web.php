<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome'); // This could be a welcome or landing page if you have one. Otherwise, you can remove this route.
});

Route::fallback(function () {
    return 'Page not found!'; // A simple 404 response : route for fallback
});
