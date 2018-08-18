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

    //Standard Fallback, falls kein Intent gematcht werden kann
    public function run(){
      $question = Question::create('Entschuldige bitte, ich habe deine Frage nicht verstanden.')
      ->addButtons([
        Button::create('Beispielfragen')->value('beispiel'),
        Button::create('Mitarbeiter kontaktieren')->value('kontakt'),
      ]);
      $this->ask($question, function ($answer) {
          $buttonAnswer = $answer->getValue();
      //Beispielfragen
      if($buttonAnswer === 'beispiel'){
        $this->say('Was sind die Lernziele in U&M? <br><br>
                    Wird MIS im Sommersemester angeboten? <br><br>
                    Wie viele Credits bringt das Projektseminar?');
      }
      //Mitarbeiter kontaktieren
      elseif($buttonAnswer === 'kontakt'){
        $this->contact();
      }
      //Breakout, falls nicht entsprechend geantwortet wird
      else{
        $this->say("Ich kann dich leider nicht verstehen..");
      }
    });
    }

    //Funktion die anfragt, wecher Mitarbeiter kontaktiert werden sollte
    public function contact(){
      //Schleife in addButtons Methode nicht möglich, deshalb hardcoded
      $name = Question::create('Welchen Mitarbeiter möchtest du kontaktieren?')
        ->addButtons([
          //Nur 4 Mitarbeiter, um Übersichtlichkeit zu gewährleisten
          Button::create('Pascal Freier')->value('Pascal Freier'),
          Button::create('Steffen Zenker')->value('Steffen Zenker'),
          Button::create('Raphael Meyer von Wolff')->value('Raphael Meyer von Wolff'),
          Button::create('Henrik Wesseloh')->value('Henrik Wesseloh'),
          Button::create('Anderer Mitarbeiter')->value('Anderer Mitarbeiter')
      ]);
      $this->ask($name, function($answer) {
        $name = $answer->getValue();
        $this->name = $name;
        if($answer->isInteractiveMessageReply()){
          if($name === 'Anderer Mitarbeiter'){
            $this->mehrereMitarbeiter();
          }
          else{
            $this->mitarbeiterKontaktieren($name);
          }
        }
        else{
          $this->repeat();
        }
    });
  }

  //Buttons für restliche Mitarbeiter
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
      //Falls keine der Möglichkeiten eingegeben wird oder per Button ausgewählt wurde
      if($answer->isInteractiveMessageReply()){
      $this->mitarbeiterKontaktieren($name);
      }
      //Wird Auswahlmöglichkeit wiederholt
      else{
        $this->repeat();
      }
  });
  }

    //Funktion um Mitarbeiterfunktionen auszugeben
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
        //Falls keine der Möglichkeiten eingegeben wird oder per Button ausgewählt wurde
        if($answer->isInteractiveMessageReply()){
        $kontaktinfo = DBController::getDBKontaktart($art, $name);
      if($art === 'Telefonnummer')
        $this->say($art . ': <a href="tel:'.$kontaktinfo.'">'.$kontaktinfo.'</a>');
      else{
        $this->say($art . ': <a href="mailto:'.$kontaktinfo.'" target="_top">'.$kontaktinfo.'</a>');
      }}
      //wird Text ausgegeben
      else{
        $this->say("Ich kann dich leider nicht verstehen..");
      }
      });

    }
}
