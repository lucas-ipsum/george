<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;


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
      $mitarbeiter = Question::create('Welchen Mitarbeiter möchten Sie kontaktieren?')
      ->addButtons([
        Button::create('Pascal Freier')->value('Pascal Freier'),
        Button::create('Steffen Zenker')->value('Stefen Zenker'),
        Button::create('Raphael Meyer von Wolff')->value('Raphael Meyer von Wolff'), //henrik.wesseloh@uni-goettingen.de
        Button::create('Henrik Wesseloh')->value('Henrik Wesseloh'),
    //    ElementButton::create('Jan Moritz Anke')->url('https://stackoverflow.com/questions/51074583/how-can-i-make-a-botman-url-button-for-facebook-messenger-that-acts-as-a-webview'),      //janke@uni-goettingen.de
    //  Button::create('Steffen Zenker')->value('Stefen Zenker'),
    //  Button::create('Henrik Wesseloh')->value('Stefen Zenker'),
      ]);
      $this->ask($mitarbeiter, function($answer) {
        $buttonAnswer = $answer->getValue();
      if($buttonAnswer === 'Pascal Freier'){
        $this->pascal($buttonAnswer);
      }

      elseif ($buttonAnswer === 'Steffen Zenker') {
        $this->steffen();
      }
      elseif ($buttonAnswer === 'Raphael Meyer von Wolff') {
        $this->rafael();
      }
      else{
        $this->henrik();
      }
    });
  }
    public function pascal(){
      $kontaktart = Question::create('Wie möchtest du Pascal Freier kontaktieren?')
      //$this->say('Hallo Pascal');
      ->addButtons([
        Button::create('Telefon')->value('Telefonnr'),
        Button::create('E-Mail')->value('E-Mail'),
      ]);
      $this->ask($kontaktart, function($answer){
        $buttonAnswer = $answer->getValue();
        if($buttonAnswer === 'Telefonnr'){
          $this->say($buttonAnswer .': +49 (0)551 / 39 - 7881');
        }
        else {
          $this->say($buttonAnswer .': pfreier@uni-goettingen.de');
        }
      });
    }
    public function steffen(){
      $kontaktart = Question::create('Wie möchtest du Steffen Zenker kontaktieren?')
      //$this->say('Hallo Pascal');
      ->addButtons([
        Button::create('Telefon')->value('Telefonnr'),
        Button::create('E-Mail')->value('E-Mail'),
      ]);
      $this->ask($kontaktart, function($answer){
        $buttonAnswer = $answer->getValue();
        if($buttonAnswer === 'Telefonnr'){
          $this->say($buttonAnswer .': +49 (0)551 / 39 - 4449');
        }
        else {
          $this->say($buttonAnswer .': steffen.zenker@uni-goettingen.de');
        }
      });
    }
    public function henrik(){
      $kontaktart = Question::create('Wie möchtest du Henrik Wesseloh kontaktieren?')
      //$this->say('Hallo Pascal');
      ->addButtons([
        Button::create('Telefon')->value('Telefonnr'),
        Button::create('E-Mail')->value('E-Mail'),
      ]);
      $this->ask($kontaktart, function($answer){
        $buttonAnswer = $answer->getValue();
        if($buttonAnswer === 'Telefonnr'){
          $this->say($buttonAnswer .': +49 (0)551 / 39 - 7331');
        }
        else {
          $this->say($buttonAnswer .': henrik.wesseloh@uni-goettingen.de');
        }
      });
    }
    public function rafael(){
      $kontaktart = Question::create('Wie möchtest du Raphael Meyer von Wolff kontaktieren?')
      //$this->say('Hallo Pascal');
      ->addButtons([
        Button::create('Telefon')->value('Telefonnr'),
        Button::create('E-Mail')->value('E-Mail'),
      ]);
      $this->ask($kontaktart, function($answer){
        $buttonAnswer = $answer->getValue();
        if($buttonAnswer === 'Telefonnr'){
          $this->say($buttonAnswer .': +49 (0)551 / 39 - 4479');
        }
        else {
          $this->say($buttonAnswer .': r.meyervonwolff@uni-goettingen.de');
        }
      });
    }
}
