<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DBController;
use App\Http\Controllers\BotManController;

class stellenangebote extends Model
{
    protected $table = 'stellenangebote';

    //Auflisten aller aktuellen Stellenangebote
    public static function getModelStellenangebote()
    {
        $modelStellenangebote = DB::table('stellenangebote')
                            ->select('Stelle', 'ID')
                            ->orderBy('ID', 'asc')
                            ->get();

    return $modelStellenangebote;
  }



  //Beschreibung eines ausgewählten Projekts
  public static function getModelStellenangebotBeschreibung($Stelle){

        $modelStellenangebote_Beschreibung = DB::table('stellenangebote')
                                    ->where('Stelle', $Stelle)
                                    ->value('Beschreibung');

       return $modelStellenangebote_Beschreibung;
  }

  //Aufgaben eines ausgewählten Projekts
  public static function getModelStellenangebotAufgaben($Stelle){

        $modelStellenangebote_Aufgaben = DB::table('stellenangebote')
                                    ->where('Stelle', $Stelle)
                                    ->value('Aufgaben');

       return $modelStellenangebote_Aufgaben;
  }
  //Organisatorisches, falls Nutzer interessiert ist
  public static function getModel_Bewerbungsinformationen($Stelle){

        //Erforderliches Profil / Anforderungen für Stelle
        $model_Bewerbungsinformationen = DB::table('stellenangebote')
                                      ->where('Stelle', $Stelle)
                                      ->select('Erforderliches_Profil', 'Bewerbungsfrist', 'Link', 'Kontaktperson')
                                      ->get();
        return $model_Bewerbungsinformationen;

      }

}
