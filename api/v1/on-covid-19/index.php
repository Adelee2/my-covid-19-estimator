<?php

include('../../../src/estimator.php');
$filename = $_SERVER['SERVER_NAME']."/api/v1/on-covid-19/logs/datas.txt";

ini_set("allow_url_fopen", true);
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type');
header('Content-Type: application/json');



//Get the raw POST data from PHP's input stream.
//This raw data should contain XML.
$postData = trim(file_get_contents('php://input'));
//echo $postData."<br/>";
$data = json_decode($postData,true);

 echo json_encode(covid19ImpactEstimator($data),JSON_PRETTY_PRINT);

$httptime  = $_SERVER['REQUEST_TIME'];
$httprequest = $_SERVER['REQUEST_METHOD'];
$httpuri = $_SERVER['REQUEST_URI'];

$fp = fopen($filename,"a+");

$json ="";
$json = $httprequest."\t\t".$httpuri."\t\t200\t\t".$httptime." ms".PHP_EOL;

if($fp){
    fwrite($fp,$json);
}
else{
    print_r($fp);
    echo "error: "." can't create in ".$_SERVER['SERVER_NAME']."/api/v1/on-covid-19/logs/datas.txt"."\n";
}


fclose($fp);
// echo $output;
?>

