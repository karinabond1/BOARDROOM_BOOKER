<?php
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Credentials: true');
//header('Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT');
//header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');

header('Access-Control-Allow-Origin: *'); 
//header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');



include ('../../libs/Router.php');

$server = new Router();
$server->methodChoose();

