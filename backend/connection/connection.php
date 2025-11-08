<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$db_host = "localhost";
$db_user = "root";
$db_pass = null;
$db_name = "code-reviewer"; 

$mysql = new mysqli($db_host, $db_user, $db_pass, $db_name);

?>