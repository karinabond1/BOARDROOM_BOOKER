<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

include ('../../libs/Router.php');

$server = new Router();
$server->methodChoose();

