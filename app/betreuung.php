<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DBController;
use App\Http\Controllers\BotManController;

class betreuung extends Model
{

    protected $table = 'betreuung';
// Ausgabe aller Ansprechpartner zu einer Veranstaltung
    public static function getModelAnsprechpartner($veranstaltung){

    $modelAnsprechpartner = DB::table('betreuung')
                     ->join('Veranstaltung','Betreuung.ID_Veranstaltung', '=', 'Veranstaltung.ID_Veranstaltung')
                     ->where('Veranstaltung.Name', '=', $veranstaltung)
                     ->select('Betreuung.Betreuer', 'Veranstaltung.Verantwortlicher')
                     ->get();

      return $modelAnsprechpartner;
    }
  //Ausgabe aller Veranstaltungen eines Mitarbeiters
    public static function getModelBetreuung($mitarbeiter){

        $modelbetreuung = DB::table('betreuung')
                ->join('Veranstaltung','Betreuung.ID_Veranstaltung', '=', 'Veranstaltung.ID_Veranstaltung')
                ->where('Betreuung.Betreuer', '=', $mitarbeiter)
                ->select('Veranstaltung.Name')
                ->get();

        return $modelbetreuung;
    }
}
