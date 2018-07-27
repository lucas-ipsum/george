<?php
use App\Http\Controllers\BotManController;
use BotMan\BotMan\Middleware\Dialogflow;         //Import Dialogflow Middleware API
use BotMan\BotMan\Messages\Attachments\Video;
use BotMan\BotMan\Messages\Attachments\OutgoingMessage;
use BotMan\BotMan\Storages\Storage;             // Import zum speichern von Nutzereingaben
//Buttons
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Conversations\Conversation;
//Import Controller
use App\Http\Controllers\Intents_Controller;



$botman = resolve('botman');

// Dialogflow integration

$dialogflow = Dialogflow::create('6528f020cb224358a4863f656c5a0294')->listenForAction(); //Client access token Dialogflow eingefügt

$botman->middleware->received($dialogflow); //Jede Nachricht die ankommt wird an die Middleware geschickt

//################################################################################################################################################
//Versuch Attachments
$botman->hears('sayHallo', function ($bot) {
  $message = OutgoingMessage::create('This is your video')->withAttachment(
  		new Video('https://www.html5rocks.com/en/tutorials/video/basics/devstories.webm')
  	);
  	$bot->reply($message);

// Default Welcome Intent
//$botman->hears('sayHallo', function ($bot) {

  //  $bot->reply('Willkommen bei der Professur für Anwendnungssysteme und E-Business. Wir helfen Ihnen gerne mit Fragen zu unseren Veranstaltungen und Mitarbeitern weiter. Was können wir für Sie tun?');

})->middleware($dialogflow);      //Hört nur auf Middleware Intents gibt der NUtzer den Intent als eingabe ein wird nicht gematcht

//################################################################################################################################################
//Intent: 4 - ort_Veranstaltung
$botman->hears('say_Ort_Veranstaltung', 'App\Http\Controllers\Intents_Controller@ort_Veranstaltung')->middleware($dialogflow);

//################################################################################################################################################
//Intent: 4 - ort_Veranstaltung_withContext
$botman->hears('say_Ort_Veranstaltung_withContext', 'App\Http\Controllers\Intents_Controller@ort_Veranstaltung_withContext')->middleware($dialogflow);

//################################################################################################################################################
//Intent: 3 - termin_Veranstaltung
  $botman->hears('say_terminVeranstaltung', 'App\Http\Controllers\Intents_Controller@termin_Veranstaltung')->middleware($dialogflow);

//################################################################################################################################################
//Intent: 3 - termin_Veranstaltung_withContext
  $botman->hears('say_terminVeranstaltung_withContext', 'App\Http\Controllers\Intents_Controller@termin_Veranstaltung_withContext')->middleware($dialogflow);

//################################################################################################################################################
//Intent: 5 - termin_Klausur
  $botman->hears('say_termin_Klausur', 'App\Http\Controllers\Intents_Controller@termin_Klausur') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 6 - credit_Anzahl
  $botman->hears('say_creditAnzahl', 'App\Http\Controllers\Intents_Controller@credit_Anzahl') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 2 - kontakt_Mitarbeiter
  $botman->hears('say_mitarbeiter_Kontakt', 'App\Http\Controllers\Intents_Controller@mitarbeiter_Kontakt') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 8 - vorleistung_Klausur
  $botman->hears('say_vorleistung_Klausur', 'App\Http\Controllers\Intents_Controller@vorleistung_Klausur') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 9 - beschreibung_Veranstaltung
  $botman->hears('say_beschreibung_Veranstaltung', 'App\Http\Controllers\Intents_Controller@beschreibung_Veranstaltung') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 10 - Anmelderegeln
  $botman->hears('say_anmelderegeln', 'App\Http\Controllers\Intents_Controller@Anmelderegeln') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 11 - vorkenntnisse_Veranstaltung
  $botman->hears('say_vorkenntnisse_Veranstaltung', 'App\Http\Controllers\Intents_Controllerg@vorkenntnisse_Veranstaltung') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 13 - ansprechpartner_Veranstaltung
  $botman->hears('say_ansprechpartner', 'App\Http\Controllers\Intents_Controller@ansprechpartner_Veranstaltung') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: Default Fallback Intent
$botman->hears('input.unknown', function ($bot) {
  $bot->startConversation(new App\Http\Conversations\Fallback);
})->middleware($dialogflow);
