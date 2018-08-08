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

}
