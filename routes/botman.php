<?php
use App\Http\Controllers\BotManController;
use App\Http\Controllers\DBController;
use BotMan\BotMan\Middleware\Dialogflow;         //Import Dialogflow Middleware API
use Illuminate\Support\Facades\DB;               // nutze die Datenbank

$botman = resolve('botman');

//Versuch Dialogflow integration

$dialogflow = Dialogflow::create('2995d36e25a74557b14f26acc6610a15')->listenForAction(); //Client access token Dialogflow eingefügt

$botman->middleware->received($dialogflow); //Jede Nachricht die ankommt wird an die Middleware geschickt

// Default Welcome Intent
$botman->hears('sayHallo', function ($bot) {

      $bot->reply('Willkommen bei der Professur für Anwendnungssysteme und E-Business. Wir helfen Ihnen gerne mit Fragen zu unseren Veranstaltungen und Mitarbeitern weiter. Was können wir für Sie tun?');

})->middleware($dialogflow);      //Hört nur auf Middleware Intents gibt der NUtzer den Intent als eingabe ein wird nicht gematcht



//Intent: 4 - ort_Veranstaltung
$botman->hears('sayOrt', function ($bot) {

  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung']; //Sucht nach Veranstaltung in Paramtern von Dialogflow und speichert sie in Variable
  $veranstaltungsart = $extras['apiParameters']['Veranstaltungsart'];
//Prompts
if(strlen($veranstaltung) === 0) {      //&& strlen($veranstaltungsart) > 0
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
}
elseif(strlen($veranstaltungsart) === 0){
    $bot->reply('Möchten Sie diese Information zur Vorlesung, Übung oder dem Tutorium?');
}
else{
//Antowort
      // Rufe den Datenbankcontroller für die Abfrage auf
      $raum = DBController::getDBRaum($veranstaltung, $veranstaltungsart);

      //Platzhalter für Raum abfragen, der aus DB geholt wird
      $bot->reply($veranstaltung.' '.'('.$veranstaltungsart.') ist im Raum '.$raum.'.');
}
})->middleware($dialogflow);



//Intent: 3 - termin_Veranstaltung
$botman->hears('say_terminVeranstaltung', function ($bot) {

  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung']; //Sucht nach Veranstaltung in Paramtern von Dialogflow und speichert sie in Variable
  $veranstaltungsart = $extras['apiParameters']['Veranstaltungsart'];
//Prompts
if(strlen($veranstaltung) === 0) {
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
}
elseif(strlen($veranstaltungsart) === 0){
    $bot->reply('Möchten Sie diese Information zur Vorlesung, Übung oder dem Tutorium?');
}
else{
//Antwort
      // Rufe den Datenbankcontroller für die Abfrage auf
      $uhrzeit = DBController::getDBUhrzeit($veranstaltung, $veranstaltungsart);
      $datum = DBController::getDBDatum($veranstaltung, $veranstaltungsart);

      //Platzhalter für Raum/Uhrzeit abfragen, der aus DB geholt wird
      $bot->reply($veranstaltung.' '.'('.$veranstaltungsart.') findet am '.$datum.' um '.$uhrzeit.' statt');
}
})->middleware($dialogflow);
