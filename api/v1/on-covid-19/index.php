<?php

include('../../../src/estimator.php');
ini_set("allow_url_fopen", true);

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type');
header('Content-Type: application/json');


//Get the raw POST data from PHP's input stream.
//This raw data should contain XML.
$postData = trim(file_get_contents('php://input'));
//echo $postData."<br/>";
$postData= '{
        "region": {
            "name": "Africa",
            "avgAge": 19.7,
            "avgDailyIncomeInUSD": 5,
            "avgDailyIncomePopulation": 0.71
        },
        "periodType": "days",
        "timeToElapse": 58,
        "reportedCases": 674,
        "population": 66622705,
        "totalHospitalBeds": 1380614
}';
$data = json_decode($postData,true);

$httptime  = $_SERVER['REQUEST_TIME'];
$httprequest = $_SERVER['REQUEST_METHOD'];
$httpuri = $_SERVER['REQUEST_URI'];
$httpstatus = $_SERVER['REDIRECT_STATUS'];

$json = $httprequest."\t\t".$httpuri."\t\t".$httpstatus."\t\t".$httptime." ms\n";

$fp = fopen("/api/v1/on-covid-19/logs/data.txt",'a+');

fwrite($fp,$json);

fclose($fp);

 echo json_encode(covid19ImpactEstimator($data),JSON_PRETTY_PRINT);
// echo $output;
?>

