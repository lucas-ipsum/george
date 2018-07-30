<?php

namespace App\Http\Controllers;
use App\veranstaltung;
use App\mitarbeiter;
use App\betreuung;
use App\Http\Controllers\Intents_Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DBController extends Controller
{

    // Funktion um den Raum einer Veranstaltung aus dem model zu holen
    public static function getDBCredits($name)
    {

        $dbcredits = veranstaltung::getModelCredits($name);

        return $dbcredits;
    }

    // Funktion um den Raum einer Veranstaltung aus dem model zu holen
    public static function getDBRaum($name, $art)
    {
          $dbraum = "wiese"
      //  $dbraum = veranstaltung::getModelRaum($name, $art);

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




}
?>
