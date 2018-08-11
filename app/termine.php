<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DBController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BotManController;

class termine extends Model
{
  protected $table = 'termine';
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
//#######################################
//raum_Seminar
public static function getModelRaumSeminar($seminar, $seminar_Veranstaltung)
{

      $modelraum_Seminar = DB::table('termine')
                        ->where('Veranstaltung', $seminar)
                        ->where('Veranstaltungsart', $seminar_Veranstaltung)
                        ->value('Raum');


      return $modelraum_Seminar;
}
//Alle Termine fürs Seminar im Überblick
    public static function getModel_Termine_Seminar($seminar)
    {
        $model_Termine_Seminar = DB::table('termine')
        ->join('Veranstaltung','Veranstaltung.ID_Veranstaltung', '=', 'Termine.ID_Veranstaltung')
        ->where('Veranstaltung.Name', $seminar)
        ->select('Termine.Datum', 'Termine.Uhrzeit', 'Termine.Veranstaltungsart')
        ->get();
    return $model_Termine_Seminar;
    }
    //Alle Termine fürs Seminar im Überblick
    public static function getModel_naechster_Termin_Seminar($seminar, $datum_heute)
      {
            $model_naechster_Termin_Seminar = DB::table('termine')
            ->join('Veranstaltung','Termine.ID_Veranstaltung', '=', 'Veranstaltung.ID_Veranstaltung')
            ->where('Veranstaltung.Name', $seminar)
            ->where('Termine.Datum1', '>=', $datum_heute)
            ->select('Termine.Datum1')
            ->get();

          return $model_naechster_Termin_Seminar;

        }
      //Veranstaltungsart zu Termin
        public static function getModel_art_Veranstaltung_nachTermin($seminar, $termin_veranstaltung)
          {
                $model_art_Veranstaltung_nachTermin = DB::table('termine')
                ->join('Veranstaltung','Termine.ID_Veranstaltung', '=', 'Veranstaltung.ID_Veranstaltung')
                ->where('Veranstaltung.Name', $seminar)
                ->where('Termine.Datum1', '=', $termin_veranstaltung)
                ->value('Termine.Veranstaltungsart');


              return $model_art_Veranstaltung_nachTermin;

            }
}
