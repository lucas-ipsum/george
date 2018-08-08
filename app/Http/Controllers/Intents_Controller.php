<?php

namespace App\Http\Controllers;
use App\veranstaltung;
use App\mitarbeiter;
use App\betreuung;
use App\termine;
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


class Intents_Controller extends Controller
{
//###############################################################
//Intent: 6 - credit_Anzahl
  public function credit_Anzahl($bot){
    $extras = $bot->getMessage()->getExtras();
    $veranstaltung = $extras['apiParameters']['Veranstaltung'];
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
//Intent: 6 - credit_Anzahl_withContext
public function credit_Anzahl_withContext($bot){
    $extras = $bot->getMessage()->getExtras();
    $veranstaltung = $extras['apiContext']['Veranstaltung'];
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
//Intent: 4 - ort_Veranstaltung_withContext
public function ort_Veranstaltung_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung']; //Sucht nach Veranstaltung in Paramtern von Dialogflow und speichert sie in Variable
  $veranstaltungsart = $extras['apiContext']['Veranstaltungsart'];
//Prompts
  if(strlen($veranstaltung) === 0){
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
  }
  elseif(strlen($veranstaltungsart) === 0){
    $bot->reply('Möchten Sie diese Information zur Vorlesung, Übung oder dem Tutorium?');
  }
//Antworten auf Frage
  else{
    $raum = DBController::getDBRaum($veranstaltung, $veranstaltungsart);
    $bot->reply($veranstaltung.' '.'('.$veranstaltungsart.') ist im Raum '.$raum.'.');
  }
}
//###############################################################
//Intent: 3 - veranstaltung_Termin
public function termin_Veranstaltung($bot){
  //Aufruf der Extras der Dialogflow Middleware. Hier auf Elemente des JSONs von Dialogflow zugegriffen werden
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung']; //Sucht nach Veranstaltung in Paramtern von Dialogflow und speichert sie in Variable
  $veranstaltungsart = $extras['apiParameters']['Veranstaltungsart'];
//Prompts
//Hier wird geprüft, ob alle nötigen Informationen vorhanden sind und ob sie aus dem Context aufgegriffen werden können
if(strlen($veranstaltung) ===  0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
  $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
}
elseif(strlen($veranstaltungsart) ===  0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
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
//Intent: 3 - veranstaltung_Termin_withContext
public function termin_Veranstaltung_withContext($bot){
  //Aufruf der Extras der Dialogflow Middleware. Hier auf Elemente des JSONs von Dialogflow zugegriffen werden
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung']; //Sucht nach Veranstaltung in Paramtern von Dialogflow und speichert sie in Variable
  $veranstaltungsart = $extras['apiContext']['Veranstaltungsart'];
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

  if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
$bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
}
else {
      $klausurtermin = DBController::getDBKlausurtermin($veranstaltung);
      $bot->reply('Die Klausur in ' . $veranstaltung . ' ist am '.$klausurtermin.'.'); //Dieser Fall wird aufgerufen, wenn die Veranstaltung aus dem Context geholt wird
}
}
//###############################################################
// Intent: 5 - termin_Klausur_withContext
public function termin_Klausur_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];

  if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
$bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
}
else {
      $klausurtermin = DBController::getDBKlausurtermin($veranstaltung);
      $bot->reply('Die Klausur in ' . $veranstaltung . ' ist am '.$klausurtermin.'.'); //Dieser Fall wird aufgerufen, wenn die Veranstaltung aus dem Context geholt wird
}
}
//###############################################################
//Intent: 9 - beschreibung_Veranstaltung
public function beschreibung_Veranstaltung($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung'];
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
//Intent: 9 - beschreibung_Veranstaltung_withContext
public function beschreibung_Veranstaltung_withContext($bot){
    $extras = $bot->getMessage()->getExtras();
    $veranstaltung = $extras['apiContext']['Veranstaltung'];
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
  $bot->reply('Welchen Mitarbeiter möchten Sie kontaktieren?');
  }
  elseif(strlen($kontaktart) === 0) {    //Nachfrage Kontaktart falls diese nicht eingegeben wurde
          $bot->reply('Wie möchten Sie ' . $mitarbeiter . ' kontaktieren?');
  }
  else {
        $Contact = DBController::getDBKontaktart($kontaktart, $mitarbeiter);
        $bot->reply('Die ' . $kontaktart . ' von ' . $mitarbeiter . ' lautet: '. $Contact.'.');
        }

  }

//###############################################################
//Intent: 13 - ansprechpartner_Veranstaltung
public function ansprechpartner_Veranstaltung($bot){
$extras = $bot->getMessage()->getExtras();
$veranstaltung = $extras['apiParameters']['Veranstaltung'];
//Prompts
if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
$bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
}
else {
$mitarbeiter = DBController::getDBansprechpartner($veranstaltung);

$marke = 'Betreuer';
//$mitarbeiter = $mitarbeiter->Betreuer;
$mitarbeiter = (string) $mitarbeiter->$marke;
$bot->reply('Ansprechpartner für ' . $veranstaltung . ' ist ' . $mitarbieter);
}

}
//###############################################################
//Intent: 13 - ansprechpartner_Veranstaltung_withContext
public function ansprechpartner_Veranstaltung_withContext($bot){
$extras = $bot->getMessage()->getExtras();
$veranstaltung = $extras['apiContext']['Veranstaltung'];
//Prompts
if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
$bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
}
else {
$mitarbeiter = DBController::getDBansprechpartner($veranstaltung);
$bot->reply('Ansprechpartner für ' . $veranstaltung . ' ist '.$mitarbeiter);
}
}

//###############################################################
//Intent: 10 - Anmelderegeln
public function anmeldehilfe_Veranstaltung($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung'];
//Prompts + Antworten
  if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
  }
  else {
        $anmeldung = DBController::getDBAnmeldung($veranstaltung);
        $bot->reply('Die Anmelderegeln für '.$veranstaltung.' sind:  '.$anmeldung.'.');
        }
}
//###############################################################
//Intent: 10 - anmeldehilfe_Veranstaltung_withContext
public function anmeldehilfe_Veranstaltung_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];
//Prompts + Antworten
  if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
  }
  else {
        $anmeldung = DBController::getDBAnmeldung($veranstaltung);
        $bot->reply('Die Anmelderegeln für '.$veranstaltung.' sind:  '.$anmeldung.'.');
  }
}
//###############################################################
//Intent: 11 - vorkenntnisse_Veranstaltung
public function vorkenntnisse_Veranstaltung($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung'];
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
//Intent: 11 - vorkenntnisse_Veranstaltung_withContext
public function vorkenntnisse_Veranstaltung_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];
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
//Intent: 8 - vorleistung_Klausur_withContext
public function vorleistung_Klausur_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];
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
//Intent 14 - turnus_Veranstaltung_withContext
public function turnus_Veranstaltung_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];
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
//Prompts
  if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
  }
  else {
    $literatur = DBController::getDBLiteratur($veranstaltung);
    $bot->reply('Literatur der Veranstaltung ' . $veranstaltung . ' ist: '.$literatur.'.');
  }
}
//###############################################################
//Intent 15 - literatur_Veranstaltung_withContext
public function literatur_Veranstaltung_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];
//Prompts
  if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
  }
  else {
    $literatur = DBController::getDBLiteratur($veranstaltung);
    $bot->reply('Literatur der Veranstaltung ' . $veranstaltung . ' ist: '.$literatur.'.');
  }
}
//###############################################################
//Intent 16 - klausur_Anmeldung
public function klausur_Anmeldung($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiParameters']['Veranstaltung'];
//Prompts
  if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welche Veranstaltung möchten Sie diese Information?');
  }
  else {
    $bot->reply('Klausuranmeldung in ' . $veranstaltung . ': https://flexnow2.uni-goettingen.de/FN2AUTH/login.jsp');
  }
}
//###############################################################
//Intent 16 - klausur_Anmeldung_withContext
public function klausur_Anmeldung_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];
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
//Intent 17 - gesamtueberblick_Veranstaltung_withContext
public function gesamtueberblick_Veranstaltung_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $veranstaltung = $extras['apiContext']['Veranstaltung'];
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
//Prompts
  if(strlen($mitarbeiter) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welchen Mitarbeiter möchten Sie diese Information?');
  }
  else {
    $betreuer = DBController::getDBBetreuung($mitarbeiter);
  //  $string = array(1,2,3,4,5);
    $string1 = implode('|',$betreuer);
    $bot->reply('Liste Veranstaltungen von ' . $mitarbeiter . ': ' . $string1);
  }
}
//###############################################################
//Intent 18 - veranstaltungen_Mitarbeiter_withContext
public function veranstaltungen_Mitarbeiter_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $mitarbeiter = $extras['apiContext']['Mitarbeiter'];
//Prompts
  if(strlen($mitarbeiter) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welchen Mitarbeiter möchten Sie diese Information?');
  }
  else {
    $bot->reply('Liste Veranstaltungen von ' . $mitarbeiter . ': ');
  }
}
//###############################################################
//Intent 19 - abschlussarbeiten_Mitarbeiter
public function abschlussarbeiten_Mitarbeiter($bot){
  $extras = $bot->getMessage()->getExtras();
  $mitarbeiter = $extras['apiParameters']['Mitarbeiter'];
//Prompts
  if(strlen($mitarbeiter) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welchen Mitarbeiter möchten Sie diese Information?');
  }
  else {
    $bot->reply('Abschlussarbeiten von ' . $mitarbeiter . ': ');
  }
}
//###############################################################
//Intent 19 - abschlussarbeiten_Mitarbeiter_withContext
public function abschlussarbeiten_Mitarbeiter_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $mitarbeiter = $extras['apiContext']['Mitarbeiter'];
//Prompts
  if(strlen($mitarbeiter) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
    $bot->reply('Für welchen Mitarbeiter möchten Sie diese Information?');
  }
  else {
    $bot->reply('Abschlussarbeiten von ' . $mitarbeiter . ': ');
  }
}
//###############################################################
//Intent 20 - projekte_Lehrstuhl
  public function projekte_Lehrstuhl($bot){
    $projekte = DBController::getDBProjekte($veranstaltung);
    $bot->reply($projekte);
  }
  //###############################################################
  //Intent 21 - projekte_Lehrstuhl
  public function test_Intent($bot){
    $message = OutgoingMessage::create('Test')->withAttachment(new Image('https://www.uni-goettingen.de/admin/bilder/pictures/87cabed5f37058b113e853e0d5086486.jpg'));
	   $bot->reply($message);
   }
//###############################################################
//Intent 22 - termin_Seminar
  public function termin_Seminar($bot){
    $extras = $bot->getMessage()->getExtras();
    $seminar = $extras['apiParameters']['Seminar'];
    $seminar_Veranstaltung = $extras['apiParameters']['Seminar_Veranstaltungen'];
  //Prompts
    if(strlen($seminar) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
      $bot->reply('Für welches Seminar möchtest du diese Information?');
    }
    elseif(strlen($seminar_Veranstaltung) === 0){
      $bot->reply('Pflicht-Blockkurs , Abgabe der Seminararbeit, Abgabe der Präsentation, Präsentation');
    }
    else {
      $uhrzeit_Seminar = DBController::getDBUhrzeitSeminar($seminar, $seminar_Veranstaltung);
      $datum_Seminar = DBController::getDBDatumSeminar($seminar, $seminar_Veranstaltung);
      $bot->reply($seminar.' '.'('.$seminar_Veranstaltung.') findet '.$datum_Seminar.' um '.$uhrzeit_Seminar.' statt');
    }
  }
//###############################################################
//Intent 22 - termin_Seminar_withContext
    public function termin_Seminar_withContext($bot){
      $extras = $bot->getMessage()->getExtras();
      $seminar = $extras['apiContext']['Seminar'];
      $seminar_Veranstaltung = $extras['apiContext']['Seminar_Veranstaltungen'];
    //Prompts
      if(strlen($seminar) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
        $bot->reply('Für welches Seminar möchtest du diese Information?');
      }
      elseif(strlen($seminar_Veranstaltung) === 0){
        $bot->reply('Pflicht-Blockkurs , Abgabe der Seminararbeit, Abgabe der Präsentation, Präsentation');
      }
      else {
        $uhrzeit_Seminar = DBController::getDBUhrzeitSeminar($seminar, $seminar_Veranstaltung);
        $datum_Seminar = DBController::getDBDatumSeminar($seminar, $seminar_Veranstaltung);
        $bot->reply($seminar.' '.'('.$seminar_Veranstaltung.') findet '.$datum_Seminar.' um '.$uhrzeit_Seminar.' statt');
      }
    }
  //###############################################################
  //Intent 23 - ort_Seminar
    public function ort_Seminar($bot){
      $extras = $bot->getMessage()->getExtras();
      $seminar = $extras['apiParameters']['Seminar'];
      $seminar_Veranstaltung = $extras['apiParameters']['Seminar_Veranstaltungen'];
    //Prompts
      if(strlen($seminar) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
        $bot->reply('Für welches Seminar möchtest du diese Information?');
      }
      elseif(strlen($seminar_Veranstaltung) === 0){
        $bot->reply('Für welche der Veranstaltungen möchtest du dies Information? Pflicht-Blockkurs, Abgabe der Seminararbeit, Abgabe der Präsentation oder Präsentation');
      }
      else {
        $raum_Seminar = DBController::getDBRaumSeminar($seminar, $seminar_Veranstaltung);
        $bot->reply($seminar . ' (' . $seminar_Veranstaltung . ') ist im Raum ' .  $raum_Seminar . '.');
      }
    }

//###############################################################
//Intent 23 - ort_Seminar_withContext
  public function ort_Seminar_withContext($bot){
    $extras = $bot->getMessage()->getExtras();
    $seminar = $extras['apiContext']['Seminar'];
    $seminar_Veranstaltung = $extras['apiContext']['Seminar_Veranstaltungen'];
      //Prompts
        if(strlen($seminar) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
          $bot->reply('Für welches Seminar möchtest du diese Information?');
        }
        elseif(strlen($seminar_Veranstaltung) === 0){
          $bot->reply('Für welche der Veranstaltungen möchtest du dies Information? Pflicht-Blockkurs, Abgabe der Seminararbeit, Abgabe der Präsentation oder Präsentation');
        }
        else {
          $raum_Seminar = DBController::getDBRaumSeminar($seminar, $seminar_Veranstaltung);
          $bot->reply($seminar . ' (' . $seminar_Veranstaltung . ') ist im Raum ' .  $raum_Seminar . '.');
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
        //  $themen_Seminar = DBController::getDBRaumSeminar($seminar, $seminar_Veranstaltung);
          $bot->reply('Folgende Themen werden im '.$seminar . ' angeboten: <br><br>'.
                'Betreuer: J.Anke: <br> Thema: <br>
                1. Literaturbasierte Systematisierung von E-Learning Werkzeugen sowie deren Eignung für den Einsatz zum Aufbau von Kompetenzen <br>
                2. Einsatzgebiete von IT-gestützten Kompetenzmessungswerkzeugen in der Aus- und Weiterbildung <br>
                3. State of the Art von E-Learning für die Bildung für eine nachhaltige Entwicklung <br><br>
                Betreuer: J.Busse <br> Thema: <br>
                4. Potentiale und Grenzen des Einsatzes von Micro Learning in der technisch-gewerblichen Berufsausbildung <br>
                5. Möglichkeiten zum Einsatz von User-Generated Content im Bereich von Micro Learning <br>
                6. Trends und Herausforderungen von Micro Training in der betrieblichen Weiterbildung '
                );
        }
      }

//###############################################################
//Intent 25 - themen_Seminar_nachMitarbeiter
          public function themen_Seminar_nachMitarbeiter($bot){
            $extras = $bot->getMessage()->getExtras();
            $seminar = $extras['apiParameters']['Seminar'];
            $mitarbeiter= $extras['apiParameters']['Mitarbeiter'];
            //Prompts
              if(strlen($seminar) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
                $bot->reply('Für welches Seminar möchtest du diese Information?');
              }
              elseif(strlen($mitarbeiter) === 0){
                $bot->reply('Für welchen Mitarbeiter möchtest du diese Information?');
              }
              else {
              //  $themen_Seminar = DBController::getDBRaumSeminar($seminar, $seminar_Veranstaltung);
                $bot->reply('Folgende Themen werden im '.$seminar . ' angeboten: <br><br>'.
                      'Betreuer: J.Anke: <br> Thema: <br>
                      1. Literaturbasierte Systematisierung von E-Learning Werkzeugen sowie deren Eignung für den Einsatz zum Aufbau von Kompetenzen <br>
                      2. Einsatzgebiete von IT-gestützten Kompetenzmessungswerkzeugen in der Aus- und Weiterbildung <br>
                      3. State of the Art von E-Learning für die Bildung für eine nachhaltige Entwicklung ');
              }
            }


//###############################################################
//Intent 26 - themen_Seminar_nachMitarbeiter_withContext
    public function themen_Seminar_nachMitarbeiter_withContext($bot){
      $extras = $bot->getMessage()->getExtras();
      $seminar = $extras['apiParameters']['Seminar'];
      $mitarbeiter= $extras['apiParameters']['Mitarbeiter'];
                        //Prompts
        if(strlen($seminar) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
            $bot->reply('Für welches Seminar möchtest du diese Information?');
       }
       elseif(strlen($mitarbeiter) === 0){
            $bot->reply('Für welchen Mitarbeiter möchtest du diese Information?');
       }
      else {
                          //  $themen_Seminar = DBController::getDBRaumSeminar($seminar, $seminar_Veranstaltung);
        $bot->reply('Folgende Themen werden im '.$seminar . ' angeboten: <br><br>'.
                    'Betreuer: Pascal Freier <br> Thema: <br>
                    7. Rahmenbedingungen des Einsatzes von Entscheidungsunterstützungssystemen in der Ablaufplanung im Kontext von Cyber-physichen Systemen <br>
                    8. Einsatzgebiete von Entscheidungsunterstützungssystemen in der Ablaufplanung im Kontext von cyberphysischen Systemen');
      }
    }

//###############################################################
//Smalltalk
//###############################################################
  public function smalltalk_Danke($bot){
    $bot->reply('Kein Problem ich helfe dir doch gerne!');
    $this->conversation($bot);
  }
  public function conversation($bot) {
    $bot->startConversation(new App\Http\Conversations\Fallback);
  }

}
