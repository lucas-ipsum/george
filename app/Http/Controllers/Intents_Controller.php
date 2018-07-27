<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BotMan\BotMan\Storages\Storage;
//use BotMan\BotMan\Middleware\Dialogflow;

class Intents_Controller extends Controller
{
    public function beschreibung_Veranstaltung($bot){
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
  public function mitarbeiter_Kontakt($bot){
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
  $bot->reply('Die ' . $kontaktart . ' von ' . $mitarbeiter . ' lautet: Tel. ...');
  }

  }
//###############################################################

public function ansprechpartner_Veranstaltung($bot){
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
$bot->reply('Ansprechpartner für ' . $veranstaltung . ' ist Pascal Freier');
}
else {
$bot->reply('Ansprechpartner für ' . $veranstaltung_context . ' ist Pascal Freier');
}

}

//###############################################################

public function Anmelderegeln($bot){
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
//###############################################################
public function vorkenntnisse_Veranstaltung($bot){
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
$bot->reply('Voraussetzungen');
}
else {
$bot->reply('Voraussetzungen mit Context');
}

}
//###############################################################
public function vorleistung_Klausur($bot){
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
//###############################################################

}
