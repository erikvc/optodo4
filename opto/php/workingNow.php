<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header('Content-Type: text/html; charset=utf-8');


require("../../conexaoPDO.php");

$sqlGetWorkingNow = mysqli_query($conexao, "SELECT * FROM tasks WHERE play = 1") or die(mysqli_error($conexao));

$array_retorno = array();

while($rows=mysqli_fetch_array($sqlGetWorkingNow)){

	$memberID = $rows['member_id'];
	$project_id = $rows['project_id'];

	$sqlGetMember = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE id = '$memberID'"));
	$sqlGetProject = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM projects WHERE id = '$project_id'"));
	$clientID = $sqlGetProject['client'];
	$sqlGetClient = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM clients WHERE id = '$clientID'"));

	if($sqlGetProject['number'] < 10){
		$projectNumberFormat = '0'.$sqlGetProject['number'];
	}else{
		$projectNumberFormat = $sqlGetProject['number'];
	}
	$enviarArray['projectYear'] = $sqlGetProject['year'];
	$enviarArray['projectNumber'] = $projectNumberFormat;
	$enviarArray['clientAbbreviation'] = $sqlGetClient['abbreviation'];
	$enviarArray['memberImage'] = $sqlGetMember['image'];
	$enviarArray['memberFname'] = $sqlGetMember['fname'];
	$enviarArray['memberLname'] = $sqlGetMember['lname'];


	array_push($array_retorno, $enviarArray);
}

echo json_encode($array_retorno);

?>