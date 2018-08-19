<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DBController;
use App\Http\Controllers\BotManController;

use BotMan\BotMan\Storages\Storage;
use App\Http\Controllers\Intents_Controller;
use App\Http\Controllers\BotManController;
use Illuminate\Http\Request;


class feedback extends Model
{
        protected $table = 'Feedback';


        //Funktion um Feedback in DB zu speichern
        public function setModel_Feedback($antwort, $begruendung)
        {
          DB::table('Feedback')->insert(
           ['Antwort' => $antwort, 'begruendung' => $begruendung, 'verantwortlicher' => 'Raphael Meyer von Wolff']
           );
        }
}
