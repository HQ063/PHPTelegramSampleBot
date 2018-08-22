<?php

define("FLAG_GROUP", 1<<0);
define("FLAG_PV", 1<<1);
define("FLAG_CALLBACK", 1<<10);
define("FLAG_DEFAULT", FLAG_GROUP | FLAG_PV);

class Router {
  private static $commands = array();

  public static function registerCommand($command, $function, $flags = FLAG_DEFAULT){
    $command = '/'.strtolower($command);
    self::$commands[$command] = array($function, $flags);
    if($flags & FLAG_GROUP) {
      self::$commands[$command.'@'.BOT_USERNAME] = self::$commands[$command];
    }
  }

  public static function route($update){
    if(!self::$commands[$update->command]){
      //if($update->is_command || $update->is_callback) { tgInvalid(); }
      return;
    }
    list($function, $flags) = self::$commands[$update->command];
    if(self::invalidFlag($update->is_pv, $flags, FLAG_PV) || self::invalidFlag(!$update->is_pv, $flags, FLAG_GROUP) || self::invalidFlag($update->is_callback, $flags, FLAG_CALLBACK)){
      tgInvalid();
      return;
    }
    $function($update);
  }
  
  public static function invalidFlag($is, $flags, $chechFlag) {
    return $is && !($flags & $chechFlag);
  }
}

?>