<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header('Content-Type: text/html; charset=utf-8');


require("../../conexaoPDO.php");

$taskID = $_GET['taskID'];
$horas = $_GET['horas'];
$minutos = $_GET['minutos'];
$segundos = $_GET['segundos'];

$horasUpdate = $horas.':'.$minutos.':'.$segundos;


	$sqlChangePlay = mysqli_query($conexao, "UPDATE tasks SET play = 0, horas = '$horasUpdate' WHERE id = '$taskID'");
	echo 'pause';


?>