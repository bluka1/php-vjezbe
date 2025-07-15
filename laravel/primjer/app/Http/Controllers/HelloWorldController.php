<?php

namespace App\Http\Controllers;

use App\Services\HelloWorldService;
use Illuminate\Http\Request;

class HelloWorldController extends Controller
{
  public function pozdrav(HelloWorldService $helloWorldService) {
    echo $helloWorldService->hello();
  }
}
