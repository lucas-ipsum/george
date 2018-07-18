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
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');
/*//Botman Fallback Funktion
        $botman->fallback(function($bot) {
          $bot->types();
          $bot->reply('Entschuldige bitte, ich habe deine Frage nicht verstanden.');
        });
*/
        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new ExampleConversation());
    }

}
