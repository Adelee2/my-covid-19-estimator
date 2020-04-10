<?php

//use GuzzleHttp\Client;
require_once '/path/to/PHP_Compat-1.6.0a3/Compat/Function/file_get_contents.php';

include('../../../../src/estimator.php');
ini_set("allow_url_fopen", true);

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type');
header('Content-Type: application/xml');

//Get the raw POST data from PHP's input stream.
//This raw data should contain XML.
$content = php_compat_file_get_contents('http://example.com');
$postData = trim(file_get_contents('php://input'));

$data = json_decode($postData,true);
$output = covid19ImpactEstimator($data);
//echo $output;
$httptime  = $_SERVER['REQUEST_TIME'];
$httprequest = $_SERVER['REQUEST_METHOD'];
$httpuri = $_SERVER['REQUEST_URI'];
$httpstatus = $_SERVER['REDIRECT_STATUS'];

$json = $httprequest."\t\t".$httpuri."\t\t".$httpstatus."\t\t".$httptime." ms\n";

$fp = fopen($_SERVER['SERVER_NAME']."/api/v1/on-covid-19/logs/data.txt",'a+');

fwrite($fp,$json);

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
