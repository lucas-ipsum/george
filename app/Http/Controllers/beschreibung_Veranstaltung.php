<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BotMan\BotMan\Storages\Storage;
use BotMan\BotMan\Middleware\Dialogflow;

class beschreibung_Veranstaltung extends Controller
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
    $bot->reply('Die Veranstaltung Management der Informationssysteme beschäftigt sich mit der produktorientierten Gestaltung der betrieblichen Informationsverarbeitung. Unter Produkt wird hier das Anwendungssystem bzw. eine ganze Landschaft aus Anwendungssystemen verstanden, die es zu gestalten und organisieren gilt. Der Fokus der Veranstaltung liegt auf der Vermittlung von vorgehensweisen sowie Methoden und konkreten Instrumenten, welche es erlauben, Anwendungssysteme logisch-konzeptionell zu gestalten.');         //Dieser Fall wird aufgerufen, wenn die Veranstaltung in der Anfrage mit eingegeben wurde
    }
    else {
    $bot->reply('Die Veranstaltung Management der Informationssysteme beschäftigt sich mit der produktorientierten Gestaltung der betrieblichen Informationsverarbeitung. Unter Produkt wird hier das Anwendungssystem bzw. eine ganze Landschaft aus Anwendungssystemen verstanden, die es zu gestalten und organisieren gilt. Der Fokus der Veranstaltung liegt auf der Vermittlung von vorgehensweisen sowie Methoden und konkreten Instrumenten, welche es erlauben, Anwendungssysteme logisch-konzeptionell zu gestalten.'); //Dieser Fall wird aufgerufen, wenn die Veranstaltung aus dem Context geholt wird

    }
  }
}
