<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class veranstaltung extends Model
{
    //
    protected $table = 'veranstaltung';



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

              return $modelraum;
        }


}
