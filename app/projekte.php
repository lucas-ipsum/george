<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class projekte extends Model
{
    //
    protected $table = 'projekte';


            public static function getModelProjekte($veranstaltung)
            {

                $modelprojekte = DB::table('projekte')
                                    ->select('Name')
                                    ->get();

            return $modelprojekte;
            }



}
