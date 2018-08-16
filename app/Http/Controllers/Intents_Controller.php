<?php

namespace App\Http\Controllers;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Http\Controllers\Conversations;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DBController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use BotMan\BotMan\Storages\Storage;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Attachments\Image;
use Carbon\Carbon;


class Intents_Controller extends Controller
{
//###############################################################
//Intent: 1 - sprechzeit_Mitarbeiter
  public function sprechzeit_Mitarbeiter($bot){
    $extras = $bot->getMessage()->getExtras();
    $mitarbeiter = $extras['apiParameters']['Mitarbeiter'];
    $this->sprechzeit_Mitarbeiter_Logik($bot, $mitarbeiter);
  }
  public function sprechzeit_Mitarbeiter_withContext($bot){
    $extras = $bot->getMessage()->getExtras();
    $mitarbeiter = $extras['apiContext']['Mitarbeiter'];
    $this->sprechzeit_Mitarbeiter_Logik($bot, $mitarbeiter);
  }
  public function sprechzeit_Mitarbeiter_Logik($bot, $mitarbeiter){
   //Prompts
    if(strlen($mitarbeiter) === 0) {       //Dieser Fall wird aufgerufen, wenn kein Mitarbeiter eingegeben wurde
    $bot->reply('Welchen Mitarbeiter möchtest du kontaktieren?');
    }
    else{
      $sprechstunde = DBController::getDB_sprechstunde($mitarbeiter);
      $bot->reply('Sprechstunde ' . $mitarbeiter . ': <br>' . $sprechstunde);
    }
  }
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
    $bot->reply('Für welche Veranstaltung möchtest du diese Information?');
    }
    else {
    $credits = DBController::getDBCredits($veranstaltung);
    $bot->reply('Die Veranstaltung ' . $veranstaltung . ' bringt '.$credits.' Credits');         //Dieser Fall wird aufgerufen, wenn die Veranstaltung in der Anfrage mit eingegeben wurde
    }
  }
//###############################################################
//Veranstaltung Termin ohne Datum
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
      $bot->reply('Für welche Veranstaltung möchtest du diese Information?');
    }
    elseif(strlen($veranstaltungsart) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
      $bot->reply('Möchtest du diese Information zur Vorlesung, Übung oder dem Tutorium?');
    }
    else{
      //Antowort
      // Rufe den Datenbankcontroller für die Abfrage auf
      $termine = DBController::getDBTermin($veranstaltung, $veranstaltungsart);
      $wochentag=$termine[0]->Wochentag;
      $uhrzeit=$termine[0]->Uhrzeit;
      $raum=$termine[0]->Raum;
      $bot->reply($veranstaltung.' ('.$veranstaltungsart.') findet am '.$wochentag.' von '.$uhrzeit.' im Raum: '.$raum.' statt');

    }
  }

  //###############################################################
  //Veranstaltung Termin nächstes Datum
  //###############################################################
  //Intent: 30 - naechster_Termin_Veranstaltung
  public function naechster_Termin_Veranstaltung($bot){
    //Aufruf der Extras der Dialogflow Middleware. Hier auf Elemente des JSONs von Dialogflow zugegriffen werden
    $extras = $bot->getMessage()->getExtras();
    $veranstaltung = $extras['apiParameters']['Veranstaltung']; //Sucht nach Veranstaltung in Paramtern von Dialogflow und speichert sie in Variable
    $veranstaltungsart = $extras['apiParameters']['Veranstaltungsart'];
    $this->naechster_termin_Veranstaltung_Logik($bot, $veranstaltung, $veranstaltungsart);
  }
  public function naechster_termin_Veranstaltung_withContext($bot){
    //Aufruf der Extras der Dialogflow Middleware. Hier auf Elemente des JSONs von Dialogflow zugegriffen werden
    $extras = $bot->getMessage()->getExtras();
    $veranstaltung = $extras['apiContext']['Veranstaltung']; //Sucht nach Veranstaltung in Paramtern von Dialogflow und speichert sie in Variable
    $veranstaltungsart = $extras['apiContext']['Veranstaltungsart'];
    $this->naechster_termin_Veranstaltung_Logik($bot, $veranstaltung, $veranstaltungsart);
  }

  public function naechster_termin_Veranstaltung_Logik($bot, $veranstaltung, $veranstaltungsart){
//Prompts
//Hier wird geprüft, ob alle nötigen Informationen vorhanden sind und ob sie aus dem Context aufgegriffen werden können
    $datum_heute = Carbon::now()->format('Y-m-d');

    if(strlen($veranstaltung) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
      $bot->reply('Für welche Veranstaltung möchtest du diese Information?');
    }
    elseif(strlen($veranstaltungsart) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
      $bot->reply('Möchtest du diese Information zur Vorlesung, Übung, oder dem Tutorium?');
    }

    else{

      //Antowort
      // Rufe den Datenbankcontroller für die Abfrage auf
      $termine = DBController::getDB_naechster_Termin_Veranstaltung($veranstaltung, $veranstaltungsart, $datum_heute);
      $wochentag=$termine[0]->Wochentag;
      $uhrzeit=$termine[0]->Uhrzeit;
      $raum=$termine[0]->Raum;
      $datum=$termine[0]->Datum;

    //  $art_der_Veranstaltung = DBController::getDBArtderVeranstaltung($veranstaltung,$veranstaltungsart,$datum);

      $datum = Carbon::parse($datum)->format('d.m.y');

      $bot->reply('Der nächste Termin in '. $veranstaltung.' ('. $veranstaltungsart .') findet am '. $datum .' ('.$wochentag.')'.' von '.$uhrzeit.' im Raum: '.$raum.' statt');

      }

  }

  //###############################################################
  // Intent: 4 - studienplan_WiInf
  public function studienplan_WiInf($bot){
    $message = OutgoingMessage::create('Hier ist der Studienaufbau vom Bachelor Wirtschaftsinformatik <br>(<a href="https://www.uni-goettingen.de/de/bachelor-studiengang+in+wirtschaftsinformatik/23246.html" target="_blank">Weitere Informationen</a>)')->withAttachment(Image::url('https://www.uni-goettingen.de/admin/bilder/pictures/87cabed5f37058b113e853e0d5086486.jpg'));  //URL Mitarbeiter Foto wird eingefügt
	   $bot->reply($message);
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
    $bot->reply('Für welche Veranstaltung möchtest du diese Information?');
  }
  else {
      $klausurtermin = DBController::getDBKlausurtermin($veranstaltung);
      $ausgabe_klausuren='';
      for($index=0; $index < count($klausurtermin); $index++)
      {
        $datum = $klausurtermin[$index]->Datum;
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
      $bot->reply('Für welche Veranstaltung möchtest du diese Information?');
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
  $this->mitarbeiter_Kontakt_Logik($bot, $mitarbeiter, $kontaktart);
}
public function mitarbeiter_Kontakt_withContext($bot){
  $extras = $bot->getMessage()->getExtras();
  $mitarbeiter = $extras['apiContext']['Mitarbeiter'];
  $kontaktart = $extras['apiParameters']['Kontaktart'];
  $this->mitarbeiter_Kontakt_Logik($bot, $mitarbeiter, $kontaktart);
}
  public function mitarbeiter_Kontakt_Logik($bot, $mitarbeiter, $kontaktart){
  //Prompts
  if(strlen($mitarbeiter) === 0) {       //Dieser Fall wird aufgerufen, wenn kein Mitarbeiter eingegeben wurde
  $bot->reply('Welchen Mitarbeiter möchtest du kontaktieren?');
  }
  elseif(strlen($kontaktart) === 0) {    //Nachfrage Kontaktart falls diese nicht eingegeben wurde
          $bot->reply('Wie möchtest du ' . $mitarbeiter . ' kontaktieren?');
  }
  elseif($kontaktart === 'E-Mail') {
          $Contact = DBController::getDBKontaktart($kontaktart, $mitarbeiter);
          $bot->reply('Die ' . $kontaktart . ' von ' . $mitarbeiter . ' lautet: <a href="mailto:'.$Contact.'" target="_top">'.$Contact.'</a> ');
  }
  elseif($kontaktart === 'Telefonnummer') {
          $Contact = DBController::getDBKontaktart($kontaktart, $mitarbeiter);
          $bot->reply('Die ' . $kontaktart . ' von ' . $mitarbeiter . ' lautet: <a href="tel:'.$Contact.'">'.$Contact.'</a> '); //Bei mobilen Geräten kann direkt angerufen werden
  }
  //Falls Anfragen nicht richtig verstanden werden kein link
  else {
        $Contact = DBController::getDBKontaktart($kontaktart, $mitarbeiter);
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
     $bot->reply('Für welche Veranstaltung möchtest du diese Information?');
   }
   else {
     $mitarbeiter = DBController::getDBansprechpartner($veranstaltung);
     $ausgabe = '';
     $verantwortlicher = $mitarbeiter[0]->Verantwortlicher;
   for($index=0; $index < count($mitarbeiter); $index++){
     $betreuer = $mitarbeiter[$index]->Betreuer;
     $ausgabe .= $betreuer . '<br> ';
   }
    $bot->reply('Ansprechpartner für ' . $veranstaltung . ': <br>' . $ausgabe . '<br> Verantwortlich: <br>' . $verantwortlicher);
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
      $bot->reply('Für welche Veranstaltung möchtest du diese Information?');
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
    $bot->reply('Für welche Veranstaltung möchtest du diese Information?');
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
    $bot->reply('Für welche Veranstaltung möchtest du diese Information?');
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
    $bot->reply('Für welche Veranstaltung möchtest du diese Information?');
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
        $bot->reply('Für welche Veranstaltung möchtest du diese Information?');
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
    $bot->reply('Für welche Veranstaltung möchtest du diese Information?');
  }
  else {
    $bot->reply('Klausuranmeldung in  ' . $veranstaltung . ':  <a href="https://flexnow2.uni-goettingen.de/FN2AUTH/login.jsp" target="_blank">FlexNow-Anmeldung</a>');
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
    $bot->reply('Für welche Veranstaltung möchtest du diese Information?');
  }
  else {
    $ueberblick = DBController::getDBUeberblick($veranstaltung);
    $hyperlink = $ueberblick[0]->Hyperlink;
    $univz = $ueberblick[0]->UniVZ_Link;
    $bot->reply('Mehr Informationen zu der Veranstaltung ' . $veranstaltung . ' ist auf der <a href="' .$hyperlink. '" target="_blank">Website der Professur</a> und im <a href="'.$univz.'" target="_blank">UniVZ</a> verfügbar');
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
    $bot->reply('Für welchen Mitarbeiter möchtest du diese Information?');
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
//Intent 19 - themen_Abschlussarbeit
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
      $bot->reply('Für welchen Mitarbeiter möchtest du diese Information?');
    }
    else{
      $themen_Abschlussarbeit = DBController::getDB_themen_Abschlussarbeit($mitarbeiter);
      $ausgabe_themen_Abschlussarbeit = '';
        for($index=0; $index < count($themen_Abschlussarbeit); $index++){
            $thema_Abschlussarbeit = $themen_Abschlussarbeit[0]->Thema;
            $ausgabe_themen_Abschlussarbeit .= $index+1 . '. ' . $thema_Abschlussarbeit . '<br>';
        }
      $bot->reply('Themen der Abschlussarbeiten betreut von ' . $mitarbeiter . ': <br>' . $ausgabe_themen_Abschlussarbeit);
    }
  }
  //###############################################################
  //Intent 21 - foto_Mitarbeiter
  public function foto_Mitarbeiter($bot){
    $extras = $bot->getMessage()->getExtras();
    $mitarbeiter = $extras['apiParameters']['Mitarbeiter'];
    $this->foto_Mitarbeiter_Logik($bot, $mitarbeiter);
  }
  public function foto_Mitarbeiter_withContext($bot){
    $extras = $bot->getMessage()->getExtras();
    $mitarbeiter = $extras['apiContext']['Mitarbeiter'];
    $this->foto_Mitarbeiter_Logik($bot, $mitarbeiter);
  }
  public function foto_Mitarbeiter_Logik($bot, $mitarbeiter){
//Prompts
    if(strlen($mitarbeiter) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
      $bot->reply('Für welchen Mitarbeiter möchtest du diese Information?');
    }
    else{
    $url_Foto = DBController::getDB_fotoMitarbeiter($mitarbeiter);

    $message = OutgoingMessage::create('Hier ist ein Foto von '. $mitarbeiter)->withAttachment(Image::url(''.$url_Foto .''));  //URL Mitarbeiter Foto wird eingefügt
	   $bot->reply($message);
   }
  }
//###############################################################
//Intent 29 - bueroraum
  public function bueroraum($bot){
    $extras = $bot->getMessage()->getExtras();
    $mitarbeiter = $extras['apiParameters']['Mitarbeiter'];
    $this->bueroraum_Logik($bot, $mitarbeiter);
  }
  public function bueroraum_withContext($bot){
    $extras = $bot->getMessage()->getExtras();
    $mitarbeiter = $extras['apiContext']['Mitarbeiter'];
    $this->bueroraum_Logik($bot, $mitarbeiter);
  }
  public function bueroraum_Logik($bot, $mitarbeiter){
  //Prompts
    if(strlen($mitarbeiter) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
      $bot->reply('Für welchen Mitarbeiter möchtest du diese Information?');
    }
    else{
      $bueroraum = DBController::getDB_bueroraum($mitarbeiter);

      $bot->reply('Das Büro von ' . $mitarbeiter . ' ist im Raum ' . $bueroraum);
    }
  }
//###############################################################
//Intent 7 - naechster_Termin_Seminar
  public function naechster_Termin_Seminar($bot){
    $extras = $bot->getMessage()->getExtras();
    $seminar = $extras['apiParameters']['Seminar'];
    $this->naechster_Termin_Seminar_Logik($bot, $seminar);
  }
  public function naechster_Termin_Seminar_withContext($bot){
    $extras = $bot->getMessage()->getExtras();
    $seminar = $extras['apiContext']['Seminar'];
    $this->naechster_Termin_Seminar_Logik($bot, $seminar);
  }
  public function naechster_Termin_Seminar_Logik($bot, $seminar){
//Datum heute
    $datum_heute = Carbon::now()->format('Y-m-d');            //Carbon holt das aktuelle Datum und bringt es In Format mit dem die DB auch arbeitet
//Prompts
    if(strlen($seminar) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
      $bot->reply('Für welches Seminar möchtest du diese Information?');
    }
    else{
      $naechster_termin = DBController::getDB_naechster_Termin_seminar($seminar, $datum_heute);
      $naechster_termin = $naechster_termin[0]->Datum;
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
          $datum_Seminar = $termine_Seminar[$index]->Datum;
          $datum_Seminar = Carbon::parse($datum_Seminar)->format('d.m.y');
          $uhrzeit_Seminar = $termine_Seminar[$index]->Uhrzeit;
          $ausgabe_termin_Seminar .= $datum_Seminar . ' von ' . $uhrzeit_Seminar . '<br>';
      }
        $ort_Seminar = $termine_Seminar[0]->Raum;
      $bot->reply('Termin: ' . $seminar.' '.'('.$seminar_Veranstaltung.'): <br>'. $ausgabe_termin_Seminar .'<br>Raum: ' . $ort_Seminar);
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
//Intent 26 - terminuebersicht_Seminar
  public function terminuebersicht_Seminar($bot){
    $extras = $bot->getMessage()->getExtras();
    $seminar = $extras['apiParameters']['Seminar'];
    $this->terminuebersicht_Seminar_Logik($bot, $seminar);
  }
  public function terminuebersicht_Seminar_withContext($bot){
    $extras = $bot->getMessage()->getExtras();
    $seminar = $extras['apiContext']['Seminar'];
    $this->terminuebersicht_Seminar_Logik($bot, $seminar);
  }
  public function terminuebersicht_Seminar_Logik($bot, $seminar){
        //Prompts
          if(strlen($seminar) === 0) {       //Dieser Fall wird aufgerufen, wenn die Veranstaltung nicht eingegeben wurde
            $bot->reply('Für welches Seminar möchtest du diese Information?');
          }
          else {
            $termine_Seminar = DBController::getDB_Termine_Seminar($seminar);
              $ausgabe_termine_Seminar = '';
            for($index = 0; $index < count($termine_Seminar); $index++){
              $datum = $termine_Seminar[$index]->Datum;
              $datum = Carbon::parse($datum)->format('d.m.y');                // Formatiert Datum von DB Format um
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
    $this->beschreibung_Projekt_Logik($bot, $projekt);
  }
  public function beschreibung_Projekt_withContext($bot){
    $extras = $bot->getMessage()->getExtras();
    $projekt = $extras['apiContext']['Projekt'];
    $this->beschreibung_Projekt_Logik($bot, $projekt);
  }
  public function beschreibung_Projekt_Logik($bot, $projekt){
  //Prompts
    if(strlen($projekt) === 0) {
      $bot->reply('Zu welchem Projekt möchtest du weitere Informationen haben?');
    }
    $projekt_Beschreibung = DBController::getDBprojektBeschreibung($projekt);
    $bot->reply($projekt_Beschreibung);
  }

//###############################################################
//Intent 28 - kontaktperson_Projekt
  public function kontaktperson_Projekt($bot){
    $extras = $bot->getMessage()->getExtras();
    $projekt = $extras['apiParameters']['Projekt'];
    $this->kontaktperson_Projekt_Logik($bot, $projekt);
  }
  public function kontaktperson_Projekt_withContext($bot){
    $extras = $bot->getMessage()->getExtras();
    $projekt = $extras['apiContext']['Projekt'];
    $this->kontaktperson_Projekt_Logik($bot, $projekt);
  }
  public function kontaktperson_Projekt_Logik($bot, $projekt){
  //Prompts
    if(strlen($projekt) === 0) {
      $bot->reply('Zu welchem Projekt möchtest du einen Mitarbeiter kontaktieren?');
    }
    else{
    $projekt_Kontaktperson = DBController::getDBprojektKontaktperson($projekt);
    $mail = $projekt_Kontaktperson[0]->Kontakt_Email;
    $tel = $projekt_Kontaktperson[0]->Kontakt_Telefonnummer;
    $name = $projekt_Kontaktperson[0]->Kontaktperson;

    $bot->reply('Die Kontaktperson im Projekt ' .$projekt. ' ist ' . $name . '<br><br>'.
                //'E-Mail: ' . $mail . '<br>Telefon: ' . $tel);
                'E-Mail: <a href="mailto:'.$mail.'" target="_top">'.$mail.'</a> <br>Telefon: <a href="tel:'.$tel.'">'.$tel.'</a>');
      }
    }

  //###############################################################
  //Stellenangebote
  //###############################################################
  //Intent 31 - stellenangebote_Lehrstuhl
    public function stellenangebote_Lehrstuhl($bot){
      $stellenangebote = DBController::getDBStellenangebote();
      $ausgabe_stellenangebote = '';
      for($index=0; $index < count($stellenangebote); $index++){
         $stellenangebot = $stellenangebote[$index]->Stelle;
         $id = $stellenangebote[$index]->ID;
         $ausgabe_stellenangebote .= $id .'. ' .$stellenangebot . '<br><br> ';
       }

      $bot->reply('Folgende Stellen sind momentan am Lehrstuhl ausgeschrieben:<br><br>'
                  .$ausgabe_stellenangebote.
                  'Weitere Informationen zu den jeweiligen Stellen sind unter Angabe von Stelle mit der jeweiligen Nummer ansprechbar (z.B. Beschreibung Stelle 5)');
      //$bot->reply('');
    }
  //Intent 32 - beschreibung_Stellenangebot
    public function stellenangebot_Beschreibung($bot){
      $extras = $bot->getMessage()->getExtras();
      $stelle = $extras['apiParameters']['Stelle'];
      $beschreibung_Stellenangebot = DBController::getDBStellenangebotBeschreibung($stelle);
      $bot->reply($beschreibung_Stellenangebot);
    }
    //Intent 33 - aufgaben_Stelle
      public function aufgaben_Stelle($bot){
        $extras = $bot->getMessage()->getExtras();
        $stelle = $extras['apiParameters']['Stelle'];
        $aufgaben_Stelle = DBController::getDBStellenangebotAufgaben($stelle);
        $bot->reply($aufgaben_Stelle);
      }

    //Intent 34 - bewerbungsinformationen_Stelle
    public function bewerbungsinformationen_Stelle($bot){
      $extras = $bot->getMessage()->getExtras();
      $stelle = $extras['apiParameters']['Stelle'];
      $bewerbungsinformationen = DBController::getDB_Bewerbungsinformationen($stelle);
      $bewerberprofil = $bewerbungsinformationen[0]->Erforderliches_Profil;
      $kontaktperson = $bewerbungsinformationen[0]->Kontaktperson;
      $bewerbungsfrist = $bewerbungsinformationen[0]->Bewerbungsfrist;
      $link = $bewerbungsinformationen[0]->Link;

      $bot->reply($bewerberprofil . '<br><br>' . $kontaktperson . '<br><br>' . $bewerbungsfrist . '<br><br>' . $link);
    }
//###############################################################
//Smalltalk
//###############################################################
  public function smalltalk_Danke($bot){
    $bot->reply('Kein Problem ich helfe dir doch gerne! Hast du noch weitere Fragen?');
  }
  public function smalltalk_Info_Chatbot($bot){
    $bot->reply('Ich bin George ein Chatbot von der Professur für Anwendungssysteme
    und E-Business der Universität Göttingen. Ich bin hier, um deine Fragen zu beantworten.');
  }
  public function smalltalk_Herkunft($bot){
    $bot->reply('Ich bin George und wurde von einem Entwicklerteam der Universität Göttingen,
    bestehend aus Fabian, Maria, Andreas, Michael und Lucas programmiert.');
  }
  public function smalltalk_Chatbot($bot){
    $bot->reply('Ich bin George ein Chatbot. Ich bin also ein automatisches natürlichsprachliches
    Informationssystem zur Beantwortung von Fragen in Echtzeit.');
  }
  public function smalltalk_kannst_du_helfen($bot){
    $bot->reply('Natürlich. Wobei kann ich dir denn helfen?');
  }
  public function smalltalk_beschaeftigt($bot){
    $bot->reply('Zur Beantwortung deiner Fragen habe ich immer einen Moment!');
  }
  public function smalltalk_langweilig($bot){
    $bot->reply('Das tut mir leid. Falls du mit meiner Beantwortung deiner Fragen nicht zufrieden bist,
    gib mir doch bitte ein Feedback.');
  }
  public function smalltalk_Willkommen($bot){
    $bot->reply('Hallo! Wie kann ich dir weiterhelfen?');
  }
}
