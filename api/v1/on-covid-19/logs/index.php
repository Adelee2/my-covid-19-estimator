<?php
//Get the raw POST data from PHP's input stream.
//This raw data should contain XML.
$filename = $_SERVER['SERVER_NAME']."/api/v1/on-covid-19/logs/data.txt";
if ($fh = fopen($filename, 'r+')) {
    while (!feof($fh)) {
        $line = fgets($fh);
        echo $line."<br/>;
    }
    fclose($fh);
}
?>
