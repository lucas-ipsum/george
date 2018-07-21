<?php
use App\Http\Controllers\BotManController;
use BotMan\BotMan\Middleware\Dialogflow;         //Import Dialogflow Middleware API
use BotMan\BotMan\Messages\Attachments\Video;
use BotMan\BotMan\Messages\Attachments\OutgoingMessage;
use BotMan\BotMan\Storages\Storage;


$botman = resolve('botman');

// Dialogflow integration

$dialogflow = Dialogflow::create('2995d36e25a74557b14f26acc6610a15')->listenForAction(); //Client access token Dialogflow eingefügt

$botman->middleware->received($dialogflow); //Jede Nachricht die ankommt wird an die Middleware geschickt

//


//################################################################################################################################################
//Versuch Attachments
$botman->hears('sayHallo', function ($bot) {
  $message = OutgoingMessage::create('This is your video')->withAttachment(
  		new video('https://www.html5rocks.com/en/tutorials/video/basics/devstories.webm')
  	);
  	$bot->reply($message);

// Default Welcome Intent
//$botman->hears('sayHallo', function ($bot) {

  //  $bot->reply('Willkommen bei der Professur für Anwendnungssysteme und E-Business. Wir helfen Ihnen gerne mit Fragen zu unseren Veranstaltungen und Mitarbeitern weiter. Was können wir für Sie tun?');

})->middleware($dialogflow);      //Hört nur auf Middleware Intents gibt der NUtzer den Intent als eingabe ein wird nicht gematcht

//################################################################################################################################################
//Intent: 4 - ort_Veranstaltung
$botman->hears('sayOrt', function ($bot) {

  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung']; //Sucht nach Veranstaltung in Paramtern von Dialogflow und speichert sie in Variable
  $veranstaltungsart = $extras['apiParameters']['Veranstaltungsart'];
//Speichern
$bot->userStorage()->save([
  'Veranstaltung' => $veranstaltung
  ]);
//Prompts
if(strlen($veranstaltung) === 0) {
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
}
elseif(strlen($veranstaltungsart) === 0){
    $bot->reply('Möchten Sie diese Information zur Vorlesung, Übung oder dem Tutorium?');
}
else{
//Antowort
      $bot->reply($veranstaltung.' '.'('.$veranstaltungsart.') ist im Raum ZHG 103.');  //Platzhalter für Raum abfragen, der aus DB geholt wird
}
})->middleware($dialogflow);

//################################################################################################################################################
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
//Antowort
      $bot->reply($veranstaltung.' '.'('.$veranstaltungsart.') findet am Dienstag von 12:15 bis 13:45 statt');  //Platzhalter für Raum abfragen, der aus DB geholt wird
}
})->middleware($dialogflow);

//################################################################################################################################################
//Intent: 13 - ansprechpartner_Veranstaltung
$botman->hears('say_ansprechpartner', function ($bot) {
    $veranstaltung_context = $bot->userStorage()->get('Veranstaltung');
    $extras = $bot->getMessage()->getExtras();
    $veranstaltung = $extras['apiParameters']['Veranstaltung'];
//Prompts
if(strlen($veranstaltung && $veranstaltung_context) === 0) {
  $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
}
elseif (strlen($veranstaltung) > 0) {
  $bot->reply('Ansprechpartner für ' . $veranstaltung . 'ist Pascal Freier');
}
else {
  $bot->reply('Ansprechpartner für ' . $veranstaltung_context . 'ist Pascal Freier');
}

})->middleware($dialogflow);

//################################################################################################################################################
//Intent: 5 - termin_Klausur
$botman->hears('say_termin_Klausur', function ($bot) {
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
  $bot->reply('Die Klausur in ' . $veranstaltung . ' ist am 13.08.2018');         //Dieser Fall wird aufgerufen, wenn die Veranstaltung in der Anfrage mit eingegeben wurde
}
else {
  $bot->reply('Die Klausur in ' . $veranstaltung_context . ' ist am 13.08.2018'); //Dieser Fall wird aufgerufen, wenn die Veranstaltung aus dem Context geholt wird 
}

})->middleware($dialogflow);
