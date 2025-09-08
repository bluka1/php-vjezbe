@extends('layouts.app')

@section('title', 'početna stranica')

@section('content')
  <div>
    Dobrosdošli na početnu stranicu gdje isprobavamo Laravel layoute.
  </div>

  <hr>

  <x-badge type="danger" text="UPOZORENJE!" />
  <x-badge type="info" text="INFO" />
  <x-badge type="success" text="USPJEH!" />

  <hr>
  <br>

  <x-card>
    <x-slot:title>Naslov kartice</x-slot:title>
    <x-slot:actions>
      <x-badge type="danger" text="UPOZORENJE!" />
      <x-badge type="info" text="INFO" />
    </x-slot:actions>

    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non nobis, neque dolore quo quisquam porro itaque dolorem repellat natus eaque. Voluptas, earum! Non aliquid voluptatibus inventore nisi laborum at fugiat delectus itaque rerum eius ab dolore, architecto tempora illum tenetur esse quasi adipisci eligendi facilis aliquam dignissimos possimus. Omnis, ex.</p>
  </x-card>

  <hr>

  <p>Popis automobila:</p>
  <ul>
    {{-- za pojedinacni rezultat -> <li>{{$auti->brand}} - {{$auti->color}}</li> --}}
    @forelse ($auti as $auto)
        <li>{{$auto->brand}} - {{$auto->color}}</li>
    @empty
        <p>Nema raspolozivih automobila :(</p>
    @endforelse
  </ul>

  <ul>
    @forelse ($posts as $post)
        <li>{{$post->naslov}} - {{$post->author}}</li>
    @empty
        <p>Nema postova :(</p>
    @endforelse
  </ul>
@endsection