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

	$taskCreateTitle = addslashes($_GET['taskCreateTitle']);
	$taskCreateMember = $_GET['taskCreateMember'];
	$createTaskProjectID = $_GET['createTaskProjectID'];
	$taskCreateDueDate = $_GET['taskCreateDueDate'];

	$sqlInsertTask = mysqli_query($conexao, "INSERT INTO tasks (title, project_id, member_id, due_date)VALUES('$taskCreateTitle', '$createTaskProjectID','$taskCreateMember','$taskCreateDueDate')") or die(mysqli_error($conexao));

	echo 'OK';


?>