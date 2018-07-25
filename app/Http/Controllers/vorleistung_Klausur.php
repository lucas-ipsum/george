<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BotMan\BotMan\Storages\Storage;
use BotMan\BotMan\Middleware\Dialogflow;

class vorleistung_Klausur extends Controller
{
  public function conversation ($bot){
  $veranstaltung_context = $bot->userStorage()->get('Veranstaltung');
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung'];
//Speichern
$bot->userStorage()->save([
    'Veranstaltung' => $veranstaltung
]);
//Prompts
if(strlen($veranstaltung) ===  0 && strlen($veranstaltung_context) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
$bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
}
elseif (strlen($veranstaltung) > 0) {
$bot->reply('Vorleistung zur Klausur in ' . $veranstaltung . ': Die Übung stellt eine Vorleistung zur Klausur dar. Während des Semesters müssen drei Aufgaben zu den Inhalten Vorlesung bearbeitet werden. Alle Aufgaben müssen bestanden sein, um an der Klausur am Ende des Semesters teilzunehmen.');
}
else {
$bot->reply('Vorleistung zur Klausur in ' . $veranstaltung_context . ': Die Übung stellt eine Vorleistung zur Klausur dar. Während des Semesters müssen drei Aufgaben zu den Inhalten Vorlesung bearbeitet werden. Alle Aufgaben müssen bestanden sein, um an der Klausur am Ende des Semesters teilzunehmen.');
 }

}

}
