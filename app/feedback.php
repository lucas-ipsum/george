<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DBController;
use App\Http\Controllers\BotManController;

class feedback extends Model
{
        protected $table = 'feedback';


        //Funktion um Feedback in DB zu speichern
        public static function setModelFeedback($antwort, $begruendung){
          $feedback = DB::table('feedback')->insert(
           ['Antwort' => $antwort, 'Begruendung' => $begruendung]
           );
        }
}
