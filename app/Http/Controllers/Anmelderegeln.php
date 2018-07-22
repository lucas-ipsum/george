<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BotMan\BotMan\Storages\Storage;
use BotMan\BotMan\Middleware\Dialogflow;

class Anmelderegeln extends Controller
{
      public function conversation($bot){
        $veranstaltung_context = $bot->userStorage()->get('Veranstaltung');
        $extras = $bot->getMessage()->getExtras();
        $veranstaltung = $extras['apiParameters']['Veranstaltung'];
        //Speichern
        $bot->userStorage()->save([
          'Veranstaltung' => $veranstaltung
        ]);
      //Prompts + Antworten
      if(strlen($veranstaltung) ===  0 && strlen($veranstaltung_context) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
      $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
      }
      elseif (strlen($veranstaltung) > 0) {
      $bot->reply('Anmelderegeln');         //Dieser Fall wird aufgerufen, wenn die Veranstaltung in der Anfrage mit eingegeben wurde
      }
      else {
      $bot->reply('Anmelderegeln mit Context'); //Dieser Fall wird aufgerufen, wenn die Veranstaltung aus dem Context geholt wird

      }
    }
  }
