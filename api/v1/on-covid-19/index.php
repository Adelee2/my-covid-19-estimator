<?php

include('../../../src/estimator.php');

//Make sure that this is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    //If it isn't, send back a 405 Method Not Allowed header.
    header($_SERVER["SERVER_PROTOCOL"]." 405 Method Not Allowed", true, 405);
    exit;
}

echo "Welcome<br/>";
//Get the raw POST data from PHP's input stream.
//This raw data should contain XML.
$postData = trim(file_get_contents('php://input'));

print_r($postData);
//$data = json_decode($postData,true);
// print_r(json_encode(covid19ImpactEstimator($data)));
// echo $output;
?>

