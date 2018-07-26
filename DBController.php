<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DBController extends Controller
{




      public static function getDBBeschreibung($veranstaltung, $veranstaltungsart)
      {
        $dbMusthave = DB::table('veranstaltung')
                      ->where('Name', $veranstaltung)
                      ->where('Art', $veranstaltungsart)
                      ->value('Hyperlink');

          return $dbMusthave;
      }

      public static function getDBrequirement($veranstaltung)
      {
        $dbMusthave = DB::table('veranstaltung')
                      ->where('Name', $veranstaltung)
                      ->where('Art', 'Vorlesung')
                      ->value('Voraussetzung');

          return $dbMusthave;
      }



/*
      // Funktion um den Ansprechpartener einer Veranstaltung aus der DB zu holen
      public static function getDBPerson($veranstaltung)
      {

        // Hole die ID der gefragten Veranstaltung
        $dbID_Veranstaltung = DB::table('veranstaltung')
                          ->where('Name', $veranstaltung)
                          ->where('Art', 'Vorlesung')
                          ->value('ID_Veranstaltung');


        // Hole die Mitarbeiter ID aus Tabelle Betreuung, welcher diese Veranstaltung betreut
        $dbID_Mitarbeiter = DB::table('betreuung')
                          ->where('ID_Veranstaltung', $dbID_Veranstaltung)
                          ->first()
                          ->value('ID_Mitarbeiter');


        // Hole den Namen des ermittelten Mitarbeiters
        $dbPerson =  DB::table('mitarbeiter')
                          ->where('ID_Mitarbeiter', $dbID_Mitarbeiter)
                          //->value('Vorname');
                          ->value('Nachname');

                          $dbPerson = 'Santa claus'

          return $dbPerson;
      } */

############################################################################################################################################################

    // Funktion um Vorleistung aus der DB zu holen
    public static function getDBadvance($veranstaltung)
    {
      $dbadvance = DB::table('veranstaltung')
            ->where('Name', $veranstaltung)
            ->where('Art', 'Vorlesung')
            ->value('Voraussetzung');

      return $dbadvance;
    }

    // Funktion um den Raum einer Veranstaltung aus der DB zu holen
    public static function getDBRaum($veranstaltung, $veranstaltungsart)
    {

      $dbraum = DB::table('veranstaltung')
                        ->where('Name', $veranstaltung)
                        ->where('Art', $veranstaltungsart)
                        ->value('Raumnummer');

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


    // Funktion um das Datum einen Klausurtermin aus der DB zu holen
    public static function getDBklTermin($veranstaltung)
    {
      $dbklTermin = DB::table('veranstaltung')
                    ->where('Name', $veranstaltung)
                    ->where('Art', 'Vorlesung')
                    ->value('Klausurtermin');

        return $dbklTermin;
    }

}
?>
