<?php

namespace App\Http\Controllers;
use App\veranstaltung;
use App\mitarbeiter;
use App\betreuung;
use App\termine;
use App\Http\Controllers\Intents_Controller;
use App\Http\Conversations\Feedback;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DBController extends Controller
{


    public static function getDBVorleistung($art)
    {

          $dbVoraussetzunge = veranstaltung::getModelVorleistung($art);

          return $dbVoraussetzung;
    }



    public static function getDBVoraussetzung($art)
    {

          $dbVoraussetzunge = veranstaltung::getModelVoraussetzung($art);

          return $dbVoraussetzung;
    }


    public static function getDBProjekte($art)
    {

          $dbprojekte = projekte::getModelProjekte($art);

          return $dbprojekte;
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

        $dbklausurtermin = veranstaltung::getModelKlausurtermin($name);

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

    public static function getAlleMitarbeiter(){

      $dbAlleMitarbeiter = mitarbeiter::getModelAlleMitarbeiter();

      return $dbAlleMitarbeiter;
    }

  /*  public static function getDBBetruung($name)
    {

        $dbbetreuung = betreuung::getModelBetreuung($name);

      /*  $ausgabe = array();

        foreach ($dbbetreuung as $person) {
            $ausgabe[] = $person;

        }

        return $dbbetreuung;
    } */

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
    public static function getDBDatumSeminar($name, $art)
    {

        $dbdatum_Seminar = termine::getModelDatumSeminar($name, $art);

        return $dbdatum_Seminar;
    }

    public static function getDBRaumSeminar($name, $art)
    {

        $dbraum_Seminar = termine::getModelRaumSeminar($name, $art);

        return $dbraum_Seminar;
    }

    //Funktion um Feedback in DB zu speichern
    public static function getModelFeedback($u_id,$antwort,$begründung)
    {
      return $db_deedback = feedback::getModelFeedback($u_id,$antwort,$begründung);
    }


}
?>
