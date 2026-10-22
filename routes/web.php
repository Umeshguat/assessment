<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('home'));

Route::get('/real-estate-projects/{segment}', [ListingController::class, 'index'])
    ->where('segment', '[a-z0-9-]+');
Route::get('/projects-in-{segment}', [ListingController::class, 'index'])
    ->where('segment', '[a-z0-9-]+');

Route::get('/{slug}', [LandingController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('landing');
