<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header('Content-Type: text/html; charset=utf-8');


require("../../conexaoPDO.php");

$project_id = $_GET['project_id'];

$sqlGetTasks = mysqli_query($conexao, "SELECT * FROM tasks WHERE project_id = '$project_id'") or die(mysqli_error($conexao));

$array_retorno = array();

while($rows = mysqli_fetch_array($sqlGetTasks)){
	
	$enviarArray['id'] = $rows['id'];
	$enviarArray['title'] = $rows['title'];
	$enviarArray['project_id'] = $rows['project_id'];
	$enviarArray['member_id'] = $rows['member_id'];
	$enviarArray['due_date'] = $rows['due_date'];
	
	array_push($array_retorno, $enviarArray);
	
}


echo json_encode($array_retorno);
?>