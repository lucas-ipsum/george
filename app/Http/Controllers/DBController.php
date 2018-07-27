<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DBController extends Controller
{

    // Funktion um den Raum einer Veranstaltung aus der DB zu holen
    public static function getDBRaum($veranstaltung, $veranstaltungsart)
    {

      $dbraum = DB::table('veranstaltung')
                        ->where('Name', $veranstaltung)
                        //->and('name', $veranstaltungsart)
                        ->value('Raumnummer');

        return $dbraum;
    }

    // Funktion um die Uhrzeit einer Veranstaltung aus der DB zu holen
    public static function getDBUhrzeit($veranstaltung, $veranstaltungsart)
    {

    $dbuhrzeit = DB::table('veranstaltung')
                        ->where('Name', $veranstaltung)
                        //->and('name', $veranstaltungsart)
                        ->value('Uhrzeit');

        return $dbuhrzeit;
    }

    // Funktion um das Datum einer Veranstaltung aus der DB zu holen
    public static function getDBDatum($veranstaltung, $veranstaltungsart)
    {

    $dbdatum = DB::table('veranstaltung')
                        ->where('Name', $veranstaltung)
                        //->and('name', $veranstaltungsart)
                        ->value('Datum');

        return $dbdatum;
    }




}
?>
