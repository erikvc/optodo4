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

	$sqlInsertTask = mysqli_query($conexao, "INSERT INTO presets_tasks (title, project_id, member_id, due_date)VALUES('$title', '$projectID', '$member', '$dueDate')") or die(mysqli_error($conexao));

	echo 'OK';


?>