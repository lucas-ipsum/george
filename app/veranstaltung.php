<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DBController;


class veranstaltung extends Model
{
    //
    protected $table = 'veranstaltung';





        // Funktion um das Datum einer Veranstaltung aus der DB zu holen
        public static function getModelAnmeldung($veranstaltung)
        {

            $modelAnmeldung = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('Art', 'Vorlesung')
                                ->value('Voraussetzung');

            return $modelAnmeldung;
        }


        // Funktion um das Datum einer Veranstaltung aus der DB zu holen
        public static function getModelBeschreibung($veranstaltung)
        {

            $modelbeschreibung = DB::table('veranstaltung')
                                        ->where('Name', $veranstaltung)
                                        ->where('Art', 'Vorlesung')
                                        ->value('Inhalt');

            return $modelbeschreibung;
        }

        // Funktion um das Datum einer Veranstaltung aus der DB zu holen
        public static function getModelKlausurtermin($veranstaltung)
        {

            $modelklausurtermin = DB::table('veranstaltung')
                                  ->where('Name', $veranstaltung)
                                  ->where('Art', 'Vorlesung')
                                  ->value('Klausurtermin');

            return $modelklausurtermin;
        }


        // Funktion um das Datum einer Veranstaltung aus der DB zu holen
        public static function getModelCredits($veranstaltung)
        {

            $modelcredits = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('Art', 'Vorlesung')
                                ->value('Credits');

            return $modelcredits;
        }


        // Funktion um das Datum einer Veranstaltung aus der DB zu holen
        public static function getModelDatum($veranstaltung, $veranstaltungsart)
        {


            $modeldatum = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('Art', $veranstaltungsart)
                                ->value('Datum');

            return $modeldatum;
        }


        // Funktion um die Uhrzeit einer Veranstaltung aus der DB zu holen
        public static function getModelUhrzeit($veranstaltung, $veranstaltungsart)
        {

              $modeluhrzeit = DB::table('veranstaltung')
                                    ->where('Name', $veranstaltung)
                                    ->where('Art', $veranstaltungsart)
                                    ->value('Uhrzeit');

               return $modeluhrzeit;
         }


        public static function getModelRaum($veranstaltung, $veranstaltungsart)
        {

              $modelraum = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('Art', $veranstaltungsart)
                                ->value('Raumnummer');

              //$modelraum = "ZHG 2018";
              return $modelraum;
        }


}
