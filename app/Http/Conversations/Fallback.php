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
        $this->say()->url('www.uni-goettingen.de'); //'Hier sind einige Beispielfragen: Wo ist die IKS Vorlesung?'
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
        Button::create('Henrik Wesseloh')->value('Stefen Zenker'),    //henrik.wesseloh@uni-goettingen.de
    //    ElementButton::create('Jan Moritz Anke')->url('https://stackoverflow.com/questions/51074583/how-can-i-make-a-botman-url-button-for-facebook-messenger-that-acts-as-a-webview'),      //janke@uni-goettingen.de
        Button::create('Steffen Zenker')->value('Stefen Zenker'),
        Button::create('Henrik Wesseloh')->value('Stefen Zenker'),
      ]);
      $this->ask($mitarbeiter);
  }
}
