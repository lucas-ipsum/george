<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\ExampleConversation;

class BotManController extends Controller
{
  //Aufruf vom Index View (Lehrstuhl Website + Bot)
  public function index()
  {
      return view('index');
  }

    public function chat()
  {
      return view('chat');
  }

    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

}
