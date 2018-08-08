<?php

/*namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\App\Http\Controllers\DBController;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Conversation
{

    protected $buttonAnswer;

   // $Beispielfragen = array ('Wo ist die IKS Vorlesung?', 'Wer ist der Ansprechpartner für MIS?', 'Wann ist die U&M Klausur?');

    public function run()
    {
      $feedback = Question::create('Bist du mit meiner Auskunft zufrieden, gib mir bitte Feedback!')
      ->addButtons([
        Button::create('Ja')->value('Ja'),
        Button::create('Nein')->value('Nein'),
      ]);
      $this->ask($feedback, function ($answer) {
          $buttonAnswer = $answer->getValue();
          $sessionid = 111;
          $begruendung = '';
      if($buttonAnswer === 'Ja'){

        $this->say('Danke');
      }
      else{
        $this->say('Schade, kannst du mir Feedback geben, damit ich verbesser werden kann?');
      }
      });
      /*DB::table('feedback')->insert([
        ['User_ID' => $sessionid, 'votes' => 0],
        ['Antwort' => $buttonAnswer, 'votes' => 0],
        ['Begründung' => '0', 'votes' => 0]
        ]
      );*/
  }
}
