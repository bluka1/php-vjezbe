<?php

use App\Http\Controllers\HelloWorldController;
use App\Http\Controllers\MiddlewareController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RouteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ovdje dodajemo controller i metodu koja će se pozivati na tom controlleru kada posjetimo rutu /order
Route::get('/order', [OrderController::class, 'store']);

Route::get('/pozdrav', [HelloWorldController::class, 'pozdrav']);

// vježbe rutiranja
Route::prefix('admin')->name('admin.')->group(function() {
  Route::get('/routes', [RouteController::class, 'get']);
  Route::post('/routes', [RouteController::class, 'post'])->name('postR');
});

Route::get('/params/{id}', [RouteController::class, 'getParams']);
// getParams($id);

// neoparams = neobavezni parametri
Route::get('/neoparam/{neobavezniParametar?}', [RouteController::class, 'getNeoParams']);

// zadatak:
// napraviti 2 nove rute na isti link(get i post), grupirati ih i imenovati
// u RouteControlleru napraviti nove metode koje će obradivati te zahtjeve
// napraviti novi view koji će se vraćati za get request i radit će post request na istu rutu
// post request može vratiti samo neki string
// get request mora vratiti view s formom

Route::prefix('/abc')->name('abc.')->group(function () {
  Route::get('/nova', [RouteController::class, 'getNova'])->name('get');
  Route::post('/nova', [RouteController::class, 'postNova'])->name('post');
});


// vjezbe middlewarea
Route::get('/middle', [MiddlewareController::class, 'get'])->middleware('is.authenticated');

// zadatak
// napraviti middleware CheckAge koji će iz inputa provjeravati userove godine
// dovoljno je staviti u link ?age=nekiBroj kod otvaranja rute
Route::get('/age', [MiddlewareController::class, 'check'])->middleware('check.age');