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

      $modelbetreuung = DB::table('betreuung')
                        ->where('Betreuer', '=' ,$mitarbeiter)
                        ->get();

        $array = get_object_vars($modelbetreuung);
        //$array = (array) $modelbetreuung;

        return $array;
    }
}
