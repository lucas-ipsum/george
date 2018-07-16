<?php
use App\Http\Controllers\BotManController;
use BotMan\BotMan\Middleware\Dialogflow;         //Import Dialogflow Middleware API

$botman = resolve('botman');


//Versuch Dialogflow integration

$dialogflow = Dialogflow::create('2995d36e25a74557b14f26acc6610a15')->listenForAction(); //Client access token Dialogflow eingefügt

// Apply global "received" middleware
$botman->middleware->received($dialogflow); //Jede Nachricht die ankommt wird an die Middleware geschickt

// Apply matching middleware per hears command
$botman->hears('sayHallo', function ($bot) {
    // The incoming message matched the "my_api_action" on Dialogflow
    // Retrieve Dialogflow information:
//    $extras = $bot->getMessage()->getExtras();
//    $welcome = $extras['apifullfilmentText'];
  //  $apiReply = $extras['apiReply'];
  //  $apiAction = $extras['apiAction'];
  //  $apiIntent = $extras['apiIntent'];

//    if ($apiIntent === 'Default Welcome Intent') {
      $bot->reply('Willkommen bei der Professur für Anwendnungssysteme und E-Business. Wir helfen Ihnen gerne mit Fragen zu unseren Veranstaltungen und Mitarbeitern weiter. Was können wir für Sie tun?');


     //$bot->reply(ButtonTemplate::create('Hi !!')
      // ->addButton(ElementButton::create('Hi')->type('postback')->payload('hi'))
      //  );


})->middleware($dialogflow);      //Hört nur auf Middleware Intents gibt der NUtzer den Intent als eingabe ein wird nicht gematcht

// Start listening
//$botman->listen();



//Standard IO Aufbau Botman
/*$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');
*/
