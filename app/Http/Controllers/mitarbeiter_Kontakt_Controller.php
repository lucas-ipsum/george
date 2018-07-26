<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BotMan\BotMan\Storages\Storage;
use BotMan\BotMan\Middleware\Dialogflow;

class mitarbeiter_Kontakt_Controller extends Controller
{
  public function conversation ($bot){
  //$veranstaltung_context = $bot->userStorage()->get('Veranstaltung');
  $extras = $bot->getMessage()->getExtras();
  $mitarbeiter = $extras['apiParameters']['Mitarbeiter'];
  $kontaktart = $extras['apiParameters']['Kontaktart'];
//Speichern
//$bot->userStorage()->save([
//    'Veranstaltung' => $veranstaltung
//]);
//Prompts
if(strlen($mitarbeiter) ===  0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
$bot->reply('Welchen Mitarbeiter möchten Sie kontaktieren?');
}
elseif (strlen($kontaktart) === 0) {
$bot->reply('Wie möchten Sie ' . $mitarbeiter . ' kontaktieren?');
}
else {
$bot->reply('Die ' . $kontaktart . 'von ' . $mitarbeiter . 'lautet: Platzhalter Kontakt');
 }

}

}
