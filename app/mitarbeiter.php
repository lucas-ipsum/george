<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DBController;

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













}
