<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class betreuung extends Model
{
    //

    protected $table = 'betreuung';

    public static function getModelBetreuung($mitarbeiter)
    {

    /*    $modelbetreuung = DB::table('betreuung')
                              ->where('Name', $mitarbeiter)
                              ->first();
                            //  ->value('ID_Veranstaltung')->get(); */

      $modelbetreuung = DB::table('betreuung')
                      ->lists('Betreuer');
                    //  ->where('Betreuer', $mitarbeiter)->get();


        return $modelbetreuung;
    }
