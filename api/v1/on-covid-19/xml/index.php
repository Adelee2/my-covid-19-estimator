<?php

//use GuzzleHttp\Client;
include('../../../../src/estimator.php');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type');
header('Content-Type: application/xml');

//Get the raw POST data from PHP's input stream.
//This raw data should contain XML.
$postData = trim(file_get_contents('php://input'));

$data = json_decode($postData,true);
$output = covid19ImpactEstimator($data);
//echo $output;

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
