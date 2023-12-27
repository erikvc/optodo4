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

$sqlGetTasks = mysqli_query($conexao, "SELECT * FROM projects") or die(mysqli_error($conexao));

$array_retorno = array();

while($rows = mysqli_fetch_array($sqlGetTasks)){

	$projectID = $rows['id'];
	$memberID = $rows['member'];
	$clientID = $rows['client'];

	$sqlGetOpen = mysqli_query($conexao, "SELECT * FROM openProjects WHERE project_id = '$projectID' AND user_id = '$userID'") or die(mysqli_error($conexao));
	$contagemOpen = mysqli_num_rows($sqlGetOpen);

	if($contagemOpen == 0){
		$projectOpen = 'close';
	}else{
		$projectOpen = 'open';
	}

	$sqlGetMember = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE id = '$memberID'"));
	$sqlGetClient = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM clients WHERE id = '$clientID'"));

	if($rows['number'] < 10){
		$projectNumberFormat = '0'.$rows['number'];
	}else{
		$projectNumberFormat = $rows['number'];
	}
	
	$enviarArray['id'] = $rows['id'];
	$enviarArray['projectName'] = $rows['projectName'];
	$enviarArray['member'] = $rows['member'];
	$enviarArray['memberImage'] = $sqlGetMember['image'];
	$enviarArray['number'] = $projectNumberFormat;
	$enviarArray['year'] = $rows['year'];
	$enviarArray['client'] = $rows['client'];
	$enviarArray['clientImage'] = $sqlGetClient['image'];
	$enviarArray['clientAbbreviation'] = $sqlGetClient['abbreviation'];
	$enviarArray['recicle'] = $rows['recicle'];
	$enviarArray['preset'] = $rows['preset'];
	$enviarArray['due_date'] = $rows['due_date'];
	$enviarArray['creation_date'] = $rows['creation_date'];
	$enviarArray['openProject'] = $projectOpen;

	
	array_push($array_retorno, $enviarArray);
	
}


echo json_encode($array_retorno);
?>