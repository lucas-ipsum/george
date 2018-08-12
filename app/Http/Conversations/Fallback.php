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

protected $name;

    public function run(){
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
      elseif($buttonAnswer === 'kontakt'){
        $this->contact();
      }
      else{
        $this->say("Ich kann dich leider nicht verstehen..");
      }
    });
    }

    //Funktion die anfragt, wecher Mitarbeiter kontaktiert werden sollte
    public function contact(){
      /* Versuch aus Arrays Button zu erzeugen
      $alleMitarbeiter = DBController::getAlleMitarbeiter();
      for($index=0; $index<3; $index++){
        $mitarbeiter = $alleMitarbeiter[$index]->Name;
        ->addButtons([
        Button::create($mitarbeiter)->value($mitarbeiter),*/

      $name = Question::create('Welchen Mitarbeiter möchtest du kontaktieren?')
        ->addButtons([
          Button::create('Pascal Freier')->value('Pascal Freier'),
          Button::create('Steffen Zenker')->value('Steffen Zenker'),
          Button::create('Raphael Meyer von Wolff')->value('Raphael Meyer von Wolff'),
          Button::create('Henrik Wesseloh')->value('Henrik Wesseloh'),
          Button::create('Anderer Mitarbeiter')->value('Anderer Mitarbeiter') //Muss noch zu neuer Frage gelinkt werden!*/
      ]);
      $this->ask($name, function($answer) {
        $name = $answer->getValue();
        $this->name = $name;
        if($name === 'Anderer Mitarbeiter'){
          $this->mehrereMitarbeiter();
        }
        else{
          $this->mitarbeiterKontaktieren($name);
        }
    });
  }
    public function mitarbeiterKontaktieren($name){
      $this->name = $name;
      $art = Question::create('Wie möchtest du ' . $name . ' kontaktieren?')
      ->addButtons([
        Button::create('Telefon')->value('Telefonnummer'),
        Button::create('E-Mail')->value('E-Mail'),
      ]);
      $this->ask($art, function($answer){
        $art = $answer->getValue();
        $name = $this->name;
        $kontaktinfo = DBController::getDBKontaktart($art, $name);
        $this->say($art . ': ' . $kontaktinfo);
      });

    }

    public function mehrereMitarbeiter(){
      $mehrereMitarbeiter = Question::create('Welchen anderen Mitarbeiter möchtest du kontaktieren?')
        ->addButtons([
          Button::create('Jasmin Decker')->value('Jasmin Decker'),
          Button::create('Kevin Koch')->value('Kevin Koch'),
          Button::create('Dr. Sebastian Hobert')->value('Dr. Sebastian Hobert'),
          Button::create('Jan Moritz Anke')->value('Jan Moritz Anke'),
          Button::create('Julian Busse')->value('Julian Busse'),
          Button::create('Madlen Neubert')->value('Madlen Neubert'),
      ]);
      $this->ask($mehrereMitarbeiter, function($answer) {
        $name = $answer->getValue();
        $this->name = $name;
        $this->mitarbeiterKontaktieren($name);
      });
    }
}
