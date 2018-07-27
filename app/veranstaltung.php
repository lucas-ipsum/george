<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class veranstaltung extends Model
{
    //
    protected $table = 'veranstaltung';






        public static function getModelRaum($veranstaltung, $veranstaltungsart)
        {

              $modelraum = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('Art', $veranstaltungsart)
                                ->value('Raumnummer');

              return $modelraum;
        }













}
