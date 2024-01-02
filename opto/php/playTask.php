<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header('Content-Type: text/html; charset=utf-8');


require("../../conexaoPDO.php");

	$taskID = $_GET['taskID'];

	$getTask = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM tasks WHERE id='$taskID'"));

	$horaBD = $getTask['horas'];

	$array_retorno = array();

	$time = explode(":", $horaBD);
	$horas = $time[0];
	$minutos = $time[1];
	$segundos = $time[2];

	$enviarArray['horas'] = $horas;
	$enviarArray['minutos'] = $minutos;
	$enviarArray['segundos'] = $segundos;
	
	array_push($array_retorno, $enviarArray);

	$sqlChangePlay = mysqli_query($conexao, "UPDATE tasks SET play = 1 WHERE id = '$taskID'");

	echo json_encode($array_retorno);

?>