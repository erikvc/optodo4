<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header('Content-Type: text/html; charset=utf-8');


require("../../conexaoPDO.php");

//VERIFICA SE ESTÁ LOGADO
session_start();
if(!isset($_SESSION['optodo'])){
	header("location:login.php");
}

//PEGA INFORMAÇÕES DO USUARIO****
$atualUserEmail = $_SESSION['optodo'];
$userInfo = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE email = '$atualUserEmail'")) or die(mysqli_error($conexao));
$userID = $userInfo['id'];

$projectID = $_GET['project_id'];

$sqlGetOpen = mysqli_query($conexao, "SELECT * FROM openProjectsEditMode WHERE project_id = '$projectID' AND user_id = '$userID'") or die(mysqli_error($conexao));

$contagem = mysqli_num_rows($sqlGetOpen);

if($contagem != 0){
	mysqli_query($conexao, "DELETE FROM openProjectsEditMode WHERE project_id = '$projectID' AND user_id = '$userID'");
}else{
	mysqli_query($conexao, "INSERT INTO openProjectsEditMode (project_id, user_id)VALUES('$projectID', '$userID')");
}
echo 'ok';

?>