<?php

function covid19ImpactEstimator($data)
{
    if($data["periodType"] =="days") {
        $infection_time = (int)($data["timeToElapse"] / 3);
        $time = $data["timeToElapse"];

    }
    elseif ($data["periodType"] =="weeks"){
        $infection_time =  (int)(($data["timeToElapse"] * 7)/3);
        $time = $data["timeToElapse"] * 7;
    }
    elseif ($data["periodType"] =="months"){
        $infection_time =  (int)(($data["timeToElapse"] * 30)/3);
        $time = $data["timeToElapse"] * 30;
    }
    else{
        $infection_time = 0;
        $time = 0;
    }
    $impactcurrentlyInfected= $data["reportedCases"] * 10;
    $impactinfectionsByRequestedTime= $impactcurrentlyInfected * pow(2, $infection_time);
    $severeimpactcurrentlyInfected=$data["reportedCases"] * 50;
    $severeimpactinfectionsByRequestedTime= $severeimpactcurrentlyInfected * pow(2, $infection_time);

    $IsevereCasesByRequestedTime= 0.15 * $impactinfectionsByRequestedTime;
    $SsevereCasesByRequestedTime = 0.15 * $severeimpactinfectionsByRequestedTime;
    $IhospitalBedsByRequestedTime = (0.35 * $data["totalHospitalBeds"]) - $IsevereCasesByRequestedTime;
    $ShospitalBedsByRequestedTime = (0.35 * $data["totalHospitalBeds"]) - $SsevereCasesByRequestedTime;

    $IcasesForICUByRequestedTime= 0.05 * $impactinfectionsByRequestedTime;
    $ScasesForICUByRequestedTime=0.05* $severeimpactinfectionsByRequestedTime;
    $IcasesForVentilatorsByRequestedTime = 0.02 * $impactinfectionsByRequestedTime;
    $ScasesForVentilatorsByRequestedTime= 0.02 * $severeimpactinfectionsByRequestedTime;

    if($data["periodType"] =="days") {
        $IdollarsInFlight = ($impactinfectionsByRequestedTime * $data["region"]["avgDailyIncomePopulation"] * $data["region"]["avgDailyIncomeInUSD"]) / $time;
        $SdollarsInFlight = ($severeimpactinfectionsByRequestedTime * $data["region"]["avgDailyIncomePopulation"] * $data["region"]["avgDailyIncomeInUSD"]) / $time;
    }
    elseif ($data["periodType"] =="weeks"){
        $IdollarsInFlight = ($impactinfectionsByRequestedTime * $data["region"]["avgDailyIncomePopulation"] * $data["region"]["avgDailyIncomeInUSD"]) / $time;
        $SdollarsInFlight = ($severeimpactinfectionsByRequestedTime * $data["region"]["avgDailyIncomePopulation"] * $data["region"]["avgDailyIncomeInUSD"]) / $time;
    }
    elseif ($data["periodType"] =="months"){
        $IdollarsInFlight = ($impactinfectionsByRequestedTime * $data["region"]["avgDailyIncomePopulation"] * $data["region"]["avgDailyIncomeInUSD"]) / $time;
        $SdollarsInFlight = ($severeimpactinfectionsByRequestedTime * $data["region"]["avgDailyIncomePopulation"] * $data["region"]["avgDailyIncomeInUSD"]) / $time;
    }
    else{
        $IdollarsInFlight = 0;
        $SdollarsInFlight = 0;
    }
    $out_data = '{
            "data": "",
            "impact": {
                    "currentlyInfected": '.$impactcurrentlyInfected.',
                    "infectionsByRequestedTime": '.$impactinfectionsByRequestedTime.',
                    "severeCasesByRequestedTime": '.$IsevereCasesByRequestedTime.',
                    "hospitalBedsByRequestedTime": '.(int)$IhospitalBedsByRequestedTime.',
                    "casesForICUByRequestedTime": '.(int)$IcasesForICUByRequestedTime.',
                    "casesForVentilatorsByRequestedTime": '.(int)$IcasesForVentilatorsByRequestedTime.',
                    "dollarsInFlight": '.(int)$IdollarsInFlight.'
                },
            "severeImpact":{
                    "currentlyInfected": '.$severeimpactcurrentlyInfected.',
                    "infectionsByRequestedTime": '.$severeimpactinfectionsByRequestedTime.',
                    "severeCasesByRequestedTime": '.$SsevereCasesByRequestedTime.',
                    "hospitalBedsByRequestedTime": '.(int)$ShospitalBedsByRequestedTime.',
                    "casesForICUByRequestedTime": '.(int)$ScasesForICUByRequestedTime.',
                    "casesForVentilatorsByRequestedTime": '.(int)$ScasesForVentilatorsByRequestedTime.',
                    "dollarsInFlight": '.(int)$SdollarsInFlight.'
                }
            }';

    $newdata = json_decode($out_data,true);
    $newdata['data'] =$data;

    // $newdata = json_encode($newdata, JSON_PRETTY_PRINT);
    return $newdata;
}