<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
  public $books = [
    "Nada ne razočarava", "Biblija", "Vjera"
  ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return "all books";
      // return view('books/index', ['books' => $this->books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return "Create book";
        // return view('books/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      // $this->books[] = "Nova knjiga";
      // return view('books/index', ['books' => $this->books]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      return "Book {$id}";
        // return view('books/show', ['book' => $this->books[$id]]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return "Edit book {$id}";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
