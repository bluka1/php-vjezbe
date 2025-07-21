<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class KorisniciController extends Controller implements HasMiddleware
{

    public function __construct()
    { 
        $this->middleware();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'Svi korisnici.';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'Napravi novog korisnika';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return 'Pokaži jednog korisnika ' . $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return 'Editiraj korisnika ' . $id;
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

    public static function middleware() {
      return [
        new Middleware('check.age', only: ['show', 'create']),
        new Middleware('is.authenticated', only: ['create'])
      ];
    }
}
