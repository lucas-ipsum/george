<?php
/*
namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DBController;
use App\Http\Controllers\BotManController;


class veranstaltung extends Model
{
    //
    protected $table = 'termine';





/*
        public static function getModelVorleistung($veranstaltung)
        {

            $modelanmeldung = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', 'Vorlesung')
                                ->value('Klausurvorleistung');

            return $modelanmeldung;
        }


        // Funktion um die Anmeldung einer Veranstaltung aus der DB zu holen
        public static function getModelVoraussetzung($veranstaltung)
        {

            $modelanmeldung = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', 'Vorlesung')
                                ->value('Voraussetzung');

            return $modelanmeldung;
        }


        public static function getModelUeberblick($veranstaltung)
        {

            $modelueberblick = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', 'Vorlesung')
                                ->value('Hyperlink');

        return $modelueberblick;
        }


        public static function getModelLiteratur($veranstaltung)
        {

            $modelliteratur = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', 'Vorlesung')
                                ->value('Literatur');

        return $modelliteratur;
        }


        // Funktion um die Anmeldung einer Veranstaltung aus der DB zu holen
        public static function getModelTurnus($veranstaltung)
        {

            $modelturnus = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', 'Vorlesung')
                                ->value('Semester');

            return $modelturnus;
        }


        // Funktion um die Anmeldung einer Veranstaltung aus der DB zu holen
        public static function getModelAnmeldung($veranstaltung)
        {

            $modelanmeldung = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', 'Vorlesung')
                                ->value('Anmeldung');

            return $modelanmeldung;
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
                                  ->value('Klausur');

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

//#################################################################################
//Seminar
        // Funktion um das Datum einer Veranstaltung aus der DB zu holen
        public static function getModelDatumSeminar($seminar, $seminar_Veranstaltung)
        {


            $modeldatum_Seminar = DB::table('termine')
                                ->where('Veranstaltung', $seminar)
                                ->where('Veranstaltungsart', $seminar_Veranstaltung)
                                ->value('Wochentag');

            return $modeldatum_Seminar;
        }

//#################################################################################
//Seminar
        // Funktion um die Uhrzeit einer Veranstaltung aus der DB zu holen
        public static function getModelUhrzeitSeminar($seminar, $seminar_Veranstaltung)
        {

              $modeluhrzeit_Seminar = DB::table('termine')
                                    ->where('Veranstaltung', $seminar)
                                    ->where('Veranstaltungsart', $seminar_Veranstaltung)
                                    ->value('Uhrzeit');

               return $modeluhrzeit_Seminar;
         }


        // Funktion um den Raum einer Veranstaltung aus der DB zu holen
        public static function getModelRaum($veranstaltung, $veranstaltungsart)
        {

              $modelraum = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', $veranstaltungsart)
                                ->value('Raumnummer');


              return $modelraum;
        }


}
