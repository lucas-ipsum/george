<?php

namespace App\Http\Controllers;
use App\veranstaltung;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DBController extends Controller
{



    // Funktion um den Raum einer Veranstaltung aus der DB zu holen
    public static function getDBRaum($name, $art)
    {

        $dbraum = veranstaltung::getModelRaum($name, $art);

        return $dbraum;
    }






    // Funktion um die Uhrzeit einer Veranstaltung aus der DB zu holen
    public static function getDBUhrzeit($veranstaltung, $veranstaltungsart)
    {



    $dbuhrzeit = DB::table('veranstaltung')
                        ->where('Name', $veranstaltung)
                        ->where('Art', $veranstaltungsart)
                        ->value('Uhrzeit');

        return $dbuhrzeit;
    }



    // Funktion um das Datum einer Veranstaltung aus der DB zu holen
    public static function getDBDatum($veranstaltung, $veranstaltungsart)
    {

    $dbdatum = DB::table('veranstaltung')
                        ->where('Name', $veranstaltung)
                        ->where('Art', $veranstaltungsart)
                        ->value('Datum');

        return $dbdatum;
    }




}
?>
