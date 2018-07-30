<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DBController;


class veranstaltung extends Model
{
    //
    protected $table = 'veranstaltung';





        // Funktion um die Anmeldung einer Veranstaltung aus der DB zu holen
        public static function getModelAnmeldung($veranstaltung)
        {

            $modelAnmeldung = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', 'Vorlesung')
                                ->value('Voraussetzung');

            return $modelAnmeldung;
        }


        // Funktion um die Beschreibung einer Veranstaltung aus der DB zu holen
        public static function getModelBeschreibung($veranstaltung)
        {

            $modelbeschreibung = DB::table('veranstaltung')
                                        ->where('Name', $veranstaltung)
                                        ->where('VeranstaltungsArt', 'Vorlesung')
                                        ->value('Inhalt');

            return $modelbeschreibung;
        }

        // Funktion um den Klausurtermin einer Veranstaltung aus der DB zu holen
        public static function getModelKlausurtermin($veranstaltung)
        {

            $modelklausurtermin = DB::table('veranstaltung')
                                  ->where('Name', $veranstaltung)
                                  ->where('VeranstaltungsArt', 'Vorlesung')
                                  ->value('Klausurtermin');

            return $modelklausurtermin;
        }


        // Funktion um die Creditanzahl einer Veranstaltung aus der DB zu holen
        public static function getModelCredits($veranstaltung)
        {

            $modelcredits = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', 'Vorlesung')
                                ->value('Credits');

            return $modelcredits;
        }


        // Funktion um das Datum einer Veranstaltung aus der DB zu holen
        public static function getModelDatum($veranstaltung, $veranstaltungsart)
        {


            $modeldatum = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', $veranstaltungsart)
                                ->value('Datum');

            return $modeldatum;
        }


        // Funktion um die Uhrzeit einer Veranstaltung aus der DB zu holen
        public static function getModelUhrzeit($veranstaltung, $veranstaltungsart)
        {

              $modeluhrzeit = DB::table('veranstaltung')
                                    ->where('Name', $veranstaltung)
                                    ->where('VeranstaltungsArt', $veranstaltungsart)
                                    ->value('Uhrzeit');

               return $modeluhrzeit;
         }


        // Funktion um den Raum einer Veranstaltung aus der DB zu holen
        public static function getModelRaum($veranstaltung, $veranstaltungsart)
        {

              $modelraum = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', $veranstaltungsart)
                                ->value('Raumnummer');

              //$modelraum = "ZHG 2018";
              return $modelraum;
        }


}
