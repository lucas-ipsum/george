<?php
namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DBController;
use App\Http\Controllers\BotManController;

class mitarbeiter extends Model
{
    //
    protected $table = 'mitarbeiter';




    // Funktion um die Anmeldung einer Veranstaltung aus der DB zu holen
    public static function getModelKontaktart($kontaktart, $mitarbeiter)
    {

        $modelcontact = DB::table('mitarbeiter')
                              ->where('Name', $mitarbeiter)
                              ->value($kontaktart);

    return $modelcontact;
    }

    public static function getModelAlleMitarbeiter()
    {

        $AlleMitarbeiter = DB::table('mitarbeiter')
                              ->select('Name')
                              ->get();

    return $AlleMitarbeiter;
    }
   public static function getModel_Bueroraum($mitarbeiter){

     $model_Bueroraum = DB::table('mitarbeiter')
                        ->where('Name', $mitarbeiter)
                        ->value('Bueroraum');

        return $model_Bueroraum;
   }
}
