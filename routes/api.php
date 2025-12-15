<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Primer defaultne API rute
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});