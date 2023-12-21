<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header('Content-Type: text/html; charset=utf-8');


require("../../conexaoPDO.php");

$task_id = $_POST['task_id'];

$sqlGetSteps = mysqli_query($conexao, "SELECT * FROM steps WHERE task_id = '$task_id'") or die(mysqli_error($conexao));

$array_retorno = array();

while($rows = mysqli_fetch_array($sqlGetSteps)){
	
	$enviarArray['id'] = $rows['id'];
	$enviarArray['title'] = $rows['title'];
	$enviarArray['task_id'] = $rows['task_id'];
	$enviarArray['creation_date'] = $rows['creation_date'];
	
	array_push($array_retorno, $enviarArray);
	
}


echo json_encode($array_retorno);
?>