<?php

//use GuzzleHttp\Client;
include('../../../../src/estimator.php');

//Make sure that this is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    //If it isn't, send back a 405 Method Not Allowed header.
    header($_SERVER["SERVER_PROTOCOL"]." 405 Method Not Allowed", true, 405);
    exit;
}


//Get the raw POST data from PHP's input stream.
//This raw data should contain XML.
$postData = trim(file_get_contents('php://input'));

$data = json_decode($postData,tue);
$output = covid19ImpactEstimator($data);
//echo $output;

$xml = array2xml($output, false);
var_dump ($xml);


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
