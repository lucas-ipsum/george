<?php

namespace App\Http\Controllers;
use App\veranstaltung;
use App\mitarbeiter;
use App\betreuung;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DBController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use BotMan\BotMan\Storages\Storage;
//use BotMan\BotMan\Middleware\Dialogflow;

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
    $bot->reply($veranstaltung . ' (' . $veranstaltungsart . ') ist im Raum ' .  $raum . '.');  //Platzhalter für Raum abfragen, der aus DB geholt wird
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
      $bot->reply($veranstaltung.' '.'('.$veranstaltungsart.') findet am '.$datum.' um '.$uhrzeit.' statt');  //Platzhalter für Raum abfragen, der aus DB geholt wird
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
      $bot->reply($veranstaltung.' '.'('.$veranstaltungsart.') findet am '.$datum.' um '.$uhrzeit.' statt');  //Platzhalter für Raum abfragen, der aus DB geholt wird
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
        $bot->reply('Die Veranstaltung '.$veranstaltung.' beschäftigt sich mit:  '.$beschreibung.'.');
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
          $bot->reply('Die Veranstaltung '.$veranstaltung.' beschäftigt sich mit:  '.$beschreibung.'.');
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
  elseif (strlen($kontaktart) === 0) {    //Nachfrage Kontaktart falls diese nicht eingegeben wurde
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
$bot->reply('Ansprechpartner für ' . $veranstaltung . ' ist Pascal Freier');
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
$bot->reply('Ansprechpartner für ' . $veranstaltung . ' ist Pascal Freier');
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
  //  $vorkenntnisse =
    $bot->reply('Die Vorkenntnisse für '.$veranstaltung.' sind:  vorkenntnisse.');
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
    $bot->reply('Die Vorkenntnisse für '.$veranstaltung.' sind:  vorkenntnisse  mit context.');
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
    $bot->reply('Vorleistung zur Klausur in ' . $veranstaltung . ': Die Übung stellt eine Vorleistung zur Klausur dar. Während des Semesters müssen drei Aufgaben zu den Inhalten Vorlesung bearbeitet werden. Alle Aufgaben müssen bestanden sein, um an der Klausur am Ende des Semesters teilzunehmen.');
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
    $bot->reply('Vorleistung zur Klausur in ' . $veranstaltung . ': Die Übung stellt eine Vorleistung zur Klausur dar. Während des Semesters müssen drei Aufgaben zu den Inhalten Vorlesung bearbeitet werden. Alle Aufgaben müssen bestanden sein, um an der Klausur am Ende des Semesters teilzunehmen.');
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
    $bot->reply('Turnus der Veranstaltung ' . $veranstaltung . ': Turnus');
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
    $bot->reply('Turnus der Veranstaltung ' . $veranstaltung . ': Turnus Context');
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
    $bot->reply('Literatur der Veranstaltung ' . $veranstaltung . ': Literatur');
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
    $bot->reply('Literatur der Veranstaltung ' . $veranstaltung . ': Literatur Context');
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
    $bot->reply('Zusammenfassung Organisatorisches ' . $veranstaltung . ': ');
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
    $bot->reply('Zusammenfassung Organisatorisches ' . $veranstaltung . ':  ');
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
    $bot->reply('Liste Veranstaltungen von ' . $mitarbeiter . ': ');
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
    $bot->reply('Projekte Lehrstuhl');
  }
}
