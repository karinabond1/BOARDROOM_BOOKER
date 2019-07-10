<?php

header('Access-Control-Allow-Origin: *');
include ('../../libs/Router.php');

$server = new Router();
$server->methodChoose();

