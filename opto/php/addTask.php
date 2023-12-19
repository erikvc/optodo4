<?php

	header('Access-Control-Allow-Origin: *');
	header("Content-type: application/json; charset=utf-8");
	header('Content-Type: text/html; charset=utf-8');

	require("../../conexaoPDO.php");

	$taskCreateTitle = addslashes($_POST['taskCreateTitle']);
	$taskCreateDueDate = $_POST['taskCreateDueDate'];
	$createTaskProjectID = $_POST['createTaskProjectID'];
	$taskCreateDueDate = $_POST['taskCreateDueDate'];

	$sqlInsertTask = mysqli_query($conexao, "INSERT INTO tasks (title, project_id, member_id, due_date)VALUES()");


?>