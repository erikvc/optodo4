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
	$taskID = $_GET['taskID'];

	$sqlInsertStep = mysqli_query($conexao, "INSERT INTO presets_steps (title, task_id, creation_date)VALUES('$title', '$taskID', NOW())") or die(mysqli_error($conexao));

	echo 'OK';


?>