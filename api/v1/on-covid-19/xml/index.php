<?php

//use GuzzleHttp\Client;

include('../../../../src/estimator.php');
ini_set("allow_url_fopen", true);
$filename = $_SERVER['SERVER_NAME']."/api/v1/on-covid-19/logs/datas.txt";

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type');
header('Content-Type: application/xml');

//Get the raw POST data from PHP's input stream.
//This raw data should contain XML.
usleep(mt_rand(100, 10000));
$postData = trim(file_get_contents('php://input'));

$data = json_decode($postData,true);
$output = covid19ImpactEstimator($data);
//echo $output;
$httptime = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
$httprequest = $_SERVER['REQUEST_METHOD'];
$httpuri = $_SERVER['REQUEST_URI'];

$fp = fopen($filename,"a+");

$json ="";
$json = $httprequest."\t\t".$httpuri."\t\t200\t\t".$httptime."ms".PHP_EOL;

if($fp){
    fwrite($fp,$json);
}
else{
    print_r($fp);
    echo "error: "." can't create in ".$_SERVER['SERVER_NAME']."/api/v1/on-covid-19/logs/datas.txt"."\n";
}


fclose($fp);

$xml = array2xml($output, false);
echo $xml;


function array2xml($array, $xml = false){

    if($xml === false){
        $xml = new SimpleXMLElement('<result/>');
    }

    foreach($array as $key => $value){
        if(is_array($value)){
            array2xml($value, $xml->addChild($key));
        } else {
            $xml->addChild($key, $value);
        }
    }

    return $xml->asXML();
}
?>
