<?php

include('../../../src/estimator.php');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type');
header('Content-Type: application/json');


//Get the raw POST data from PHP's input stream.
//This raw data should contain XML.
$postData = trim(file_get_contents('php://input'));
echo $postData."<br/>";
$data = json_decode($postData,true);
 echo json_encode(covid19ImpactEstimator($data),JSON_PRETTY_PRINT);
// echo $output;
?>

