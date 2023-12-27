<?php


function formatProjectName($projectID){
    require("../../conexaoPDO.php");
    $sqlGetProject = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM projects WHERE id = '$projectID'"));
    $clientID = $sqlGetProject['client'];
    $sqlGetClient = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM clients WHERE id = '$clientID'"));

    if($sqlGetProject['number'] < 10){
        $formatProjectNumber = '0'.$sqlGetProject['number'];
    }else{
        $formatProjectNumber = $sqlGetProject['number'];
    }

    return $sqlGetClient['abbreviation'].$sqlGetProject['year'].$formatProjectNumber.'&nbsp;-&nbsp;'.$sqlGetProject['projectName'];
}


function formatTaskTitle($taskID){
    require("../../conexaoPDO.php");
    $sqlGetTask = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM tasks WHERE id = '$taskID'"));
    $projectID = $sqlGetTask['project_id'];
    $sqlGetProject = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM projects WHERE id = '$projectID'"));
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

    return $sqlGetClient['abbreviation'].$sqlGetProject['year'].$formatProjectNumber.'T'.$formatTaskNumber.'&nbsp;-&nbsp;'.$sqlGetTask['title'];
}

?>