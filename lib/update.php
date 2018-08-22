<?php

class Update extends ArrayObject{
  public $command;
  public $args;

  public function __construct($json) {
    parent::__construct(json_decode($json, true));
    if($this->is_command){
      $this->parseCommandArgs($this->text);
    }
    if($this->is_callback) {
      $this->parseCommandArgs($this->callback_data);
    }
  }

  private function parseCommandArgs($text, $split = ' ') {
    $this->args = explode($split, $text);
    $this->command = strtolower(array_shift($this->args));
    if($this->is_pv && $this->command == '/start'){
      $this->parseCommandArgs($this->args[0], '-');
      $this->command = '/'.$this->command;
    }
  }

  public function __get($prop){
    $msg = $this['message'];
    if(!$msg) { $msg = $this['channel_post']; }
    switch($prop){
      case 'text':
        return $msg['text'] ?: $msg['caption'];
      case 'callback_data':
        return $this['callback_query']['data'];
      case 'chat_id':
        return $msg['chat']['id'];
      case 'message_id':
        return $msg['message_id'];
      case 'is_command':
       return $msg && $this->text[0] === '/';
      case 'is_callback':
       return $this['callback_query'];
      case 'is_pv':
      case 'is_private':
        return $this['message']['chat']['type'] == 'private';
      case 'sender_id':
        return $msg['from']['id'];
      case 'sender_username':
        return $msg['from']['username'];
	  case 'document':
		return $msg['document'];
    }
  }
  public function answer($text, $array = array()){
    if($this['callback_query']){
      $array['method'] = 'answerCallbackQuery';
      $array['callback_query_id'] = $this['callback_query']['id'];
    } else {
      $array['method'] = 'sendMessage';
      $array['chat_id'] = $this->chat_id;
    }
    $array['text'] = $text;
    $answer = json_encode($array);
    header("Content-Type: application/json");
    file_put_contents('responses.htm', $answer);
    echo $answer;
  }
  public function forward($chat_id){
    $array['method'] = 'forwardMessage';
    $array['from_chat_id'] = $this->chat_id;
    $array['chat_id'] = $chat_id;
    $array['message_id'] = $this->message_id;
    $answer = json_encode($array);
    header("Content-Type: application/json");
    file_put_contents('responses.htm', $answer);
    echo $answer;
  }
}

?>