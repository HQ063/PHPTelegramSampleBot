<?php

class ExampleController{
  public static function registerCommands() {
    Router::registerCommand('start', array('ExampleController', 'welcome'), FLAG_PV | FLAG_GROUP);
  }

  function welcome($update){
    $update->answer('Bienvenido');
  }
}

ExampleController::registerCommands();

?>