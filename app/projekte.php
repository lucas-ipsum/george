<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DBController;
use App\Http\Controllers\BotManController;

class projekte extends Model
{
    //
    protected $table = 'projekte';

//Abfrage von ID und Name von Projekten
            public static function getModelProjekte()
            {
                $modelprojekte = DB::table('projekte')
                                    ->select('Name', 'ID')
                                    ->orderBy('ID', 'asc')
                                    ->get();

            return $modelprojekte;
          }
//Abfrage von der Projektbeschreibung
    public static function getModelProjektBeschreibung($projekt){

          $modelprojekte_Beschreibung = DB::table('projekte')
                                      ->where('Name', $projekt)
                                      ->value('Beschreibung');

         return $modelprojekte_Beschreibung;
    }
//Abfrage der Kontaktperson zu einem Projekt (mit Email und Nummer)
    public static function getModelProjektKontaktperson($projekt){

        $modelprojekt_Kontaktperson = DB::table('projekte')
                                    ->where('Name', $projekt)
                                    ->select('Kontaktperson', 'Kontakt_Email', 'Kontakt_Telefonnummer')
                                    ->get();

        return $modelprojekt_Kontaktperson;
    }
}
