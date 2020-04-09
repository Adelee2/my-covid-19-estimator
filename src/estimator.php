<?php
function covid19ImpactEstimator($data)
{

//    $data = json_encode($datas, JSON_FORCE_OBJECT);
    if($data["periodType"] =="days") {
        $infection_time = (int)($data["timeToElapse"] / 2);
    }
    elseif ($data["periodType"] =="weeks"){
       $infection_time =  (int)(($data["timeToElapse"] * 7)/2);
    }
    elseif ($data["periodType"] =="months"){
        $infection_time =  (int)(($data["timeToElapse"] * 30)/2);
    }
    else{
        $infection_time = 0;
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
        $IdollarsInFlight = $impactinfectionsByRequestedTime * 0.65 * 1.5 * $data["timeToElapse"];
        $SdollarsInFlight = $severeimpactinfectionsByRequestedTime * 0.65 * 1.5 * $data["timeToElapse"];
    }
    elseif ($data["periodType"] =="weeks"){
        $IdollarsInFlight = $impactinfectionsByRequestedTime * 0.65 * 1.5 * $data["timeToElapse"] * 7;
        $SdollarsInFlight = $severeimpactinfectionsByRequestedTime * 0.65 * 1.5 * $data["timeToElapse"] *7;
    }
    elseif ($data["periodType"] =="months"){
        $IdollarsInFlight = $impactinfectionsByRequestedTime * 0.65 * 1.5 * $data["timeToElapse"] * 30;
        $SdollarsInFlight = $severeimpactinfectionsByRequestedTime * 0.65 * 1.5 * $data["timeToElapse"] * 30;
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
                    "hospitalBedsByRequestedTime": '.$IhospitalBedsByRequestedTime.',
                    "casesForICUByRequestedTime": '.$IcasesForICUByRequestedTime.',
                    "casesForVentilatorsByRequestedTime": '.$IcasesForVentilatorsByRequestedTime.',
                    "dollarsInFlight": '.$IdollarsInFlight.'
                },
            "severeImpact":{
                    "currentlyInfected": '.$severeimpactcurrentlyInfected.',
                    "infectionsByRequestedTime": '.$severeimpactinfectionsByRequestedTime.',
                    "severeCasesByRequestedTime": '.$SsevereCasesByRequestedTime.',
                    "hospitalBedsByRequestedTime": '.$ShospitalBedsByRequestedTime.',
                    "casesForICUByRequestedTime": '.$ScasesForICUByRequestedTime.',
                    "casesForVentilatorsByRequestedTime": '.$ScasesForVentilatorsByRequestedTime.',
                    "dollarsInFlight": '.$SdollarsInFlight.'
                }
            }';
    
    $newdata = json_decode($out_data,true);
    $newdata['data'] =$data;
    
    $newdata = '.json_encode($newdata).';
    echo $newdata;
}
