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
	$taskID = $_GET['taskID'];
	$dueDate = $_GET['dueDate'];

	$sqlInsertTask = mysqli_query($conexao, "INSERT INTO tasks (title, project_id, member_id, due_date)VALUES('$title', '$taskID', '$member', '$dueDate')") or die(mysqli_error($conexao));

	echo 'OK';


?>