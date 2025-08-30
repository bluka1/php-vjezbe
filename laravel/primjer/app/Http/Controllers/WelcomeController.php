<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class WelcomeController extends Controller
{
  public function index() {
    // ovdje bismo dohvaćali podatke iz baze
    $korisnickoIme = "pero";
    $lokacija = "Zagreb";
    // ...

    if (View::exists('welcome.index')) {
      return view('welcome.index', [
        'username' => $korisnickoIme,
        'city' => $lokacija
      ]);
    } else {
      return 'Welcome';
    } 
  }

  public function show() {
    $hobby = 'jiu jitsu';
    $fruit = 'banana';
    $prijatelji = ['Ante', 'Josip', 'Ilija', 'Marko', 'Matej'];
    return view('welcome.show', [
      'hob' => $hobby, //obicno navodimo neka smislena imena za proslijedene podatke - cesto isto ime kao ime varijable
      'fr' => $fruit, // no ovdje stavljamo skraćena imena da naglasimo kako "čitamo" vrijednosti unutar view-a
      'niz' => $prijatelji
    ]);
  }

  public function create() {
    return view('welcome.create');
  }

  public function store(Request $request) {
    $validatedData = $request->validate(
      [
        "adresa" => "required|string|min:4",
        "naslov" => "required|string|min:7"
      ],
      [
        "adresa.required" => "Adresa je obavezna.",
        "adresa.min" => "Adresa mora imati minimalno 4 znaka.",
        "naslov.required" => "Naslov mora biti unesen.",
        "naslov.min" => "Naslov mora imati barem 7 znakova.",
      ]
    );

    return view('welcome.create', $validatedData);
  }

  public function pocetna () {
    return view('welcome.pocetna');
  }

  public function onama () {
    return view('welcome.onama');
  }

  public function kontakt () {
    return view('welcome.kontakt');
  }

  public function proizvodi () {
    return view('welcome.proizvodi');
  }

  public function narudzbe () {
    return view('welcome.narudzbe');
  }

  public function prijava () {
    return view('welcome.prijava');
  }

  public function obrada (Request $request) {
    $validatedData = $request->validate(
      [
        "email" => ['required', 'email'],
        "password" => ['required', 'string']
      ]
    );

    // $credentials = [
    //   'email' => $validatedData['email'],
    //   'password' => $validatedData['password'],
    // ];


    // pokušaj prijave
    if (Auth::attempt($validatedData)) {
        // regeneracija sesije (sigurnosna mjera)
        $request->session()->regenerate();
        
        return redirect('/prijava');
    }

    // ako prijava nije uspjela
    return back()->withErrors([
        'email' => 'Podaci za prijavu nisu ispravni.',
    ])->onlyInput('email');
  }

  public function odjava (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/prijava');
  }

  public function login () {
    return view('welcome.login');
  }

  public function logout (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
  }

  public function process (Request $request) {
    $credentials = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required']
    ]);

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      return view('welcome.login');
    }

    return back()->withErrors(['email' => 'Neuspješna prijava. Neispravni login podaci.'])->onlyInput('email');
  }
}
