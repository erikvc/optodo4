<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header('Content-Type: text/html; charset=utf-8');


require("../../conexaoPDO.php");

//$project_id = $_GET['userID'];
session_start();
$atualUserEmail = $_SESSION['optodo'];
$userInfo = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE email = '$atualUserEmail'")) or die(mysqli_error($conexao));
$userID = $userInfo['id'];

$sqlGetTasks = mysqli_query($conexao, "SELECT * FROM presets_projects") or die(mysqli_error($conexao));

$array_retorno = array();

while($rows = mysqli_fetch_array($sqlGetTasks)){

	$projectID = $rows['id'];

	$sqlGetOpen = mysqli_query($conexao, "SELECT * FROM openprojectseditmode WHERE project_id = '$projectID' AND user_id = '$userID'") or die(mysqli_error($conexao));
	$contagemOpen = mysqli_num_rows($sqlGetOpen);

	if($contagemOpen == 0){
		$projectOpen = 'close';
	}else{
		$projectOpen = 'open';
	}


	
	$enviarArray['id'] = $rows['id'];
	$enviarArray['projectName'] = $rows['projectName'];
	$enviarArray['creation_date'] = $rows['creation_date'];
	
	array_push($array_retorno, $enviarArray);
	
}


echo json_encode($array_retorno);
?>