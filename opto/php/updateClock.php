<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header('Content-Type: text/html; charset=utf-8');


require("../../conexaoPDO.php");

$taskID = $_GET['taskID'];
$horasUpdate = $_GET['horas'];

$horas = date("H", strtotime($horasUpdate));
$minutos = date("i", strtotime($horasUpdate));
$segundos = date("s", strtotime($horasUpdate));

$horasUpdate = $horas.':'.$minutos.':'.$segundos;

$sqlGetProjectID = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM tasks WHERE id = '$taskID'"));
$project_id = $sqlGetProjectID['project_id'];

$sqlGetPlay = mysqli_query($conexao, "UPDATE tasks SET horas = '$horasUpdate' WHERE id = '$taskID'") or die(mysqli_error($conexao));

echo $project_id;

?>