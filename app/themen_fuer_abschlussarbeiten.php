<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DBController;

class themen_fuer_abschlussarbeiten extends Model
{
  protected $table = 'themen_fuer_abschlussarbeiten';

  public static function getModelThemen_Abschlussarbeit($mitarbeiter)
  {
      $modelthemen_Abschlussarbeit = DB::table('themen_im_bachelorseminar')
                                  ->where('Betreuer', $mitarbeiter)
                                  ->select('Thema')
                                  ->get();

  return $modelthemen_Abschlussarbeit;
  }
}
