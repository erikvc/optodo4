<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header('Content-Type: text/html; charset=utf-8');


require("../../conexaoPDO.php");

session_start();
$atualUserEmail = $_SESSION['optodo'];
$userInfo = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE email = '$atualUserEmail'")) or die(mysqli_error($conexao));
$userID = $userInfo['id'];

$project_id = $_GET['project_id'];

$sqlGetTasks = mysqli_query($conexao, "SELECT * FROM presets_tasks WHERE project_id = '$project_id'") or die(mysqli_error($conexao));

$array_retorno = array();

while($rows = mysqli_fetch_array($sqlGetTasks)){

	$taskID = $rows['id'];
	$projectID = $rows['project_id'];
	$member_id = $rows['member_id'];

	$sqlGetOpen = mysqli_query($conexao, "SELECT * FROM opentaskseditmode WHERE task_id = '$taskID' AND user_id = '$userID'") or die(mysqli_error($conexao));
	$contagemOpen = mysqli_num_rows($sqlGetOpen);

	if($contagemOpen == 0){
		$taskOpen = 'close';
	}else{
		$taskOpen = 'open';
	}

	$sqlGetMember = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE id = '$member_id'"));

	/**FORMAT HORAS */
	$horas = date("H", strtotime($rows['horas']));
	$minutos = date("i", strtotime($rows['horas']));
	$segundos = date("s", strtotime($rows['horas']));

	if($rows['number'] < 10){
		$taskNumberFormat = '0'.$rows['number'];
	}else{
		$taskNumberFormat = $rows['number'];
	}
	
	
	$enviarArray['id'] = $rows['id'];
	$enviarArray['title'] = $rows['title'];
	$enviarArray['project_id'] = $rows['project_id'];
	$enviarArray['member_id'] = $rows['member_id'];
	$enviarArray['number'] = $taskNumberFormat;
	$enviarArray['due_date'] = $rows['due_date'];
	$enviarArray['image'] = $sqlGetMember['image'];
	$enviarArray['openTask'] = $taskOpen;
	$enviarArray['horas'] = $horas;
	$enviarArray['minutos'] = $minutos;
	$enviarArray['segundos'] = $segundos;
	
	array_push($array_retorno, $enviarArray);
	
}


echo json_encode($array_retorno);
?>