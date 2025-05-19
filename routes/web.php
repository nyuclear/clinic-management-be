<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/db-check', function () {
    try {
        DB::connection()->getPdo();
        return '✅ Database connected successfully!';
    } catch (\Exception $e) {
        return '❌ Database connection failed: ' . $e->getMessage();
    }
});
