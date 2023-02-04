<?php
// channel -> 1062464444262789133
include __DIR__ . '/credentials.php';
require_once('Discord.php');

$discord = new Discord('1062464444262789133', TOKEN);

$discord->sendMessage('Sucesso');

if($discord->status== false) {
    var_dump($discord->error);
}
