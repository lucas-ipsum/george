<?php

namespace App\Http\Controllers;
use App\veranstaltung;
use App\mitarbeiter;
use App\betreuung;
use App\termine;
use App\projekte;
use App\themen_im_bachelorseminar;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Http\Controllers\Conversations;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DBController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use BotMan\BotMan\Storages\Storage;
//use BotMan\BotMan\Middleware\Dialogflow;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Attachments\Image;
use Carbon\Carbon;


class Intents_Controller extends Controller
{
//###############################################################
//Intent: 6 - credit_Anzahl
  public function credit_Anzahl($bot){
    $extras = $bot->getMessage()->getExtras();
    $veranstaltung = $extras['apiParameters']['Veranstaltung'];
    $this->credit_Anzahl_Logik($bot, $veranstaltung);
  }
  public function credit_Anzahl_withContext($bot){
    $extras = $bot->getMessage()->getExtras();
    $veranstaltung = $extras['apiContext']['Veranstaltung'];
    $this->credit_Anzahl_Logik($bot, $veranstaltung);
  }
  public function credit_Anzahl_Logik($bot, $veranstaltung){
    //Prompts + Antworten
    if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
    }
    else {
    $credits = DBController::getDBCredits($veranstaltung);
    $bot->reply('Die Veranstaltung ' . $veranstaltung . ' bringt '.$credits.' Credits');         //Dieser Fall wird aufgerufen, wenn die Veranstaltung in der Anfrage mit eingegeben wurde
    }
  }
//###############################################################
//Intent: 4 - ort_Veranstaltung
public function ort_Veranstaltung($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung']; //Sucht nach Veranstaltung in Paramtern von Dialogflow und speichert sie in Variable
  $veranstaltungsart = $extras['apiParameters']['Veranstaltungsart'];
  $this->ort_Veranstaltung_Logik($bot, $veranstaltung, $veranstaltungsart);
}
public function ort_Veranstaltung_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung']; //Sucht nach Veranstaltung in Paramtern von Dialogflow und speichert sie in Variable
  $veranstaltungsart = $extras['apiContext']['Veranstaltungsart'];
  $this->ort_Veranstaltung_Logik($bot, $veranstaltung, $veranstaltungsart);
}
  public function ort_Veranstaltung_Logik($bot, $veranstaltung, $veranstaltungsart){
  //Prompts
  //Hier wird geprüft, ob alle nötigen Informationen vorhanden sind und ob sie aus dem Context aufgegriffen werden können
  if(strlen($veranstaltung) ===  0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
  }
  elseif(strlen($veranstaltungsart) ===  0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Möchten Sie diese Information zur Vorlesung, Übung oder dem Tutorium?');
  }
  else{
      $raum = DBController::getDBRaum($veranstaltung, $veranstaltungsart);
      if(strlen($raum) === 0) {
        $bot->reply('Diese Veranstaltungsart ist in ' . $veranstaltung . ' leider nicht verfügbar.');
      }
      else{
        $bot->reply($veranstaltung . ' (' . $veranstaltungsart . ') ist im Raum ' .  $raum . '.');  //Platzhalter für Raum abfragen, der aus DB geholt wird
      }
  }
}

//###############################################################
//Intent: 3 - veranstaltung_Termin
public function termin_Veranstaltung($bot){
  //Aufruf der Extras der Dialogflow Middleware. Hier auf Elemente des JSONs von Dialogflow zugegriffen werden
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung']; //Sucht nach Veranstaltung in Paramtern von Dialogflow und speichert sie in Variable
  $veranstaltungsart = $extras['apiParameters']['Veranstaltungsart'];
  $this->termin_Veranstaltung_Logik($bot, $veranstaltung, $veranstaltungsart);
}
public function termin_Veranstaltung_withContext($bot){
  //Aufruf der Extras der Dialogflow Middleware. Hier auf Elemente des JSONs von Dialogflow zugegriffen werden
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung']; //Sucht nach Veranstaltung in Paramtern von Dialogflow und speichert sie in Variable
  $veranstaltungsart = $extras['apiContext']['Veranstaltungsart'];
  $this->termin_Veranstaltung_Logik($bot, $veranstaltung, $veranstaltungsart);
}
  public function termin_Veranstaltung_Logik($bot, $veranstaltung, $veranstaltungsart){
//Prompts
//Hier wird geprüft, ob alle nötigen Informationen vorhanden sind und ob sie aus dem Context aufgegriffen werden können
    if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
      $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
    }
    elseif(strlen($veranstaltungsart) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
      $bot->reply('Möchten Sie diese Information zur Vorlesung, Übung oder dem Tutorium?');
    }
    else{
      //Antowort
      // Rufe den Datenbankcontroller für die Abfrage auf
      $uhrzeit = DBController::getDBUhrzeit($veranstaltung, $veranstaltungsart);
      $datum = DBController::getDBDatum($veranstaltung, $veranstaltungsart);
      $bot->reply($veranstaltung.' '.'('.$veranstaltungsart.') findet '.$datum.' um '.$uhrzeit.' statt');  //Platzhalter für Raum abfragen, der aus DB geholt wird
    }
  }
//###############################################################
// Intent: 5 - termin_Klausur
public function termin_Klausur($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung'];
  $this->termin_Klausur_Logik($bot, $veranstaltung);
}
public function termin_Klausur_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];
  $this->termin_Klausur_Logik($bot, $veranstaltung);
}
public function termin_Klausur_Logik($bot, $veranstaltung){
  //Prompts
  if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
  }
  else {
      $klausurtermin = DBController::getDBKlausurtermin($veranstaltung);
      $ausgabe_klausuren='';
      for($index=0; $index < count($klausurtermin); $index++)
      {
        $datum = $klausurtermin[$index]->Datum1;
        $wochentag = $klausurtermin[$index]->Wochentag;
        $uhrzeit= $klausurtermin[$index]->Uhrzeit;
        $raum = $klausurtermin[$index]->Raum;
        $ausgabe_klausuren .= $datum . ' ' . $wochentag . ' ' . $uhrzeit . '<br>'.$raum .'<br>';
      }
      $bot->reply('Klausurtermine in ' . $veranstaltung . ': <br> '.$ausgabe_klausuren); //Dieser Fall wird aufgerufen, wenn die Veranstaltung aus dem Context geholt wird
  }
}
//###############################################################
//Intent: 9 - beschreibung_Veranstaltung
public function beschreibung_Veranstaltung($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung'];
  $this->beschreibung_Veranstaltung_Logik($bot, $veranstaltung);
  }
public function beschreibung_Veranstaltung_withContext($bot){
    $extras = $bot->getMessage()->getExtras();
    $veranstaltung = $extras['apiContext']['Veranstaltung'];
      $this->beschreibung_Veranstaltung_Logik($bot, $veranstaltung);
}
public function beschreibung_Veranstaltung_Logik($bot, $veranstaltung){
  //Prompts + Antworten
    if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
      $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
    }
    else {
          $beschreibung = DBController::getDBBeschreibung($veranstaltung);
          $bot->reply($veranstaltung .': <br><br>' . $beschreibung);
          }
    }
//###############################################################
//Intent: 2 - mitarbeiter_Kontakt
public function mitarbeiter_Kontakt($bot){
  $extras = $bot->getMessage()->getExtras();
  $mitarbeiter = $extras['apiParameters']['Mitarbeiter'];
  $kontaktart = $extras['apiParameters']['Kontaktart'];
  //Prompts
  if(strlen($mitarbeiter) === 0) {       //Dieser Fall wird aufgerufen, wenn kein Mitarbeiter eingegeben wurde
  $bot->reply('Welchen Mitarbeiter möchtest du kontaktieren?');
  }
  elseif(strlen($kontaktart) === 0) {    //Nachfrage Kontaktart falls diese nicht eingegeben wurde
          $bot->reply('Wie möchtest du ' . $mitarbeiter . ' kontaktieren?');
  }
  else {
        $Contact = 'pfreier@uni-goettingen.de';//DBController::getDBKontaktart($kontaktart, $mitarbeiter);
        $bot->reply('Die ' . $kontaktart . ' von ' . $mitarbeiter . ' lautet: ' . $Contact . '.');
        }
  }

//###############################################################
//Intent: 13 - ansprechpartner_Veranstaltung
 public function ansprechpartner_Veranstaltung($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung'];
  $this->ansprechpartner_Veranstaltung_Logik($bot, $veranstaltung);
}

 public function ansprechpartner_Veranstaltung_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];
  $this->ansprechpartner_Veranstaltung_Logik($bot, $veranstaltung);
}
 public function ansprechpartner_Veranstaltung_Logik($bot, $veranstaltung){
   //Prompts
   if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
     $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
   }
   else {
     $mitarbeiter = DBController::getDBansprechpartner($veranstaltung);
     $ausgabe = '';
   for($index=0; $index < count($mitarbeiter); $index++){
     $test = $mitarbeiter[$index]->Betreuer;
     $ausgabe .= $test . '<br> ';
   }
    $bot->reply('Ansprechpartner für ' . $veranstaltung . ': <br>' . $ausgabe);
   }
}

//###############################################################
//Intent: 10 - anmeldehilfe_Veranstaltung
public function anmeldehilfe_Veranstaltung($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung'];
  $this->anmeldehilfe_Veranstaltung_Logik($bot, $veranstaltung);
}
public function anmeldehilfe_Veranstaltung_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];
  $this->anmeldehilfe_Veranstaltung_Logik($bot, $veranstaltung);
}
public function anmeldehilfe_Veranstaltung_Logik($bot, $veranstaltung){
//Prompts + Antworten
    if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
      $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
    }
    else {
        $anmeldung = DBController::getDBAnmeldung($veranstaltung);
        $bot->reply('Die Anmelderegeln für '.$veranstaltung.' sind:  <br>'.$anmeldung.'.');
    }
}
//###############################################################
//Intent: 11 - vorkenntnisse_Veranstaltung
public function vorkenntnisse_Veranstaltung($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung'];
  $this->vorkenntnisse_Veranstaltung_Logik($bot, $veranstaltung);
}
public function vorkenntnisse_Veranstaltung_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];
  $this->vorkenntnisse_Veranstaltung_Logik($bot, $veranstaltung);
}
public function vorkenntnisse_Veranstaltung_Logik($bot, $veranstaltung){
//Prompts
  if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
  }
  else {
    $vorkenntnisse = DBController::getDBVoraussetzung($veranstaltung);
    $bot->reply('Die Vorkenntnisse für '.$veranstaltung.' sind:  '.$vorkenntnisse.'.');
  }
}
//###############################################################
//Intent: 8 - vorleistung_Klausur
public function vorleistung_Klausur($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung'];
  $this->vorleistung_Klausur_Logik($bot, $veranstaltung);
}
public function vorleistung_Klausur_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];
  $this->vorleistung_Klausur_Logik($bot, $veranstaltung);
}
public function vorleistung_Klausur_Logik($bot, $veranstaltung){
//Prompts
  if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
  }
  else {
    $vorleistung = DBController::getDBVorleistung($veranstaltung);
    $bot->reply('Vorleistung zur Klausur in ' . $veranstaltung . ': '.$vorleistung.'.');
  }
}
//###############################################################
//Intent 14 - turnus_Veranstaltung
public function turnus_Veranstaltung($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung'];
  $this->turnus_Veranstaltung_Logik($bot, $veranstaltung);
}
public function turnus_Veranstaltung_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];
  $this->turnus_Veranstaltung_Logik($bot, $veranstaltung);
}
public function turnus_Veranstaltung_Logik($bot, $veranstaltung){
//Prompts
  if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
  }
  else {
    $turnus = DBController::getDBTurnus($veranstaltung);
    $bot->reply('Turnus der Veranstaltung ' . $veranstaltung . ' ist: '.$turnus.'.');
  }
}
//###############################################################
//Intent 15 - literatur_Veranstaltung
public function literatur_Veranstaltung($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung'];
  $this->literatur_Veranstaltung_Logik($bot, $veranstaltung);
}
public function literatur_Veranstaltung_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];
  $this->literatur_Veranstaltung_Logik($bot, $veranstaltung);
}
  public function literatur_Veranstaltung_Logik($bot, $veranstaltung){
    //Prompts
      if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
        $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
      }
      else {
        $literatur = DBController::getDBLiteratur($veranstaltung);
        $bot->reply('Literatur der Veranstaltung ' . $veranstaltung . ': <br>'.$literatur.'.');
      }
  }
//###############################################################
//Intent 16 - klausur_Anmeldung
public function klausur_Anmeldung($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung'];
  $this->klausur_Anmeldung_Logik($bot, $veranstaltung);
}
public function klausur_Anmeldung_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];
  $this->klausur_Anmeldung_Logik($bot, $veranstaltung);
}
public function klausur_Anmeldung_Logik($bot, $veranstaltung){
//Prompts
  if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
  }
  else {
    $bot->reply('Klausuranmeldung in  ' . $veranstaltung . ':  https://flexnow2.uni-goettingen.de/FN2AUTH/login.jsp');
  }
}
//###############################################################
//Intent 17 - gesamtueberblick_Veranstaltung
public function gesamtueberblick_Veranstaltung($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung'];
  $this->gesamtueberblick_Veranstaltung_Logik($bot, $veranstaltung);
}
public function gesamtueberblick_Veranstaltung_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];
  $this->gesamtueberblick_Veranstaltung_Logik($bot, $veranstaltung);
}
public function gesamtueberblick_Veranstaltung_Logik($bot, $veranstaltung){
//Prompts
  if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
  }
  else {
    $ueberblick = DBController::getDBUeberblick($veranstaltung);
    $bot->reply('Die Zusammenfassung Organisatorisches ' . $veranstaltung . ' ist unter: '.$ueberblick.' ');
  }
}
//###############################################################
//Intent 18 - veranstaltungen_Mitarbeiter
public function veranstaltungen_Mitarbeiter($bot){
  $extras = $bot->getMessage()->getExtras();
  $mitarbeiter = $extras['apiParameters']['Mitarbeiter'];
  $this->veranstaltungen_Mitarbeiter_Logik($bot, $mitarbeiter);
}
public function veranstaltungen_Mitarbeiter_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $mitarbeiter = $extras['apiContext']['Mitarbeiter'];
  $this->veranstaltungen_Mitarbeiter_Logik($bot, $mitarbeiter);
}
public function veranstaltungen_Mitarbeiter_Logik($bot, $mitarbeiter){
//Prompts
  if(strlen($mitarbeiter) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welchen Mitarbeiter möchten Sie diese Information?');
  }
  else {
    $betreuer_Veranstaltungen = DBController::getDBBetreuung($mitarbeiter);
    $ausgabe_betreuer_Veranstaltungen = '';
    for($index=0; $index < count($betreuer_Veranstaltungen); $index++){
      $veranstaltung = $betreuer_Veranstaltungen[$index]->Name;
      $ausgabe_betreuer_Veranstaltungen .= $index+1 .'. '. $veranstaltung . '<br>';
    }
    $bot->reply('Liste Veranstaltungen von ' . $mitarbeiter . ': <br>' . $ausgabe_betreuer_Veranstaltungen);  //' . $mitarbeiter . '
  }
}
//###############################################################
//Intent 19 - abschlussarbeiten_Mitarbeiter
public function abschlussarbeiten_Mitarbeiter($bot){
  $extras = $bot->getMessage()->getExtras();
  $mitarbeiter = $extras['apiParameters']['Mitarbeiter'];
  $this->abschlussarbeiten_Mitarbeiter_Logik($bot, $mitarbeiter);
}
public function abschlussarbeiten_Mitarbeiter_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $mitarbeiter = $extras['apiContext']['Mitarbeiter'];
  $this->abschlussarbeiten_Mitarbeiter_Logik($bot, $mitarbeiter);
}
public function abschlussarbeiten_Mitarbeiter_Logik($bot, $mitarbeiter){
//Prompts
  if(strlen($mitarbeiter) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welchen Mitarbeiter möchten Sie diese Information?');
  }
  else {
    $bot->reply('Abschlussarbeiten von ' . $mitarbeiter . ': ');
  }
}
  //###############################################################
  //Intent 21 - foto_Mitarbeiter
  public function foto_Mitarbeiter($bot){
    $extras = $bot->getMessage()->getExtras();
    $mitarbeiter = $extras['apiParameters']['Mitarbeiter'];
//Prompts
    if(strlen($mitarbeiter) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
      $bot->reply('Für welchen Mitarbeiter möchten Sie diese Information?');
    }
    else{
    $url_Foto = DBController::getDB_fotoMitarbeiter($mitarbeiter);

    $message = OutgoingMessage::create('Hier ist ein Foto von '. $mitarbeiter)->withAttachment(Image::url(''.$url_Foto .''));  //URL Mitarbeiter Foto wird eingefügt
	   $bot->reply($message);
   }
  }
//###############################################################
//Intent 7 - naechster_Termin_Seminar
  public function naechster_Termin_Seminar($bot){
    $extras = $bot->getMessage()->getExtras();
    $seminar = $extras['apiParameters']['Seminar'];
//Datum heute
    $datum_heute = Carbon::now()->format('Y-m-d');            //Carbon holt das aktuelle Datum und bringt es In Format mit dem die DB auch arbeitet
//Prompts
    if(strlen($seminar) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
      $bot->reply('Für welches Seminar möchtest du diese Information?');
    }
    else{
      $naechster_termin = DBController::getDB_naechster_Termin_seminar($seminar, $datum_heute);
      $naechster_termin = $naechster_termin[0]->Datum1;
      $veranstaltungsart_Termin = DBController::getDB_art_Veranstaltung_nachTermin($seminar, $naechster_termin);
    //  $veranstaltungsart_Termin = $naechster_termin[0]->Veranstaltungsart;
      $naechster_termin = Carbon::parse($naechster_termin)->format('d.m.y');

      $bot->reply('Der nächste Termin in '. $seminar .': <br> '. $veranstaltungsart_Termin .' am ' . $naechster_termin);
    }
  }
//###############################################################
//Intent 22 - termin_Seminar
  public function termin_Seminar($bot){
    $extras = $bot->getMessage()->getExtras();
    $seminar = $extras['apiParameters']['Seminar'];
    $seminar_Veranstaltung = $extras['apiParameters']['Seminar_Veranstaltungen'];
    $this->termin_Seminar_Logik($bot, $seminar, $seminar_Veranstaltung);
  }
  public function termin_Seminar_withContext($bot){
      $extras = $bot->getMessage()->getExtras();
      $seminar = $extras['apiContext']['Seminar'];
      $seminar_Veranstaltung = $extras['apiContext']['Seminar_Veranstaltungen'];
      $this->termin_Seminar_Logik($bot, $seminar, $seminar_Veranstaltung);
  }
  public function termin_Seminar_Logik($bot, $seminar, $seminar_Veranstaltung){
    //Prompts
      if(strlen($seminar) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
        $bot->reply('Für welches Seminar möchtest du diese Information?');
      }
      elseif(strlen($seminar_Veranstaltung) === 0){
        $bot->reply('Welchen Seminartermin möchtest du? Pflicht-Blockkurs, Abgabe der Seminararbeit, Abgabe der Präsentation, Präsentation');
      }
      else {
        $termine_Seminar = DBController::getDB_termin_Seminar($seminar, $seminar_Veranstaltung);
        $ausgabe_termin_Seminar = '';
       for($index=0; $index < count($termine_Seminar); $index++){
          $datum_Seminar = $termine_Seminar[$index]->Datum1;
          $datum_Seminar = Carbon::parse($datum_Seminar)->format('d.m.y');
          $uhrzeit_Seminar = $termine_Seminar[$index]->Uhrzeit;
          $ausgabe_termin_Seminar .= $datum_Seminar . ' von ' . $uhrzeit_Seminar . '<br>';
      }
      $bot->reply('Termin: ' . $seminar.' '.'('.$seminar_Veranstaltung.'): <br>'. $ausgabe_termin_Seminar);
    }
  }
  //###############################################################
  //Intent 23 - ort_Seminar
    public function ort_Seminar($bot){
      $extras = $bot->getMessage()->getExtras();
      $seminar = $extras['apiParameters']['Seminar'];
      $seminar_Veranstaltung = $extras['apiParameters']['Seminar_Veranstaltungen'];
      $this->ort_Seminar_Logik($bot, $seminar, $seminar_Veranstaltung);
}
      public function ort_Seminar_withContext($bot){
        $extras = $bot->getMessage()->getExtras();
        $seminar = $extras['apiContext']['Seminar'];
        $seminar_Veranstaltung = $extras['apiContext']['Seminar_Veranstaltungen'];
        $this->ort_Seminar_Logik($bot, $seminar, $seminar_Veranstaltung);
    }
    public function ort_Seminar_Logik($bot, $seminar, $seminar_Veranstaltung){
    //Prompts
      if(strlen($seminar) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
        $bot->reply('Für welches Seminar möchtest du diese Information?');
      }
      elseif(strlen($seminar_Veranstaltung) === 0){
        $bot->reply('Für welche der Veranstaltungen möchtest du diese Information? Pflicht-Blockkurs, Abgabe der Seminararbeit, Abgabe der Präsentation oder Präsentation');
      }
      else {
        $raeume_Seminar = DBController::getDBRaumSeminar($seminar, $seminar_Veranstaltung);
        $ausgabe_raum_Seminar = '';
       for($index=0; $index < count($raeume_Seminar); $index++){
          $raum_Seminar = $raeume_Seminar[$index]->Raum;
          $ausgabe_raum_Seminar .= $raum_Seminar;
      }
      $bot->reply($seminar . ' (' . $seminar_Veranstaltung . ') ist im Raum ' .  $ausgabe_raum_Seminar . '.');
    }
}
//###############################################################
//Intent 24 - themen_Seminar
    public function themen_Seminar($bot){
      $extras = $bot->getMessage()->getExtras();
      $seminar = $extras['apiParameters']['Seminar'];
      //Prompts
        if(strlen($seminar) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
          $bot->reply('Für welches Seminar möchtest du diese Information?');
        }
        else {
          $seminar_themen = DBController::getDBThemen($seminar);
// Schleife für Ausgaben
         $ausgabe_seminar_themen = '';
          for($index=0; $index < count($seminar_themen); $index++){
            $thema = $seminar_themen[$index]->Thema;
            $ausgabe_seminar_themen .= $index+1 .'. ' .$thema . '<br><br> ';
          }
          $bot->reply('Folgende Themen werden im angeboten: <br><br>'. $ausgabe_seminar_themen);  //.$seminar .
        }
      }

//###############################################################
//Intent 25 - themen_Seminar_nachMitarbeiter
          public function themen_Seminar_nachMitarbeiter($bot){
            $extras = $bot->getMessage()->getExtras();
            $seminar = $extras['apiParameters']['Seminar'];
            $mitarbeiter= $extras['apiParameters']['Mitarbeiter'];
            $this->themen_Seminar_nachMitarbeiter_Logik($bot, $seminar, $mitarbeiter);
  }
    public function themen_Seminar_nachMitarbeiter_withContext($bot){
      $extras = $bot->getMessage()->getExtras();
      $seminar = $extras['apiContext']['Seminar'];
      $mitarbeiter= $extras['apiContext']['Mitarbeiter'];
      $this->themen_Seminar_nachMitarbeiter_Logik($bot, $seminar, $mitarbeiter);
}
    public function themen_Seminar_nachMitarbeiter_Logik($bot, $seminar, $mitarbeiter){
      //Prompts
        if(strlen($seminar) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
          $bot->reply('Für welches Seminar möchtest du diese Information?');
        }
        elseif(strlen($mitarbeiter) === 0){
          $bot->reply('Für welchen Mitarbeiter möchtest du diese Information?');
        }
        else {
          $seminar_themen_nachMitarbeiter = DBController::getDBThemen_nachMitarbeiter($seminar, $mitarbeiter);    //Daten werden aus DB Controller geholt
// Schleife für Ausgaben
         $ausgabe_seminar_themen_nachMitarbeiter = '';

          for($index=0; $index < count($seminar_themen_nachMitarbeiter); $index++){             //Index wird so lange erhöht bis letztes Element erreicht
              $nummer = $seminar_themen_nachMitarbeiter[$index]->Nummer;                          //Speichert den Wert für Nummer der aus der DB übergeben wurde
              $thema = $seminar_themen_nachMitarbeiter[$index]->Thema;
              $ausgabe_seminar_themen_nachMitarbeiter .= $nummer .'. ' .$thema . '<br><br> ';     //hier werden jeweils das Thema und die Nummer pro Schleifendurchlauf eingespeichert
          }
          //Ausgabe
          $bot->reply('Folgende Themen werden von ' . $mitarbeiter .' im ' .  $seminar . ' angeboten: <br><br>'. $ausgabe_seminar_themen_nachMitarbeiter);
      }
    }

//###############################################################
//Intent 26 - terminuebersicht_Seminar_withContext
        public function terminuebersicht_Seminar_withContext($bot){
          $extras = $bot->getMessage()->getExtras();
          $seminar = $extras['apiContext']['Seminar'];
        //Prompts
          if(strlen($seminar) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
            $bot->reply('Für welches Seminar möchtest du diese Information?');
          }
          else {
            $termine_Seminar = DBController::getDB_Termine_Seminar($seminar);
              $ausgabe_termine_Seminar = '';
            for($index = 0; $index < count($termine_Seminar); $index++){
              $datum = $termine_Seminar[$index]->Datum;
              $zeit = $termine_Seminar[$index]->Uhrzeit;
              $art = $termine_Seminar[$index]->Veranstaltungsart;
              $artAlt = '';
              if($index > 0){
                $test = $index - 1;
                $artAlt = $termine_Seminar[$test]->Veranstaltungsart;
              }
                if(strcmp($art, $artAlt) === 0){         //Wenn artdoppel gleich art
                $art_ausgabe = '';
                }
                else{
                  $art_ausgabe = $art . ': <br>';
                }

              $ausgabe_termine_Seminar .= $art_ausgabe . $datum .' '. $zeit . '<br>';
            }

            $bot->reply($ausgabe_termine_Seminar);
          }
        }
//###############################################################
//Projeke
//###############################################################
//Intent 20 - projekte_Lehrstuhl
  public function projekte_Lehrstuhl($bot){
    $projekte = DBController::getDBProjekte();
    $ausgabe_projekte = '';
    for($index=0; $index < count($projekte); $index++){
       $projekt = $projekte[$index]->Name;
       $id = $projekte[$index]->ID;
       $ausgabe_projekte .= $id .'. ' .$projekt . '<br><br> ';
     }

    $bot->reply($ausgabe_projekte);
  }
//###############################################################
//Intent 27 - beschreibung_Projekt
  public function beschreibung_Projekt($bot){
    $extras = $bot->getMessage()->getExtras();
    $projekt = $extras['apiParameters']['Projekt'];
  //Prompts
    if(strlen($projekt) === 0) {
      $bot->reply('Zu welchem Projekt möchtest du weitere Informationen haben?');
    }
    $projekt_Beschreibung = DBController::getDBprojektBeschreibung($projekt);
    //$test = (string)$projekt_Beschreibung;
    $bot->reply($projekt_Beschreibung);
  }

//###############################################################
//Intent 28 - kontaktperson_Projekt
  public function kontaktperson_Projekt($bot){
    $extras = $bot->getMessage()->getExtras();
    $projekt = $extras['apiParameters']['Projekt'];
  //Prompts
    if(strlen($projekt) === 0) {
      $bot->reply('Zu welchem Projekt möchtest du einen Mitarbeiter kontaktieren?');
    }
    $projekt_Kontaktperson = DBController::getDBprojektKontaktperson($projekt);
    $mail = $projekt_Kontaktperson[0]->Kontakt_Email;
    $tel = $projekt_Kontaktperson[0]->Kontakt_Telefonnummer;
    $name = $projekt_Kontaktperson[0]->Kontaktperson;

    $bot->reply('Die Kontaktperson im Projekt ' .$projekt. ' ist ' . $name . '<br><br>'.
                'E-Mail: ' . $mail . '<br>Telefon: ' . $tel);
    }
//###############################################################
//Smalltalk
//###############################################################
  public function smalltalk_Danke($bot){
    $bot->reply('Kein Problem ich helfe dir doch gerne!');
  }
}
