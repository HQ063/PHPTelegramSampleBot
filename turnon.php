<?php

require("lib/config.php");

$url = 'https://' . $_SERVER['HTTP_HOST'] . str_replace('turnon.php', 'index.php', $_SERVER['SCRIPT_NAME']);

$post = array('url' => $url);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, API_URL."setWebhook");
curl_setopt($ch, CURLOPT_POST,1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$result=curl_exec ($ch);
curl_close ($ch);
echo "<pre>";
print_r($result);
print_r($post);
echo "</pre>";

?>
