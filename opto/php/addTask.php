<?php

	header('Access-Control-Allow-Origin: *');
	header("Content-type: application/json; charset=utf-8");
	header('Content-Type: text/html; charset=utf-8');

	require("../../conexaoPDO.php");

	/*
	$taskCreateTitle = addslashes($_POST['taskCreateTitle']);
	$taskCreateMember = $_POST['taskCreateMember'];
	$createTaskProjectID = $_POST['createTaskProjectID'];
	$taskCreateDueDate = $_POST['taskCreateDueDate'];
	*/

	$title = addslashes($_GET['title']);
	$member = $_GET['member'];
	$projectID = $_GET['projectID'];
	$dueDate = $_GET['dueDate'];

	$getProjectInfo = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM projects WHERE id = '$projectID'"));

	$atualProjectTaskNumber = $getProjectInfo['atual_task_number'];
	$taskNumber = $atualProjectTaskNumber+1;

	$sqlInsertTask = mysqli_query($conexao, "INSERT INTO tasks (title, project_id, member_id, number, due_date)VALUES('$title', '$projectID', '$member', '$taskNumber', '$dueDate')") or die(mysqli_error($conexao));

	//UPDATE TASK NUMBER
	$sqlUpdateProjectTaskNumber = mysqli_query($conexao, "UPDATE projects SET atual_task_number = '$taskNumber' WHERE id = '$projectID'");

	echo 'OK';


?>