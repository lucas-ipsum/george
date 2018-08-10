<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use App\Http\Controllers\DBController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use BotMan\BotMan\Storages\Storage;
use App\mitarbeiter;


class Fallback extends Conversation
{

    protected $buttonAnswer;

   // $Beispielfragen = array ('Wo ist die IKS Vorlesung?', 'Wer ist der Ansprechpartner für MIS?', 'Wann ist die U&M Klausur?');
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
      $question = Question::create('Entschuldige bitte, ich habe deine Frage nicht verstanden.')
      ->addButtons([
        Button::create('Beispielfragen')->value('beispiel'),
        Button::create('Mitarbeiter kontaktieren')->value('kontakt'),
      ]);
      $this->ask($question, function ($answer) {
          $buttonAnswer = $answer->getValue();
      if($buttonAnswer === 'beispiel'){
        $this->say('Was sind die Lernziele in U&M? <br><br>
                    Wird MIS im Sommersemester angeboten? <br><br>
                    Wie viele Credits bringt das Projektseminar?'); //'Hier sind einige Beispielfragen: Wo ist die IKS Vorlesung?'
      }
      else{
        $this->contact();
      }
    });
    }

    public function contact(){
      $name = Question::create('Welchen Mitarbeiter möchten Sie kontaktieren?')
      ->addButtons([
        Button::create('Pascal Freier')->value('Pascal Freier'),
        Button::create('Steffen Zenker')->value('Stefen Zenker'),
        Button::create('Raphael Meyer von Wolff')->value('Raphael Meyer von Wolff'), //henrik.wesseloh@uni-goettingen.de
        Button::create('Henrik Wesseloh')->value('Henrik Wesseloh'),
        //Button::create('Anderer Mitarbeiter')->value('Anderer Mitarbeiter'), //Muss noch zu neuer Frage gelinkt werden!
      ]);
      $this->ask($name, function($answer) {
        $name = $answer->getValue();

        if($name === 'Anderer Mitarbeiter'){
          $this->mehrereMitarbeiter();
        }
        else{
          $this->mitarbeiterKontaktieren($name);
        }
    });
  }
    public function mitarbeiterKontaktieren($name){
      $art = Question::create('Wie möchtest du ' . $name . ' kontaktieren?')
      ->addButtons([
        Button::create('Telefon')->value('Telefonnummer'),
        Button::create('E-Mail')->value('E-Mail'),
      ]);
      $this->ask($art, function($answer){
        $art = $answer->getValue();
        if($art === 'Telefonnummer'){
          $name = 'Pascal Freier';
          $kontaktinfo = DBController::getDBKontaktart($art, $name);
          $this->say($kontaktinfo);
        }
        else {
          $kontaktinfo = DBController::getDBKontaktart($art, $name);
          $this->say($kontaktart . ': ' . $kontaktinfo);
        }
      });
    }
}
