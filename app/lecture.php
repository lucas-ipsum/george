<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class lecture extends Model
{
    //
    protected $table = 'veranstaltung';


    public static function getRoom($veranstaltung, $veranstaltungsart)
    {
        //table('veranstaltung')
      $dbroom = DB::table('veranstaltung')
                          ->where('Name', $veranstaltung)
                          ->where('Art', $veranstaltungsart)
                          ->value('Raumnummer');

        return $dbroom;
    }







}
