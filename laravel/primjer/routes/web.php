<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HelloWorldController;
use App\Http\Controllers\KnjigeController;
use App\Http\Controllers\KorisniciController;
use App\Http\Controllers\MiddlewareController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SlikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
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

// Route::prefix('/abc')->name('abc.')->group(function () {
//   Route::get('/nova', [RouteController::class, 'getNova'])->name('get');
//   Route::post('/nova', [RouteController::class, 'postNova'])->name('post');
// });


// vjezbe middlewarea
Route::get('/middle', [MiddlewareController::class, 'get'])->middleware('is.authenticated');

// zadatak
// napraviti middleware CheckAge koji će iz inputa provjeravati userove godine
// dovoljno je staviti u link ?age=nekiBroj kod otvaranja rute
Route::get('/age', [MiddlewareController::class, 'check'])->middleware('check.age');

// implementacija middlewarea na grupu ruta
Route::middleware('check.age')->prefix('/abc')->name('abc.')->group(function () {
  Route::get('/nova', [RouteController::class, 'getNova'])->name('get');
  Route::post('/nova', [RouteController::class, 'postNova'])->name('post');
});

// implementacija resursnog kontrolera
Route::resource('books', BookController::class);

// zadatak
// napraviti novi resursni kontroler za resurs article
Route::resource('articles', ArticleController::class);

// zadatak
// napraviti novi resursni kontroler za resurs Korisnici]
// dodati middleware check.age za metode show i create
Route::resource('korisnici', KorisniciController::class);

// HTTP zahtjevi
// GET zahtjevi
Route::get('/users', [UserController::class, 'index']);

// zadatak
// napraviti CustomerController, dodati index rutu i prikazati 3 parametra po izboru
// parametri moraju biti proslijedeni unutar URL-a i odvojeni znakon &
Route::get('/customers', [CustomerController::class, 'index']);

// HTTP POST zahtjevi
Route::get('/customers/create', [CustomerController::class, 'create']);
Route::post('/customers/store', [CustomerController::class, 'store']);

// zadatak
// napraviti novi KnjigeController
// povezati get rutu s index metodom i unutar nje prikazati view
// povezati post rutu sa store metodom
// u viewu mora biti forma koja radi POST request i usmjerava na store metodu
Route::get('/knjige', [KnjigeController::class, 'index']);
Route::post('/knjige/store', [KnjigeController::class, 'store']);

// HTTP upload datoteka
Route::get('/profile/upload', [ProfileController::class, 'create']);
Route::post('/profile/store', [ProfileController::class, 'store']);

// zadatak
// napraviti SlikeController
// napraviti rutu za get i za post metodu
// ruta za get metodu vraćat će samo view koji će pokrenuti upload slike
// ruta za post metodu mora prikazati lokaciju uploadane slike i originalno ime datoteke
Route::get('/slike/upload', [SlikeController::class, 'create']);
Route::post('/slike/store', [SlikeController::class, 'store']);

// zadatak - validacija
// u BookController u store metodi dodati validaciju za polje naslov
// dovoljno je 2 pravila
// validacijske greške i stari unos prikazati na ekranu

// zadatak - FormRequest
// napraviti novi controller - PostController
// dodati get i post rutu
// dodati create i store metode
// dodati view za create metodu
// implementirati FormRequest validaciju za naslov i tijelo polja

Route::get('/posts/create', [PostController::class, 'create']);
Route::post('/posts/store', [PostController::class, 'store']);

Route::get('/posts/index', [PostController::class, 'index']);
Route::get('/posts/new', [PostController::class, 'new']);
Route::post('/posts/add', [PostController::class, 'add']);
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name(name: 'posts.destroy'); 

Route::get('/poz', function() {
  return 'Hello world';
});
Route::get('/json', function() {
  return [
    "ime" => "Luka",
    "zanimanje" => 'Developer'
  ];
});

Route::get('/greska', function () {
  return response(['greska' => 'Not found'], 404)->header('Content-Type', 'application/json');
});

Route::get('/welcome', [WelcomeController::class, 'index']);

// ZADATAK
// dodajte novu metodu u WelcomeController
// stvorite novi view pomoću artisan komande
// vratite taj view unutar nove metode
// proslijedite podatke o vašem hobiju i vašem najdražem voću u view te ih prikažite
Route::get('/welcome/hobby', [WelcomeController::class, 'show']);

Route::get('/welcome/create', [WelcomeController::class, 'create']);
Route::post('/welcome/store', [WelcomeController::class, 'store']);

Route::get('/pocetna', [WelcomeController::class, 'pocetna']);
Route::get('/onama', [WelcomeController::class, 'onama']);
Route::get('/kontakt', [WelcomeController::class, 'kontakt']);

// u WelcomeController dodajte nove 2 metode
// napravite container.blade.php layout komponentu
// dodajte stilove i osnovnu strukturu u container.blade.php
// pripremite prostor za yield title, yield naslov u headeru i yield content u main elementu
// iskoristite layout u 2 nova view-a
// napravite komponentu button s jednim slotom po imenu ikona i jednim propom po imenu text

Route::get('/proizvodi', [WelcomeController::class, 'proizvodi']);
Route::get('/narudzbe', [WelcomeController::class, 'narudzbe']);


Route::get('/login', [WelcomeController::class, 'login']);
Route::post('/logout', [WelcomeController::class, 'logout']);
Route::post('/process', [WelcomeController::class, 'process']);

// dodajte novog usera u bazu - ako ste već pokretali seedanje, izbrišite podatke u tablici baze
// pokrenite seedanje s 1 novim i jednim starim userom
// isprobajte login - logout flow s novim userom
// napravite nove rute i nove view-ove te implementirajte login-logout flow

Route::get('/prijava', [WelcomeController::class, 'prijava']);
Route::post('/obrada', [WelcomeController::class, 'obrada']);
Route::post('/odjava', [WelcomeController::class, 'odjava']);