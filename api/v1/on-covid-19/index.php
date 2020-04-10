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

 echo json_encode(covid19ImpactEstimator($data),JSON_PRETTY_PRINT);

$httptime  = $_SERVER['REQUEST_TIME'];
$httprequest = $_SERVER['REQUEST_METHOD'];
$httpuri = $_SERVER['REQUEST_URI'];

chmod($file, 0777);
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

