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
//Intent: 4 - ort_Veranstaltung
$botman->hears('say_Ort_Veranstaltung', 'App\Http\Controllers\Intents_Controller@ort_Veranstaltung')->middleware($dialogflow);

//################################################################################################################################################
//Intent: 4 - ort_Veranstaltung_withContext
  $botman->hears('say_Ort_Veranstaltung_withContext', 'App\Http\Controllers\Intents_Controller@ort_Veranstaltung_withContext')->middleware($dialogflow);

//################################################################################################################################################
//Intent: 3 - termin_Veranstaltung
  $botman->hears('say_termin_Veranstaltung', 'App\Http\Controllers\Intents_Controller@termin_Veranstaltung')->middleware($dialogflow);

//################################################################################################################################################
//Intent: 3 - termin_Veranstaltung_withContext
  $botman->hears('say_termin_Veranstaltung_withContext', 'App\Http\Controllers\Intents_Controller@termin_Veranstaltung_withContext')->middleware($dialogflow);

//################################################################################################################################################
//Intent: 5 - termin_Klausur
  $botman->hears('say_termin_Klausur', 'App\Http\Controllers\Intents_Controller@termin_Klausur') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 5 - termin_Klausur_withContext
  $botman->hears('say_termin_Klausur_withContext', 'App\Http\Controllers\Intents_Controller@termin_Klausur_withContext') ->middleware($dialogflow); //

//################################################################################################################################################
//Intent: 6 - credit_Anzahl
  $botman->hears('say_credit_Anzahl', 'App\Http\Controllers\Intents_Controller@credit_Anzahl') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 6 - credit_Anzahl_withContext
  $botman->hears('say_credit_Anzahl_withContext', 'App\Http\Controllers\Intents_Controller@credit_Anzahl_withContext') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 2 - kontakt_Mitarbeiter
  $botman->hears('say_mitarbeiter_Kontakt', 'App\Http\Controllers\Intents_Controller@mitarbeiter_Kontakt') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 8 - vorleistung_Klausur
  $botman->hears('say_vorleistung_Klausur', 'App\Http\Controllers\Intents_Controller@vorleistung_Klausur') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 8 - vorleistung_Klausur_withContext
  $botman->hears('say_vorleistung_Klausur_withContext', 'App\Http\Controllers\Intents_Controller@vorleistung_Klausur_withContext') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 9 - beschreibung_Veranstaltung
  $botman->hears('say_beschreibung_Veranstaltung', 'App\Http\Controllers\Intents_Controller@beschreibung_Veranstaltung') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 9 - beschreibung_Veranstaltung_withContext
  $botman->hears('say_beschreibung_Veranstaltung_withContext', 'App\Http\Controllers\Intents_Controller@beschreibung_Veranstaltung_withContext') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 10 - anmeldehilfe_Veranstaltung
  $botman->hears('say_anmeldehilfe_Veranstaltung', 'App\Http\Controllers\Intents_Controller@anmeldehilfe_Veranstaltung') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 10 - anmeldehilfe_Veranstaltung_withContext
  $botman->hears('say_anmeldehilfe_Veranstaltung_withContext', 'App\Http\Controllers\Intents_Controller@anmeldehilfe_Veranstaltung_withContext') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 11 - vorkenntnisse_Veranstaltung
  $botman->hears('say_vorkenntnisse_Veranstaltung', 'App\Http\Controllers\Intents_Controller@vorkenntnisse_Veranstaltung') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 11 - vorkenntnisse_Veranstaltung_withContext
  $botman->hears('say_vorkenntnisse_Veranstaltung_withContext', 'App\Http\Controllers\Intents_Controller@vorkenntnisse_Veranstaltung_withContext') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 13 - ansprechpartner_Veranstaltung
  $botman->hears('say_ansprechpartner_Veranstaltung', 'App\Http\Controllers\Intents_Controller@ansprechpartner_Veranstaltung') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 13 - ansprechpartner_Veranstaltung_withContext
  $botman->hears('say_ansprechpartner_Veranstaltung_withContext', 'App\Http\Controllers\Intents_Controller@ansprechpartner_Veranstaltung_withContext') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 14 - turnus_Veranstaltung
  $botman->hears('say_turnus_Veranstaltung', 'App\Http\Controllers\Intents_Controller@turnus_Veranstaltung') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 14 - turnus_Veranstaltung_withContext
  $botman->hears('say_turnus_Veranstaltung_withContext', 'App\Http\Controllers\Intents_Controller@turnus_Veranstaltung_withContext') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 15 - literatur_Veranstaltung
  $botman->hears('say_literatur_Veranstaltung', 'App\Http\Controllers\Intents_Controller@literatur_Veranstaltung') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 15 - literatur_Veranstaltung_withContext
  $botman->hears('say_literatur_Veranstaltung_withContext', 'App\Http\Controllers\Intents_Controller@literatur_Veranstaltung_withContext') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 16 - klausur_Anmeldung
  $botman->hears('say_klausur_Anmeldung', 'App\Http\Controllers\Intents_Controller@klausur_Anmeldung') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 16 - klausur_Anmeldung_withContext
  $botman->hears('say_klausur_Anmeldung_withContext', 'App\Http\Controllers\Intents_Controller@klausur_Anmeldung_withContext') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 17 - gesamtueberblick_Veranstaltung
  $botman->hears('say_gesamtueberblick_Veranstaltung', 'App\Http\Controllers\Intents_Controller@gesamtueberblick_Veranstaltung') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 17 - gesamtueberblick_Veranstaltung_withContext
  $botman->hears('say_gesamtueberblick_Veranstaltung_withContext', 'App\Http\Controllers\Intents_Controller@gesamtueberblick_Veranstaltung_withContext') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 18 - veranstaltungen_Mitarbeiter
  $botman->hears('say_veranstaltungen_Mitarbeiter', 'App\Http\Controllers\Intents_Controller@veranstaltungen_Mitarbeiter') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 18 - veranstaltungen_Mitarbeiter_withContext
  $botman->hears('say_veranstaltungen_Mitarbeiter_withContext', 'App\Http\Controllers\Intents_Controller@veranstaltungen_Mitarbeiter_withContext') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 19 - abschlussarbeiten_Mitarbeiter
  $botman->hears('say_abschlussarbeiten_Mitarbeiter', 'App\Http\Controllers\Intents_Controller@abschlussarbeiten_Mitarbeiter') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 19 - abschlussarbeiten_Mitarbeiter_withContext
  $botman->hears('say_abschlussarbeiten_Mitarbeiter_withContext', 'App\Http\Controllers\Intents_Controller@abschlussarbeiten_Mitarbeiter_withContext') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: 20 - projekte_Lehrstuhl
  $botman->hears('say_projekte_Lehrstuhl', 'App\Http\Controllers\Intents_Controller@projekte_Lehrstuhl') ->middleware($dialogflow);

//################################################################################################################################################
//Intent: Default Fallback Intent
$botman->hears('input.unknown', function ($bot) {
  $bot->startConversation(new App\Http\Conversations\Fallback);
})->middleware($dialogflow);
