<?php
namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DBController;
use App\Http\Controllers\BotManController;
class veranstaltung extends Model
{
    //
    protected $table = 'veranstaltung';
//Funktion für Aufruf der Information zur Klausurvorleistung aus der DB
        public static function getModelVorleistung($veranstaltung)
        {
            $modelanmeldung = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', 'Vorlesung')
                                ->value('Klausurvorleistung');
            return $modelanmeldung;
        }
        // Funktion um die Anmeldung einer Veranstaltung aus der DB zu holen
        public static function getModelVoraussetzung($veranstaltung)
        {
            $modelanmeldung = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', 'Vorlesung')
                                ->value('Voraussetzung');
            return $modelanmeldung;
        }
//Nutzer will mehr Information zu der Veranstaltung haben -> Hole Links aus der DB -> UniVZ und Webseite der Professur
        public static function getModelUeberblick($veranstaltung)
        {
            $modelueberblick = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', 'Vorlesung')
                                ->select('Hyperlink', 'UniVZ_Link');
                                ->get();
        return $modelueberblick;
        }
//Liste der Literatur die bei der Veranstaltung empfohlen ist
        public static function getModelLiteratur($veranstaltung)
        {
            $modelliteratur = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', 'Vorlesung')
                                ->value('Literatur');
        return $modelliteratur;
        }
        // Funktion um die Anmeldung einer Veranstaltung aus der DB zu holen
        public static function getModelTurnus($veranstaltung)
        {
            $modelturnus = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', 'Vorlesung')
                                ->value('Semester');
            return $modelturnus;
        }
        // Funktion um die Anmeldung einer Veranstaltung aus der DB zu holen
        public static function getModelAnmeldung($veranstaltung)
        {
            $modelanmeldung = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', 'Vorlesung')
                                ->value('Anmeldung');
            return $modelanmeldung;
        }
        // Funktion um die Beschreibung einer Veranstaltung aus der DB zu holen
        public static function getModelBeschreibung($veranstaltung)
        {
            $modelbeschreibung = DB::table('veranstaltung')
                                        ->where('Name', $veranstaltung)
                                        ->where('VeranstaltungsArt', 'Vorlesung')
                                        ->value('Inhalt');
            return $modelbeschreibung;
        }
        // Funktion um die Creditanzahl einer Veranstaltung aus der DB zu holen
        public static function getModelCredits($veranstaltung)
        {
            $modelcredits = DB::table('veranstaltung')
                                ->where('Name', $veranstaltung)
                                ->where('VeranstaltungsArt', 'Vorlesung')
                                ->value('Credits');
            return $modelcredits;
        }
}
