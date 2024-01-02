<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header('Content-Type: text/html; charset=utf-8');


require("../../conexaoPDO.php");

$projectID = $_GET['projectID'];

function fomatHours($segundos){
    $horasFunction = floor($segundos / 3600);
    $minutosFunction = floor($segundos % 3600 / 60);
    $segundosFunction = floor($segundos % 60);

     if($horasFunction < 10){
        $horasFormat = '0'.$horasFunction;
    }else{
        $horasFormat = $horasFunction;
    }  

    if($minutosFunction < 10){
        $minutosFormat = '0'.$minutosFunction;
    }else{
        $minutosFormat = $minutosFunction;
    } 

    if($segundosFunction < 10){
        $segundosFormat = '0'.$segundosFunction;
    }else{
        $segundosFormat = $segundosFunction;
    } 

    return $horasFormat.':'.$minutosFormat.':'.$segundosFormat;
}

$sqlGetProjectID = mysqli_query($conexao, "SELECT * FROM tasks WHERE project_id = '$projectID'");

$soma = 0;

while($rows=mysqli_fetch_array($sqlGetProjectID)){
    $calc = 0;
    list($horas, $minutos, $segundos) = explode(":", $rows['horas']);
    $calc = $horas * 3600 + $minutos * 60 + $segundos;

    $soma = $soma + $calc;
}


echo fomatHours($soma);

?>