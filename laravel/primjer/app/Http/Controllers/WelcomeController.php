<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Product;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use User;

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
    $auti = DB::table('cars')->where('id', 1)->get(); // vraca kolekciju
    // $auti = DB::table('cars')->find(1); // vraca pojedinacni rezultat

    // 1. dohvatite sve postove
    // 2. joinajte tablicu users po user idu
    // 3. prikazite naslov posta i ime autora

    $posts = DB::table('posts')->join('users', 'posts.user_id', '=', 'users.id')->select('posts.title as naslov', 'users.name as author')->get();

    return view('welcome.pocetna', compact('auti', 'posts'));
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
    // 1. kreirajte novi model Product u našoj aplikaciji
    // 2. napravite migraciju za taj novi model i pokrenite ju da se primjeni da bazi
    // 3. povežite User i Products model (napravite relaciju medu njima)
    // 4. napravite novu migraciju koja povezuje ta 2 modela
    // 5. popunite tablicu vezanu uz novi model nekim podacima (dodajte 2-3 zapisa)
    // 6. prikažite sve Productse koji pripadaju trenutno prijavljenom Useru

    // PRIMJER - many to many
    // 1. moramo stvoriti novi model koji će biti povezan s Userom
    // 2. moramo povezati ta 2 modela
    // 3. moramo stvoriti migraciju koja će stvoriti novu tablicu u kojoj se nalaze many-to-many zapisi
    // 3.1. moramo seedati podatke u tablicu novog modela
    // 4. moramo dohvatiti te podatke
    // 5. moramo prikazati te podatke u view-u
    $posts = [];
    $products = [];
    $cars = [];
    if (Auth::check()) {
      // $posts = Post::where('user_id', Auth::user()->id)->get(); // dohvaćanje postova filtriranjem
      // $posts = Auth::user()->posts; // dohvaćanje postova na temelju relacije
      $posts = Post::with('user')->get(); // dohvaćanje postova eager loadingom
      $products = Auth::user()->products;
      $cars = Auth::user()->cars;
    }
    return view('welcome.prijava', compact(['products', 'cars']));
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
