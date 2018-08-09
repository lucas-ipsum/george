<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DBController;
use App\Http\Controllers\BotManController;

class betreuung extends Model
{

    protected $table = 'betreuung';

    public static function getModelAnsprechpartner($veranstaltung){

    $modelAnsprechpartner = DB::table('betreuung')
                     ->join('Veranstaltung','Betreuung.ID_Veranstaltung', '=', 'Veranstaltung.ID_Veranstaltung')
                     ->where('Veranstaltung.Name', '=', $veranstaltung)
                     ->select('Betreuung.Betreuer')
                     ->get();


      return $modelAnsprechpartner;
    }
}

/*   $json_array = array();

   while($row = mysqli_fetch_assoc($modelAnsprechpartner)){
     $json_array[] = $row;
   }
   $modelAnsprechpartner = json_encode($json_array);
/*    foreach($modelAnsprechpartner as $betreuer_)
       {
         while ($obj = $modelAnsprechpartner -> fetch_object())
         {
         $betreuer_ =  ("%s /n, $obj -> Betreuer");
         }
       }
   /*->where('Veranstaltung.Name', '=', $veranstaltung)
   ->select('Betreuung.Betreuer')
   ->get();*/
