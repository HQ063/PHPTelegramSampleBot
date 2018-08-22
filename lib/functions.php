<?php

function require_all($path) {
  foreach (glob($path.'*.php') as $filename) {
    require_once $filename;
  }
}

function tgButton($text, $key, $value){
  return array(
    'text' => $text,
    $key => $value
  );
}

function tgButtonUrl($text, $url) {
  return tgButton($text, 'url', $url);
}

function tgButtonPv($text, $command){
  return tgButton($text, 'url', BOT_URL.'?start='.$command);
}

function tgButtonData($text, $data){
  return tgButton($text, 'callback_data', $data);
}

function tgSingleButtonsRow() {
  return array(func_get_args());
}

function tgInlineKeyboardReply($buttons){
  return array('reply_markup' => array('inline_keyboard' => $buttons));
}

function tgInvalid(){
  global $update;
  $update->answer('Comando Invalido');
}

?>