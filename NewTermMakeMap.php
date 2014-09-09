<?php
function GetDates($Meta){
    $Dates = array();
    $LastDate = date_create($Meta['stop']);
    $Date = date_create($Meta['start']);
    $Day = date_format($Date,"w"); //get start
    for ($i=0; $i<16*3; $i++){
        if ($LastDate < $Date) break;
        if (!in_array(date_format($Date,"n/j/Y"),$Meta['holiday']))
            $Dates[] = date_format($Date, "Y-m-d");
        date_modify($Date, "+2 days");
        $Day += 2;
        if ($Day > 5){
            $Day = 1;
            date_modify($Date, "+1 day");
        }
     }
     return $Dates;
}

function MakeMap($FromMeta, $ToMeta){
    $OldDates = GetDates($FromMeta);
    $NewDates = GetDates($ToMeta); 
    if (count($OldDates) != count($NewDates))
        die("Dates count mismatch");
    $Map = array();
    for ($i=0; $i < count($OldDates); $i++)
        $Map[$OldDates[$i]] = $NewDates[$i];
    return $Map;
}
?>
