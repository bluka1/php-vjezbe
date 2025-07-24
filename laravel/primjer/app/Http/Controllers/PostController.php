<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostFormRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
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
