<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stellenangebote extends Model
{
    protected $table = 'stellenangebote';

    //Auflisten aller aktuellen Stellenangebote
    public static function getModelStellenangebote()
    {
        $modelStellenangebote = DB::table('stellenangebote')
                            ->select('Stelle', 'Art')
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
  public static function getModelStellenangebotOrgaBewerbung($Stelle){

        //Erforderliches Profil / Anforderungen für Stelle
        $modelStellenangebote_Profil = DB::table('stellenangebote')
                                    ->where('Stelle', $Stelle)
                                    ->value('Erforderliches_Profil');
        return $modelStellenangebote_Profil;

       //Bewerbungsfrist abrufen
       $modelStellenangebote_Frist = DB::table('stellenangebote')
                                   ->where('Stelle', $Stelle)
                                   ->value('Bewerbungsfrist');

      return $modelStellenangebote_Frist;

      //Kontaktperson, wo sich beworben werden muss
      $modelStellenangebote_Kontaktperson = DB::table('stellenangebote')
                                  ->where('Stelle', $Stelle)
                                  ->value('Kontaktperson');

       return $modelStellenangebote_Kontaktperson;

       //Link für Bewerbung / Weitere Informationen
       $modelStellenangebote_Link = DB::table('stellenangebote')
                                   ->where('Stelle', $Stelle)
                                   ->value('Link');

      return $modelStellenangebote_Link;
  }


}
