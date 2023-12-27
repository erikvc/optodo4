<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header('Content-Type: text/html; charset=utf-8');


require("../../conexaoPDO.php");

$step_id = $_POST['step_id'];

$getStep = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM steps WHERE id = '$step_id'"));

if($getStep['checked'] == 0){
	$checked = 1;
}else{
	$checked = 0;
}

$sqlGetSteps = mysqli_query($conexao, "UPDATE steps SET checked = '$checked' WHERE id = '$step_id'") or die(mysqli_error($conexao));


echo 'ok';

?>