<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
header('Content-Type: text/html; charset=utf-8');


require("../../conexaoPDO.php");
require("functions.php");

//$project_id = $_GET['userID'];
session_start();
$atualUserEmail = $_SESSION['optodo'];
$userInfo = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE email = '$atualUserEmail'")) or die(mysqli_error($conexao));
$userID = $userInfo['id'];

$memberView = $userInfo['view'];
$memberOrdering = $userInfo['ordering'];
$filter_clientID = $userInfo['filter_clientID'];

$userOrdering = $userInfo['ordering'];

/*

SE VIEW É IGUAL A 0 => MOSTRA TODOS OS PROJETOS
SE VIEW É IGUAL A 1 => MOSTRA PROJETOS SHARED WITH ME
SE VIEW É IGUAL A 2 => MOSTRA PROJETOS FILTRADOS POR MEMBRO
SE VIEW É IGUAL A 3 => MOSTRA PROJETOS FILTRADOS POR CLIENT

*/

if($memberView == 0){

	if($userOrdering == 0){
		$sql = "SELECT * FROM projects WHERE recicle = 0";
	}else if($userOrdering == 1){
		$sql = "SELECT * FROM projects WHERE recicle = 0 ORDER BY priority DESC";
	}

	$sqlGetProjects = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

	$array_retorno = array();

	while($rows = mysqli_fetch_array($sqlGetProjects)){

		$projectID = $rows['id'];
		$memberID = $rows['member'];
		$clientID = $rows['client'];

		$sqlGetOpen = mysqli_query($conexao, "SELECT * FROM openProjects WHERE project_id = '$projectID' AND user_id = '$userID'") or die(mysqli_error($conexao));
		$contagemOpen = mysqli_num_rows($sqlGetOpen);

		if($contagemOpen == 0){
			$projectOpen = 'close';
		}else{
			$projectOpen = 'open';
		}

		$sqlGetMember = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE id = '$memberID'"));
		$sqlGetClient = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM clients WHERE id = '$clientID'"));

		if($rows['number'] < 10){
			$projectNumberFormat = '0'.$rows['number'];
		}else{
			$projectNumberFormat = $rows['number'];
		}
		
		$enviarArray['id'] = $rows['id'];
		$enviarArray['projectName'] = formatProjectName($projectID);
		$enviarArray['member'] = $rows['member'];
		$enviarArray['memberImage'] = $sqlGetMember['image'];
		$enviarArray['number'] = $projectNumberFormat;
		$enviarArray['year'] = $rows['year'];
		$enviarArray['client'] = $rows['client'];
		$enviarArray['clientImage'] = $sqlGetClient['image'];
		$enviarArray['clientAbbreviation'] = $sqlGetClient['abbreviation'];
		$enviarArray['recicle'] = $rows['recicle'];
		$enviarArray['preset'] = $rows['preset'];
		$enviarArray['due_date'] = $rows['due_date'];
		$enviarArray['creation_date'] = $rows['creation_date'];
		$enviarArray['openProject'] = $projectOpen;

		
		array_push($array_retorno, $enviarArray);
		
	}


	echo json_encode($array_retorno);


}else if($memberView == 1){

	if($userOrdering == 0){
		$sql = "SELECT * FROM projects WHERE recicle = 0";
	}else if($userOrdering == 1){
		$sql = "SELECT * FROM projects WHERE recicle = 0 ORDER BY priority DESC";
	}

	$sqlGetProjects = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

	$array_retorno = array();

	while($rows = mysqli_fetch_array($sqlGetProjects)){

		$projectID = $rows['id'];
		$memberID = $rows['member'];
		$clientID = $rows['client'];

		$sqlFindTasks = mysqli_query($conexao, "SELECT * FROM tasks WHERE project_id = '$projectID' AND member_id = '$userID'")or die(mysqli_error($conexao));

		if($sqlFindTasks){
			$contagemFindTasks = mysqli_num_rows($sqlFindTasks);

			if($contagemFindTasks != 0 OR $memberID == $userID){

				$sqlGetOpen = mysqli_query($conexao, "SELECT * FROM openProjects WHERE project_id = '$projectID' AND user_id = '$userID'") or die(mysqli_error($conexao));
				$contagemOpen = mysqli_num_rows($sqlGetOpen);
	
				if($contagemOpen == 0){
					$projectOpen = 'close';
				}else{
					$projectOpen = 'open';
				}
	
				$sqlGetMember = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE id = '$memberID'"));
				$sqlGetClient = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM clients WHERE id = '$clientID'"));
	
				if($rows['number'] < 10){
					$projectNumberFormat = '0'.$rows['number'];
				}else{
					$projectNumberFormat = $rows['number'];
				}
				
				$enviarArray['id'] = $rows['id'];
				$enviarArray['projectName'] = formatProjectName($projectID);
				$enviarArray['member'] = $rows['member'];
				$enviarArray['memberImage'] = $sqlGetMember['image'];
				$enviarArray['number'] = $projectNumberFormat;
				$enviarArray['year'] = $rows['year'];
				$enviarArray['client'] = $rows['client'];
				$enviarArray['clientImage'] = $sqlGetClient['image'];
				$enviarArray['clientAbbreviation'] = $sqlGetClient['abbreviation'];
				$enviarArray['recicle'] = $rows['recicle'];
				$enviarArray['preset'] = $rows['preset'];
				$enviarArray['due_date'] = $rows['due_date'];
				$enviarArray['creation_date'] = $rows['creation_date'];
				$enviarArray['openProject'] = $projectOpen;
	
				
				array_push($array_retorno, $enviarArray);
			}
		}

		
	}

	echo json_encode($array_retorno);

}else if($memberView == 2){

	if($userOrdering == 0){
		$sql = "SELECT * FROM projects WHERE recicle = 0";
	}else if($userOrdering == 1){
		$sql = "SELECT * FROM projects WHERE recicle = 0 ORDER BY priority DESC";
	}
		
	$sqlGetProjects = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

	$array_retorno = array();

	while($rows = mysqli_fetch_array($sqlGetProjects)){

		$projectID = $rows['id'];
		$memberID = $rows['member'];
		$clientID = $rows['client'];

		$sqlFindTasks = mysqli_query($conexao, "SELECT * FROM tasks WHERE project_id = '$projectID'") or die(mysqli_error($conexao));
		$contagemFindTasks = mysqli_num_rows($sqlFindTasks);

		if($contagemFindTasks != 0){

			$sqlGetOpen = mysqli_query($conexao, "SELECT * FROM openProjects WHERE project_id = '$projectID' AND user_id = '$userID'") or die(mysqli_error($conexao));
			$contagemOpen = mysqli_num_rows($sqlGetOpen);

			if($contagemOpen == 0){
				$projectOpen = 'close';
			}else{
				$projectOpen = 'open';
			}

			$sqlGetMember = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE id = '$memberID'"));
			$sqlGetClient = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM clients WHERE id = '$clientID'"));

			if($rows['number'] < 10){
				$projectNumberFormat = '0'.$rows['number'];
			}else{
				$projectNumberFormat = $rows['number'];
			}
			
			$enviarArray['id'] = $rows['id'];
			$enviarArray['projectName'] = formatProjectName($projectID);
			$enviarArray['member'] = $rows['member'];
			$enviarArray['memberImage'] = $sqlGetMember['image'];
			$enviarArray['number'] = $projectNumberFormat;
			$enviarArray['year'] = $rows['year'];
			$enviarArray['client'] = $rows['client'];
			$enviarArray['clientImage'] = $sqlGetClient['image'];
			$enviarArray['clientAbbreviation'] = $sqlGetClient['abbreviation'];
			$enviarArray['recicle'] = $rows['recicle'];
			$enviarArray['preset'] = $rows['preset'];
			$enviarArray['due_date'] = $rows['due_date'];
			$enviarArray['creation_date'] = $rows['creation_date'];
			$enviarArray['openProject'] = $projectOpen;

			
			array_push($array_retorno, $enviarArray);
		}
		
		
	}

	echo json_encode($array_retorno);

}else if($memberView == 3){
		
	$sql = "SELECT * FROM projects WHERE recicle = 0 AND client = '$filter_clientID'".$ordering;

	$sqlGetProjects = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

	$array_retorno = array();

	while($rows = mysqli_fetch_array($sqlGetProjects)){

		$projectID = $rows['id'];
		$memberID = $rows['member'];
		$clientID = $rows['client'];


			$sqlGetOpen = mysqli_query($conexao, "SELECT * FROM openProjects WHERE project_id = '$projectID' AND user_id = '$userID'") or die(mysqli_error($conexao));
			$contagemOpen = mysqli_num_rows($sqlGetOpen);

			if($contagemOpen == 0){
				$projectOpen = 'close';
			}else{
				$projectOpen = 'open';
			}

			$sqlGetMember = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE id = '$memberID'"));
			$sqlGetClient = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM clients WHERE id = '$clientID'"));

			if($rows['number'] < 10){
				$projectNumberFormat = '0'.$rows['number'];
			}else{
				$projectNumberFormat = $rows['number'];
			}
			
			$enviarArray['id'] = $rows['id'];
			$enviarArray['projectName'] = formatProjectName($projectID);
			$enviarArray['member'] = $rows['member'];
			$enviarArray['memberImage'] = $sqlGetMember['image'];
			$enviarArray['number'] = $projectNumberFormat;
			$enviarArray['year'] = $rows['year'];
			$enviarArray['client'] = $rows['client'];
			$enviarArray['clientImage'] = $sqlGetClient['image'];
			$enviarArray['clientAbbreviation'] = $sqlGetClient['abbreviation'];
			$enviarArray['recicle'] = $rows['recicle'];
			$enviarArray['preset'] = $rows['preset'];
			$enviarArray['due_date'] = $rows['due_date'];
			$enviarArray['creation_date'] = $rows['creation_date'];
			$enviarArray['openProject'] = $projectOpen;

			
			array_push($array_retorno, $enviarArray);		
		
	}

	echo json_encode($array_retorno);

}




?>