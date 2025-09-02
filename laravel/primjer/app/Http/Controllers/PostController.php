<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostFormRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

  public function index()
  {
    $posts = Post::all();
    // return view('posts.index', ['posts' => $posts]); // identican efekt kao redak ispod
    return view('posts.index', compact('posts'));
  }

  public function new()
  {
    // vraca formu za unos novog posta
    return view('posts.new');
  }

  public function add(Request $request)
  {
    // logika za spremanje posta
    Post::create($request->all());
    // redirect na index page
    return redirect('/posts/index');
  }

  public function create()
  {
    return view('posts/create');
  }

  public function store(PostFormRequest $request)
  {
    $validatedData = $request->validated();

    return "Uspješno je iskreiran post s naslovom {$validatedData['naslov']} i tijelom: {$validatedData['tijelo']}";
  }
}
