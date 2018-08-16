<?php

 namespace App\Http\Conversations;

use BotMan\BotMan\Storages\Storage;
use App\Http\Controllers\Intents_Controller;
use App\Http\Controllers\BotManController;

 use BotMan\BotMan\Messages\Conversations\Conversation;
 use BotMan\BotMan\Messages\Outgoing\Actions\Button;
 use BotMan\BotMan\Messages\Outgoing\Question;
 use BotMan\App\Http\Controllers\DBController;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Database\Eloquent\Model;

 class Feedback extends Conversation
 {
//Controller für Feedbackanfrage, welcher auf Timer und Eingabe "bananenkanu" reagiert

     protected $begruendung;
     protected $zufrienden;




     public function run()
     {
       $feedback = Question::create('Bist du mit meiner Auskunft zufrieden?')
       ->addButtons([
         Button::create('Ja')->value('Ja'),
         Button::create('Nein')->value('Nein'),
         Button::create('Nächstes Mal bewerten')->value('Nächstes Mal bewerten'),
       ]);
       $this->ask($feedback, function ($answer) {
           $this->antwort = $answer->getValue();
       if($this->antwort === 'Ja'){
         $this->say('Danke für dein Feedback!');
         $this->begruendung = '';
         //Einspeichern der Feedbackinformationen in DB
         DB::table('Feedback')->insert(
          ['Antwort' => $this->antwort, 'begruendung' => $this->begruendung]
          );
       }
       elseif($this->antwort === 'Nein'){
         $this->ask('Schade, kannst du mir Feedback geben? Schreib mir, was ich verbessern kann!', function ($answer){
          //Speichern des Nutzerinputs
           $this->begruendung = $answer->getText();
           $this->say('Danke für dein Feedback!');
           //Einspeichern der Feedbackinformationen in DB
           DB::table('Feedback')->insert(
            ['Antwort' => $this->antwort, 'begruendung' => $this->begruendung]
            );
         });
       }
       elseif($this->antwort === 'Nächstes Mal bewerten'){
         $this->say('Danke. Bitte bewerte mich das nächste Mal, damit ich verbessert werden kann.');
       }
       else{
         $this->say('Entschuldigung, ich verstehe dich nicht..'); //Breakout, falls weder ja noch nein eingegeben wurde
       }
      });
   }
 }
