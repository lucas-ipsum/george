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

     protected $begruendung;
     protected $zufrienden;




     public function run()
     {
       $feedback = Question::create('Bist du mit meiner Auskunft zufrieden?')
       ->addButtons([
         Button::create('Ja')->value('Ja'),
         Button::create('Nein')->value('Nein'),
       ]);
       $this->ask($feedback, function ($answer) {
           $this->zufrieden = $answer->getValue();
       if($this->zufrieden === 'Ja'){
         $this->say('Danke');
         $this->begruendung = '';
         $session_id = 111;

         //Einspeichern der Feedbackinformationen in DB
         DB::table('Feedback')->insert(
          ['User_ID' => $session_id, 'Antwort' => $this->zufrieden, 'begruendung' => $this->begruendung]
          );
       }
       else{
         $this->ask('Schade, kannst du mir Feedback geben, damit ich verbessert werden kann?', function ($answer){
          //Speichern des Nutzerinputs
           $this->begruendung = $answer->getText();
           $session_id = 111;
           $this->say('Danke für dein Feedback!');
           DB::table('Feedback')->insert(
            ['User_ID' => $session_id, 'Antwort' => $this->zufrieden, 'begruendung' => $this->begruendung]
            );
         });
       }
      });
   }
 }
