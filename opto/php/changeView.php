<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header('Content-Type: text/html; charset=utf-8');


require("../../conexaoPDO.php");

session_start();
$atualUserEmail = $_SESSION['optodo'];
$userInfo = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE email = '$atualUserEmail'")) or die(mysqli_error($conexao));
$userID = $userInfo['id'];

//SE TYPE = 0 => MOSTRA TODOS OS PROJETOS
//SE TYPE = 1 => MOSTRA PROJETOS SHARED WITH ME
//SE TYPE = 2 => MOSTRA PROJETOS FILTRADOS POR MEMBRO
//SE TYPE = 3 => MOSTRA PROJETOS FILTRADOS POR CLIENT

$type = $_GET['type'];
$id = $_GET['id'];

if($type == 0){
	$sqlChangeView = mysqli_query($conexao, "UPDATE members SET view = '$type', filter_memberID = '$userID' WHERE id = '$userID'");
}else if($type == 1){
	$sqlChangeView = mysqli_query($conexao, "UPDATE members SET view = '$type', filter_memberID = '$userID' WHERE id = '$userID'");
}else if($type == 2){
	$sqlChangeView = mysqli_query($conexao, "UPDATE members SET view = '$type', filter_memberID = '$id' WHERE id = '$userID'");	
}else if($type == 3){
	$sqlChangeView = mysqli_query($conexao, "UPDATE members SET view = '$type', filter_clientID = '$id' WHERE id = '$userID'");
}
	
	echo 'ok';


?>