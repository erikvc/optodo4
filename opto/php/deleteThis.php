<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header('Content-Type: text/html; charset=utf-8');


require("../../conexaoPDO.php");

$tipo = $_GET['tipo'];
$deleteID = $_GET['deleteID'];

if($tipo == 0){
	//DELETAR UM TASK
	$sqlDeleteTask = mysqli_query($conexao, "DELETE FROM tasks WHERE id = '$deleteID'");
}else if($tipo == 1){
	//DELETAR UM STEP
	$sqlDeleteStep = mysqli_query($conexao, "DELETE FROM steps WHERE id = '$deleteID'");
}else if($tipo == 2){
	//ARQUIVAR UM PROJETO
	$sqlArchiveProject = mysqli_query($conexao, "UPDATE projects SET recicle = 1 WHERE id = '$deleteID'");
}
echo 'OK';


?>