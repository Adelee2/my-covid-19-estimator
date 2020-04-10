<?php
ini_set("allow_url_fopen", true);

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type');
header('Content-Type: application/json');


//Get the raw POST data from PHP's input stream.
//This raw data should contain XML.
$postData = trim(file_get_contents('php://input'));

$filename = $_SERVER['SERVER_NAME']."/api/v1/on-covid-19/logs/data.txt";
$handle = fopen($filename,'r+');
$contents = fread($handle, filesize($filename));
echo $contents;
fclose($handle);
?>
