<?php

use App\Http\Controllers\HelloWorldController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ovdje dodajemo controller i metodu koja će se pozivati na tom controlleru kada posjetimo rutu /order
Route::get('/order', [OrderController::class, 'store']);

Route::get('/pozdrav', [HelloWorldController::class, 'pozdrav']);