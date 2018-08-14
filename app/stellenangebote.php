<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DBController;
use App\Http\Controllers\BotManController;

class stellenangebote extends Model
{
    //
    protected $table = 'Stellenangebote';

//Abfrage von der Stellen
            public static function getModelStellenangebote()
            {
                $model_stellenangebote = DB::table('Stellenangebote')
                                    ->select('Stelle')
                                    ->get();

            return $model_stellenangebote;
          }
}

?>
