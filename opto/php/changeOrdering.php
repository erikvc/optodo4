<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header('Content-Type: text/html; charset=utf-8');


require("../../conexaoPDO.php");

session_start();
$atualUserEmail = $_SESSION['optodo'];
$userInfo = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE email = '$atualUserEmail'")) or die(mysqli_error($conexao));
$userID = $userInfo['id'];

//SE TYPE = 0 => ORDENA POR DATA DE CRIAÇÂO
//SE TYPE = 1 => ORDENA POR PRIORIDADE (BANDEIRINHA)

$type = $_GET['type'];

	$sqlChangeOrdering = mysqli_query($conexao, "UPDATE members SET ordering = '$type' WHERE id = '$userID'");

	echo 'ok';

?>