<?php

function formatTaskTitle(taskID){
    require("../../conexaoPDO.php");
    $sqlGetTask = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM tasks WHERE id = 'taskID'"));
    $projectID = $sqlGetTask['project_id'];
    $sqlGetProject = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM projects WHERE id = '$projectID'"));
    $memberID = $sqlGetProject['member'];
    $sqlGetMember = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE id = '$memberID'"));
    $clientID = $sqlGetProject['client'];
    $sqlGetClient = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM clients WHERE id = '$clientID'"));

    if($sqlGetTask['number'] < 10){
        $formatTaskNumber = '0'.$sqlGetTask['number'];
    }else{
        $formatTaskNumber = $sqlGetTask['number'];
    }

    if($sqlGetProject['number'] < 10){
        $formatProjectNumber = '0'.$sqlGetProject['number'];
    }else{
        $formatProjectNumber = $sqlGetProject['number'];
    }

    return $clientID['abbreviation'].$sqlGetProject['year'].$formatProjectNumber.'T'.$formatTaskNumber;
}

?>