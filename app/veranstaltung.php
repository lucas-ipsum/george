<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DBController;
use App\Http\Controllers\BotManController;


class veranstaltung extends Model
{
    //
    protected $table = 'veranstaltung';






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
                                ->value('Wochentag');
  /*          if($modeldatum === 0){
              $richtige_veranstaltungsarten = DB::table('veranstaltung')->pluck('VeranstaltungsArt');
              foreach ($richtige_veranstaltungsarten as $richtige_veranstaltungsart) {
                $bot->reply($richtige_veranstaltungsart);
              }
            }
            else{}*/
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


              return $modelraum;
        }


}
