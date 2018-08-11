<?php

namespace App\Http\Controllers;
use App\veranstaltung;
use App\mitarbeiter;
use App\betreuung;
use App\termine;
use App\projekte;
use App\themen_im_bachelorseminar;
use App\Http\Controllers\Intents_Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DBController extends Controller
{


    public static function getDBVorleistung($art)
    {

          $dbVoraussetzung = veranstaltung::getModelVorleistung($art);

          return $dbVoraussetzung;
    }



    public static function getDBVoraussetzung($art)
    {

          $dbVoraussetzung = veranstaltung::getModelVoraussetzung($art);

          return $dbVoraussetzung;
    }




    public static function getDBUeberblick($art)
    {

        $dbueberblick = veranstaltung::getModelUeberblick($art);

        return $dbueberblick;
    }


    public static function getDBLiteratur($art)
    {

        $dbliteratur = veranstaltung::getModelLiteratur($art);

        return $dbliteratur;
    }


    public static function getDBTurnus($art)
    {

        $dbturnus = veranstaltung::getModelTurnus($art);

        return $dbturnus;
    }


    public static function getDBKontaktart($art, $name)
    {

        $dbcontact = mitarbeiter::getModelKontaktart($art, $name);

        return $dbcontact;
    }


    // Funktion um die Anmeldung einer Veranstaltung aus dem model zu holen
    public static function getDBAnmeldung($name)
    {

        $dbanmeldung = veranstaltung::getModelAnmeldung($name);

        return $dbanmeldung;
    }


    // Funktion um die Beschreibung einer Veranstaltung aus dem model zu holen
    public static function getDBBeschreibung($name)
    {

        $dbbeschreibung = veranstaltung::getModelBeschreibung($name);

        return $dbbeschreibung;
    }


    // Funktion um den Klausurtermin einer Veranstaltung aus dem model zu holen
    public static function getDBKlausurtermin($name)
    {

        $dbklausurtermin = termine::getModel_Klausurtermin($name);

        return $dbklausurtermin;
    }


    // Funktion um die Creditanzahl einer Veranstaltung aus dem model zu holen
    public static function getDBCredits($name)
    {

        $dbcredits = veranstaltung::getModelCredits($name);

        return $dbcredits;
    }

    // Funktion um den Raum einer Veranstaltung aus dem model zu holen
    public static function getDBRaum($name, $art)
    {

        $dbraum = veranstaltung::getModelRaum($name, $art);

        return $dbraum;
    }


    // Funktion um die Uhrzeit einer Veranstaltung aus dem model zu holen
    public static function getDBUhrzeit($name, $art)
    {

        $dbuhrzeit = veranstaltung::getModelUhrzeit($name, $art);

        return $dbuhrzeit;
    }


    // Funktion um das Datum einer Veranstaltung aus der DB zu holen
    public static function getDBDatum($name, $art)
    {

        $dbdatum = veranstaltung::getModelDatum($name, $art);

        return $dbdatum;
    }

    public static function getDBBetreuung($mitarbeiter){

        $dbbetreuung = betreuung::getModelBetreuung($mitarbeiter);

        return $dbbetreuung;
    }

  public static function getDBansprechpartner($name){

    $dbansprechpartner = betreuung::getModelAnsprechpartner($name);

        return $dbansprechpartner;

  }
//#########################################################################################
//Seminare

    // Funktion um die Uhrzeit einer Veranstaltung aus dem model zu holen
    public static function getDBUhrzeitSeminar($name, $art)
    {

        $dbuhrzeit_Seminar = termine::getModelUhrzeitSeminar($name, $art);

        return $dbuhrzeit_Seminar;
    }


    // Funktion um das Datum einer Veranstaltung aus der DB zu holen
    public static function getDB_termin_Seminar($seminar, $seminar_Veranstaltung)
    {
        $db_termin_Seminar = termine::getModel_termin_Seminar($seminar, $seminar_Veranstaltung);

        return $db_termin_Seminar;
    }

    public static function getDBRaumSeminar($seminar, $seminar_Veranstaltung)
    {

        $dbraum_Seminar = termine::getModelRaumSeminar($seminar, $seminar_Veranstaltung);

        return $dbraum_Seminar;
    }

    public static function getDBThemen($veranstaltung)
    {
      $dbthemen_seminar = themen_im_bachelorseminar::getModelThemen($veranstaltung);
       return $dbthemen_seminar;
    }

    public static function getDBThemen_nachMitarbeiter($seminar, $mitarbeiter)
    {
      $dbthemen_seminar_nachMitarbeiter = themen_im_bachelorseminar::getModelThemen_nachMitarbeiter($seminar, $mitarbeiter);
       return $dbthemen_seminar_nachMitarbeiter;
    }
// Überblick Termine Seminar
    public static function getDB_Termine_Seminar($seminar){
      $db_termine_Seminar = termine::getModel_Termine_Seminar($seminar);

        return $db_termine_Seminar;
    }
//naechster_Termin_Seminar
  public static function getDB_naechster_Termin_seminar($seminar, $datum_heute){
    $db_naechster_Termin_Seminar = termine::getModel_naechster_Termin_Seminar($seminar, $datum_heute);

        return $db_naechster_Termin_Seminar;
  }
  //art_Veranstaltung nach Termin
  public static function getDB_art_Veranstaltung_nachTermin($seminar, $termin_veranstaltung){
     $db_Art_nachTermin = termine::getModel_art_Veranstaltung_nachTermin($seminar, $termin_veranstaltung);

     return $db_Art_nachTermin;
  }
    public static function getDB_fotoMitarbeiter($mitarbeiter){

      $db_foto_Mitarbeiter = mitarbeiter::getModel_foto_Mitarbeiter($mitarbeiter);

      return $db_foto_Mitarbeiter;
    }
//#######################################################################################################################
//Projekte
//#######################################################################################################################
  public static function getDBProjekte()
    {
      $dbprojekte = projekte::getModelProjekte();

          return $dbprojekte;
    }

  public static function getDBprojektBeschreibung($projekt){
    $db_projekt_Beschreibung = projekte::getModelProjektBeschreibung($projekt);

      return $db_projekt_Beschreibung;
  }
   public static function getDBprojektKontaktperson($projekt){
     $db_projekt_Kontaktperson = projekte::getModelProjektKontaktperson($projekt);

     return $db_projekt_Kontaktperson;
   }


}
?>
