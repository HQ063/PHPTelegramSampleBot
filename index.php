<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set("display_errors", 1);
require_once("lib/config.php");
require_once("lib/apifunctions.php");
require_once("lib/functions.php");
require_once("lib/update.php");
require_once("lib/router.php");
require_all("controllers/");

$content = file_get_contents("php://input");
if(!$content) $content = file_get_contents("log.htm");
file_put_contents('log.htm', $content);
$update = new Update($content);

Router::route($update);

?>
