<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header('Content-Type: text/html; charset=utf-8');


require("../../conexaoPDO.php");

$project_id = $_GET['projectID'];

$sqlGetprojects = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM projects WHERE id = '$project_id'")) or die(mysqli_error($conexao));

$projectName = $sqlGetprojects['projectName'];
$member = $sqlGetprojects['member'];
$year = $sqlGetprojects['year'];
$client = $sqlGetprojects['client'];
$recicle = $sqlGetprojects['recicle'];
$preset = $sqlGetprojects['preset'];
$due_date = $sqlGetprojects['due_date'];
$creation_date = $sqlGetprojects['creation_date'];

$insertProjectPreset = mysqli_query($conexao, "INSERT INTO presets_projects (projectName, member, year, client, recicle, preset, due_date, creation_date)VALUES('$projectName', '$member', '$year', '$client', 0, '$preset', NOW(), NOW(),)");

?>