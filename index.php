<?php

require("conexaoPDO.php");

//VERIFICA SE ESTÁ LOGADO
session_start();
if(!isset($_SESSION['optodo'])){
	header("location:login.php");
}

//PEGA INFORMAÇÕES DO USUARIO****
$atualUserEmail = $_SESSION['optodo'];
$userInfo = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE email = '$atualUserEmail'")) or die(mysqli_error($conexao));
$userID = $userInfo['id'];

//LOGOUT*************************************************
if(isset($_GET['logout']) && $_GET['logout'] == 'ok'):
	unset($_SESSION['optodo']);
	session_destroy();
	header('location:login.php');
endif;

/*****************EDIT MEMBER***************************** */
if(isset($_POST['editMember'])){
	//echo '<script>alert("'.$_POST['fname'].'")</script>';
	$fname = trim($_POST['fname']);
	$lname = trim($_POST['lname']);
	$email = trim($_POST['email']);
	$password = md5($_POST['password']);

	$sqlPegaImagemAnterior = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE id = '$userID'"));
                

				$tiposPermitidos= array('jpeg', 'jpg', 'png');
				
				
				if (array_search($imagesType, $tiposPermitidos) != true){

					$images = $_FILES['imagem']['name'];
					if($images && $images != ''){
						$imagesType    = $_FILES['imagem']['type'];
						$rand	   = rand();
						$errorUpload = 'N';
					
						$images = str_replace("'", "", $images);
						$imgFileName = $rand.$images;
						$path 		 = 'opto/image/members/temp/'.$imgFileName;

						move_uploaded_file($_FILES['imagem']['tmp_name'], $path);

						include("resize-class.php");
						$resizeObj = new resize('opto/image/members/temp/'.$imgFileName);
						$resizeObj -> resizeImage(200, 200, 'crop');
						$resizeObj -> saveImage('opto/image/members/'.$imgFileName, 100);
					}
					

					$sqlUpdateMember = "UPDATE members SET fname='$fname', lname='$lname', email='$email'";

					if($images && $images != '')  {
						$sqlUpdateMember.=",image = '$imgFileName' ";
						$removeImagemAnterior = unlink('opto/image/members/'.$sqlPegaImagemAnterior['image']);
					}

					if($_POST['password'] != ''){
						$sqlUpdateMember.=",password='$password' ";
					}

					$sqlUpdateMember.="  WHERE id = '$userID'";
					mysqli_query($conexao, $sqlUpdateMember) or die(mysqli_error($conexao));

					$removeTemp = unlink('opto/image/members/temp/'.$imgFileName);
					

					echo '<script>window.location.href="index.php"</script>';
				}else{
					echo '<script>alert(File Not Allowed!)</script>';
					echo '<script>window.location.href="index.php"</script>';
				}
}

/***************CREATE CLIENT*********** */
if(isset($_POST['createClient'])){
	$clientCreateName = $_POST['clientCreateName'];
	$clientCreateAbbreviation = $_POST['clientCreateAbbreviation'];
	$clientCreateEmail = $_POST['clientCreateEmail'];

			$tiposPermitidos= array('jpeg', 'jpg', 'png');
			$images    = $_FILES['imagem']['name'];
			$imagesType    = $_FILES['imagem']['type'];
			$rand	   = rand();
			$errorUpload = 'N';

			$sqlVerificaEmailExiste = mysqli_query($conexao, "SELECT * FROM clients WHERE email = '$email'");
			$contagemVerificaEmailExiste = mysqli_num_rows($sqlVerificaEmailExiste);
			
			if (array_search($imagesType, $tiposPermitidos) != false) {
					echo 'File Not Allowed!';
			}else if($contagemVerificaEmailExiste != 0){
				echo 'This Client Already Exists!';
			}
			else{
				$images = str_replace("'", "", $images);
				$imgFileName = $rand.$images;
				$path 		 = 'opto/image/clients/temp/'.$imgFileName;

				move_uploaded_file($_FILES['imagem']['tmp_name'], $path);
					
				include("resize-class.php");
				$resizeObj = new resize('opto/image/clients/temp/'.$imgFileName);
				$resizeObj -> resizeImage(200, 200, 'crop');
				$resizeObj -> saveImage('opto/image/clients/'.$imgFileName, 100);
					
				$sqlPegaTasks = mysqli_query($conexao, "INSERT INTO clients (name, abbreviation, email, image, creation_date)VALUES('$clientCreateName', '$clientCreateAbbreviation', '$clientCreateEmail', '$imgFileName', NOW())") or die(mysqli_error($conexao));
					
				$removeTemp = unlink('opto/image/clients/temp/'.$imgFileName);
					
				echo '<script>window.location.href="index.php"</script>';
			}
}

/***************CREATE PROJECT*********** */
if(isset($_POST['createProject'])){
	$projectCreateName = addslashes($_POST['projectCreateName']);
	$projectCreateMember = $_POST['projectCreateMember'];
	$projectCreateClient = $_POST['projectCreateClient'];
	$projectCreatePreset = $_POST['projectCreatePreset'];
	$projectCreateDueDate = date("Y-m-d", strtotime($_POST['projectCreateDueDate']));
	//echo '<script>alert("'.$projectCreateName.'")</script>';


	$sqlGetCurrentYear = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM config WHERE id = 1"));

	$currentYearOptodo = $sqlGetCurrentYear['currentYear'];
	//echo '<script>alert("'.$currentYearOptodo.'")</script>';
	$currentYearHost = date("Y");

	$sqlGetMemberInfo = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM members WHERE id = '$projectCreateMember'"));
	$clientAbbreviation = $sqlGetMemberInfo['abbreviation'];


	if($currentYearHost != $currentYearOptodo){
		$sqlUpdateCurrentYear = mysqli_query($conexao, "UPDATE config SET currentYear='$currentYearHost' WHERE id = 1");
		$sqlUpdateClientsNumber = mysqli_query($conexao, "UPDATE clients SET number='$updatedClientNumber'");
	}

	//PEGA CLIENT INFO
	$sqlGetClientInfo = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM clients WHERE id = '$projectCreateClient'"));

	$currentYear = date("y");

	$updatedClientNumber = $sqlGetClientInfo['number']+1;
	
	$sqlUpdateClientNumber = mysqli_query($conexao, "UPDATE clients SET number='$updatedClientNumber' WHERE id = '$projectCreateClient'");

	$sqlCreateProject = mysqli_query($conexao, "INSERT INTO projects (projectName, number, year, member, client, preset, due_date, creation_date)VALUES('$projectCreateName', '$updatedClientNumber', '$currentYear', '$projectCreateMember', '$projectCreateClient', '$projectCreatePreset', '$projectCreateDueDate', NOW())") or die(mysqli_error($conexao));


	echo '<script>window.location.href="index.php"</script>';

}


?>
<!doctype html>
<html class="fixed dark">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>OPTODO 4.0</title>

		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="vendor/animate/animate.compat.css">
		<link rel="stylesheet" href="vendor/font-awesome/css/all.min.css" />
		<link rel="stylesheet" href="vendor/boxicons/css/boxicons.min.css" />
		<link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />
		<link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.css" />
		<link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.theme.css" />
		<link rel="stylesheet" href="vendor/bootstrap-multiselect/css/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="vendor/morris/morris.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="css/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="css/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="css/custom.css">

		<!-- OPTO CSS -->
		<link rel="stylesheet" href="opto/css/opto.css">
		<script src="opto/js/opto.js"></script>

		<!-- Head Libs -->
		<script src="vendor/modernizr/modernizr.js"></script>

	</head>
	<body>
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="index.php" class="logo">
						<img src="img/logo.png" width="75" height="35" alt="Porto Admin" />
					</a>

					<div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fas fa-bars" aria-label="Toggle sidebar"></i>
					</div>

				</div>

				<!-- start: search & user box -->
				<div class="header-right">

					<span class="separator"></span>

					<ul class="notifications">
						<li>
							<a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
								<i class="bx bx-list-ol"></i>
								<span class="badge">3</span>
							</a>

							<div class="dropdown-menu notification-menu large">
								<div class="notification-title">
									<span class="float-end badge badge-default">3</span>
									Tasks
								</div>

								<div class="content">
									<ul>
										<li>
											<p class="clearfix mb-1">
												<span class="message float-start">Generating Sales Report</span>
												<span class="message float-end text-dark">60%</span>
											</p>
											<div class="progress progress-xs light">
												<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
											</div>
										</li>

										<li>
											<p class="clearfix mb-1">
												<span class="message float-start">Importing Contacts</span>
												<span class="message float-end text-dark">98%</span>
											</p>
											<div class="progress progress-xs light">
												<div class="progress-bar" role="progressbar" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100" style="width: 98%;"></div>
											</div>
										</li>

										<li>
											<p class="clearfix mb-1">
												<span class="message float-start">Uploading something big</span>
												<span class="message float-end text-dark">33%</span>
											</p>
											<div class="progress progress-xs light mb-1">
												<div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%;"></div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
								<i class="bx bx-envelope"></i>
								<span class="badge">4</span>
							</a>

							<div class="dropdown-menu notification-menu">
								<div class="notification-title">
									<span class="float-end badge badge-default">230</span>
									Messages
								</div>

								<div class="content">
									<ul>
										<li>
											<a href="#" class="clearfix">
												<figure class="image">
													<img src="opto/image/members/<?php echo $userInfo['image']; ?>" alt="<?php echo $userInfo['fname'].'&nbsp;'.$userInfo['lname']; ?>" class="rounded-circle" />
												</figure>
												<span class="title">Joseph Doe</span>
												<span class="message">Lorem ipsum dolor sit.</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<figure class="image">
													<img src="opto/image/members/<?php echo $userInfo['image']; ?>" alt="<?php echo $userInfo['fname'].'&nbsp;'.$userInfo['lname']; ?>" class="rounded-circle" />
												</figure>
												<span class="title">Joseph Junior</span>
												<span class="message truncate">Truncated message. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet lacinia orci. Proin vestibulum eget risus non luctus. Nunc cursus lacinia lacinia. Nulla molestie malesuada est ac tincidunt. Quisque eget convallis diam, nec venenatis risus. Vestibulum blandit faucibus est et malesuada. Sed interdum cursus dui nec venenatis. Pellentesque non nisi lobortis, rutrum eros ut, convallis nisi. Sed tellus turpis, dignissim sit amet tristique quis, pretium id est. Sed aliquam diam diam, sit amet faucibus tellus ultricies eu. Aliquam lacinia nibh a metus bibendum, eu commodo eros commodo. Sed commodo molestie elit, a molestie lacus porttitor id. Donec facilisis varius sapien, ac fringilla velit porttitor et. Nam tincidunt gravida dui, sed pharetra odio pharetra nec. Duis consectetur venenatis pharetra. Vestibulum egestas nisi quis elementum elementum.</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<figure class="image">
													<img src="img/!sample-user.jpg" alt="Joe Junior" class="rounded-circle" />
												</figure>
												<span class="title">Joe Junior</span>
												<span class="message">Lorem ipsum dolor sit.</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<figure class="image">
													<img src="img/!sample-user.jpg" alt="Joseph Junior" class="rounded-circle" />
												</figure>
												<span class="title">Joseph Junior</span>
												<span class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet lacinia orci. Proin vestibulum eget risus non luctus. Nunc cursus lacinia lacinia. Nulla molestie malesuada est ac tincidunt. Quisque eget convallis diam.</span>
											</a>
										</li>
									</ul>

									<hr />

									<div class="text-end">
										<a href="#" class="view-more">View All</a>
									</div>
								</div>
							</div>
						</li>
						<li>
							<a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
								<i class="bx bx-bell"></i>
								<span class="badge">3</span>
							</a>

							<div class="dropdown-menu notification-menu">
								<div class="notification-title">
									<span class="float-end badge badge-default">3</span>
									Alerts
								</div>

								<div class="content">
									<ul>
										<li>
											<a href="#" class="clearfix">
												<div class="image">
													<i class="fas fa-thumbs-down bg-danger text-light"></i>
												</div>
												<span class="title">Server is Down!</span>
												<span class="message">Just now</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<div class="image">
													<i class="bx bx-lock bg-warning text-light"></i>
												</div>
												<span class="title">User Locked</span>
												<span class="message">15 minutes ago</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<div class="image">
													<i class="fas fa-signal bg-success text-light"></i>
												</div>
												<span class="title">Connection Restaured</span>
												<span class="message">10/10/2021</span>
											</a>
										</li>
									</ul>

									<hr />

									<div class="text-end">
										<a href="#" class="view-more">View All</a>
									</div>
								</div>
							</div>
						</li>
					</ul>

					<span class="separator"></span>

					<div id="userbox" class="userbox">
						<a href="#" data-bs-toggle="dropdown">
							<figure class="profile-picture">
								<img src="opto/image/members/<?php echo $userInfo['image']; ?>" alt="<?php echo $userInfo['fname'].'&nbsp;'.$userInfo['lname']; ?>" class="rounded-circle" data-lock-picture="opto/image/members/<?php echo $userInfo['image']; ?>" />
							</figure>
							<div class="profile-info" data-lock-name="<?php echo $userInfo['fname'].'&nbsp;'.$userInfo['lname']; ?>e" data-lock-email="<?php echo $userInfo['email']; ?>">
								<span class="name"><?php echo $userInfo['fname'].'&nbsp;'.$userInfo['lname']; ?></span>
								<span class="role">Member</span>
							</div>

							<i class="fa custom-caret"></i>
						</a>

						<div class="dropdown-menu">
							<ul class="list-unstyled mb-2">
								<li class="divider"></li>
								<li>
									<a class="modal-with-form" role="menuitem" tabindex="-1" href="#opto-edit-member"><i class="bx bx-user-circle"></i> My Profile</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="?logout=ok"><i class="bx bx-power-off modal-basic"></i> Logout</a>
								</li>
							</ul>
						</div>


					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">

				    <div class="sidebar-header">
				        <div class="sidebar-title">
				            Navigation
				        </div>
				        <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
				            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
				        </div>
				    </div>

				    <div class="nano">
				        <div class="nano-content">
				            <nav id="menu" class="nav-main" role="navigation">

				                <ul class="nav nav-main">
				                    <li>
				                        <a class="nav-link modal-with-form" href="#opto-create-client">
				                            <i class="bx bx-home-alt" aria-hidden="true"></i>
				                            <span>Dashboard</span>
				                        </a>                        
				                    </li>
									<li>
				                        <a class="modal-with-form nav-link" href="#opto-create-client">
											<i class="fa-solid fa-users"></i>
				                            <span>Create Member</span>
				                        </a>                        
				                    </li>
									<li>
				                        <a class="modal-with-form nav-link" href="#opto-create-project">
											<i class="fa-solid fa-users"></i>
				                            <span>Create Project</span>
				                        </a>                        
				                    </li>
				                    <li class="nav-parent">
				                        <a class="nav-link" href="#">
				                            <i class="bx bx-cart-alt" aria-hidden="true"></i>
				                            <span>eCommerce</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="ecommerce-dashboard.html">
				                                    Dashboard
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ecommerce-products-list.html">
				                                    Products List
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ecommerce-products-form.html">
				                                    Products Form
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ecommerce-category-list.html">
				                                    Categories List
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ecommerce-category-form.html">
				                                    Category Form
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ecommerce-coupons-list.html">
				                                    Coupons List
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ecommerce-coupons-form.html">
				                                    Coupons Form
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ecommerce-orders-list.html">
				                                    Orders List
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ecommerce-orders-detail.html">
				                                    Orders Detail
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ecommerce-customers-list.html">
				                                    Customers List
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ecommerce-customers-form.html">
				                                    Customers Form
				                                </a>
				                            </li>
				                        </ul>
				                    </li>
				                    <li>
				                        <a class="nav-link" href="mailbox-folder.html">
				                            <span class="float-end badge badge-primary">182</span>
				                            <i class="bx bx-envelope" aria-hidden="true"></i>
				                            <span>Mailbox</span>
				                        </a>                        
				                    </li>
				                    <li class="nav-parent nav-expanded nav-active">
				                        <a class="nav-link" href="#">
				                            <i class="bx bx-layout" aria-hidden="true"></i>
				                            <span>Layouts</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="index.html">
				                                    Landing Page
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="layouts-default.html">
				                                    Default
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="layouts-modern.html">
				                                    Modern
				                                </a>
				                            </li>
				                            <li class="nav-parent">
				                                <a>
				                                    Boxed
				                                </a>
				                                <ul class="nav nav-children">
				                                    <li>
				                                        <a class="nav-link" href="layouts-boxed.html">
				                                            Static Header
				                                        </a>
				                                    </li>
				                                    <li>
				                                        <a class="nav-link" href="layouts-boxed-fixed-header.html">
				                                            Fixed Header
				                                        </a>
				                                    </li>
				                                </ul>
				                            </li>
				                            <li class="nav-parent">
				                                <a>
				                                    Horizontal Menu Header
				                                </a>
				                                <ul class="nav nav-children">
				                                    <li>
				                                        <a class="nav-link" href="layouts-header-menu.html">
				                                            Pills
				                                        </a>
				                                    </li>
				                                    <li>
				                                        <a class="nav-link" href="layouts-header-menu-stripe.html">
				                                            Stripe
				                                        </a>
				                                    </li>
				                                    <li>
				                                        <a class="nav-link" href="layouts-header-menu-top-line.html">
				                                            Top Line
				                                        </a>
				                                    </li>
				                                </ul>
				                            </li>
				                            <li class="nav-active">
				                                <a class="nav-link" href="layouts-dark.html">
				                                    Dark
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="layouts-dark-header.html">
				                                    Dark Header
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="layouts-two-navigations.html">
				                                    Two Navigations
				                                </a>
				                            </li>
				                            <li class="nav-parent">
				                                <a>
				                                    Tab Navigation
				                                </a>
				                                <ul class="nav nav-children">
				                                    <li>
				                                        <a class="nav-link" href="layouts-tab-navigation-dark.html">
				                                            Tab Navigation Dark
				                                        </a>
				                                    </li>
				                                    <li>
				                                        <a class="nav-link" href="layouts-tab-navigation.html">
				                                            Tab Navigation Light
				                                        </a>
				                                    </li>
				                                    <li>
				                                        <a class="nav-link" href="layouts-tab-navigation-boxed.html">
				                                            Tab Navigation Boxed
				                                        </a>
				                                    </li>
				                                </ul>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="layouts-light-sidebar.html">
				                                    Light Sidebar
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="layouts-left-sidebar-collapsed.html">
				                                    Left Sidebar Collapsed
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="layouts-left-sidebar-scroll.html">
				                                    Left Sidebar Scroll
				                                </a>
				                            </li>
				                            <li class="nav-parent">
				                                <a>
				                                    Left Sidebar Big Icons
				                                </a>
				                                <ul class="nav nav-children">
				                                    <li>
				                                        <a class="nav-link" href="layouts-left-sidebar-big-icons.html">
				                                            Left Sidebar Big Icons Dark
				                                        </a>
				                                    </li>
				                                    <li>
				                                        <a class="nav-link" href="layouts-left-sidebar-big-icons-light.html">
				                                            Left Sidebar Big Icons Light
				                                        </a>
				                                    </li>
				                                </ul>
				                            </li>
				                            <li class="nav-parent">
				                                <a>
				                                    Left Sidebar Panel
				                                </a>
				                                <ul class="nav nav-children">
				                                    <li>
				                                        <a class="nav-link" href="layouts-left-sidebar-panel.html">
				                                            Left Sidebar Panel Dark
				                                        </a>
				                                    </li>
				                                    <li>
				                                        <a class="nav-link" href="layouts-left-sidebar-panel-light.html">
				                                            Left Sidebar Panel Light
				                                        </a>
				                                    </li>
				                                </ul>
				                            </li>
				                            <li class="nav-parent">
				                                <a>
				                                    Left Sidebar Sizes
				                                </a>
				                                <ul class="nav nav-children">
				                                    <li>
				                                        <a class="nav-link" href="layouts-sidebar-sizes-xs.html">
				                                            Left Sidebar XS
				                                        </a>
				                                    </li>
				                                    <li>
				                                        <a class="nav-link" href="layouts-sidebar-sizes-sm.html">
				                                            Left Sidebar SM
				                                        </a>
				                                    </li>
				                                    <li>
				                                        <a class="nav-link" href="layouts-sidebar-sizes-md.html">
				                                            Left Sidebar MD
				                                        </a>
				                                    </li>
				                                </ul>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="layouts-square-borders.html">
				                                    Square Borders
				                                </a>
				                            </li>
				                        </ul>
				                    </li>
				                    <li class="nav-parent">
				                        <a class="nav-link" href="#">
				                            <i class="bx bx-file" aria-hidden="true"></i>
				                            <span>Pages</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="pages-signup.html">
				                                    Sign Up
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="pages-signin.html">
				                                    Sign In
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="pages-recover-password.html">
				                                    Recover Password
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="pages-lock-screen.html">
				                                    Locked Screen
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="pages-user-profile.html">
				                                    User Profile
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="pages-session-timeout.html">
				                                    Session Timeout
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="pages-calendar.html">
				                                    Calendar
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="pages-timeline.html">
				                                    Timeline
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="pages-media-gallery.html">
				                                    Media Gallery
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="pages-invoice.html">
				                                    Invoice
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="pages-blank.html">
				                                    Blank Page
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="pages-404.html">
				                                    404
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="pages-500.html">
				                                    500
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="pages-log-viewer.html">
				                                    Log Viewer
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="pages-search-results.html">
				                                    Search Results
				                                </a>
				                            </li>
				                        </ul>
				                    </li>
				                    <li class="nav-parent">
				                        <a class="nav-link" href="#">
				                            <i class="bx bx-cube" aria-hidden="true"></i>
				                            <span>UI Elements</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="ui-elements-typography.html">
				                                    Typography
				                                </a>
				                            </li>
				                            <li class="nav-parent">
				                                <a class="nav-link" href="#">
				                                    Icons <span class="mega-sub-nav-toggle toggled float-end" data-toggle="collapse" data-target=".mega-sub-nav-sub-menu-1"></span>
				                                </a>
				                                <ul class="nav nav-children">
				                                    <li>
				                                        <a class="nav-link" href="ui-elements-icons-elusive.html">
				                                            Elusive
				                                        </a>
				                                    </li>
				                                    <li>
				                                        <a class="nav-link" href="ui-elements-icons-font-awesome.html">
				                                            Font Awesome
				                                        </a>
				                                    </li>
				                                    <li>
				                                        <a class="nav-link" href="ui-elements-icons-line-icons.html">
				                                            Line Icons
				                                        </a>
				                                    </li>
				                                    <li>
				                                        <a class="nav-link" href="ui-elements-icons-meteocons.html">
				                                            Meteocons
				                                        </a>
				                                    </li>
				                                    <li>
				                                        <a class="nav-link" href="ui-elements-icons-box-icons.html">
				                                            Box Icons
				                                        </a>
				                                    </li>
				                                </ul>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-tabs.html">
				                                    Tabs
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-cards.html">
				                                    Cards
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-widgets.html">
				                                    Widgets
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-portlets.html">
				                                    Portlets
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-buttons.html">
				                                    Buttons
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-alerts.html">
				                                    Alerts
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-notifications.html">
				                                    Notifications
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-modals.html">
				                                    Modals
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-lightbox.html">
				                                    Lightbox
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-progressbars.html">
				                                    Progress Bars
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-sliders.html">
				                                    Sliders
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-carousels.html">
				                                    Carousels
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-accordions.html">
				                                    Accordions
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-toggles.html">
				                                    Toggles
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-nestable.html">
				                                    Nestable
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-tree-view.html">
				                                    Tree View
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-scrollable.html">
				                                    Scrollable
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-grid-system.html">
				                                    Grid System
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-charts.html">
				                                    Charts
				                                </a>
				                            </li>
				                            <li class="nav-parent">
				                                <a class="nav-link" href="#">
				                                    Animations <span class="mega-sub-nav-toggle toggled float-end" data-toggle="collapse" data-target=".mega-sub-nav-sub-menu-2"></span>
				                                </a>
				                                <ul class="nav nav-children">
				                                    <li>
				                                        <a class="nav-link" href="ui-elements-animations-appear.html">
				                                            Appear
				                                        </a>
				                                    </li>
				                                    <li>
				                                        <a class="nav-link" href="ui-elements-animations-hover.html">
				                                            Hover
				                                        </a>
				                                    </li>
				                                </ul>
				                            </li>
				                            <li class="nav-parent">
				                                <a class="nav-link" href="#">
				                                    Loading <span class="mega-sub-nav-toggle toggled float-end" data-toggle="collapse" data-target=".mega-sub-nav-sub-menu-3"></span>
				                                </a>
				                                <ul class="nav nav-children">
				                                    <li>
				                                        <a class="nav-link" href="ui-elements-loading-overlay.html">
				                                            Overlay
				                                        </a>
				                                    </li>
				                                    <li>
				                                        <a class="nav-link" href="ui-elements-loading-progress.html">
				                                            Progress
				                                        </a>
				                                    </li>
				                                </ul>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="ui-elements-extra.html">
				                                    Extra
				                                </a>
				                            </li>
				                        </ul>
				                    </li>
				                    <li class="nav-parent">
				                        <a class="nav-link" href="#">
				                            <i class="bx bx-map" aria-hidden="true"></i>
				                            <span>Maps</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="maps-google-maps.html">
				                                    Basic
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="maps-google-maps-builder.html">
				                                    Map Builder
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="maps-vector.html">
				                                    Vector
				                                </a>
				                            </li>
				                        </ul>
				                    </li>
				                    <li>
				                        <a class="nav-link" href="extra-ajax-made-easy.html">
				                            <i class="bx bx-loader-circle" aria-hidden="true"></i>
				                            <span>Ajax</span>
				                        </a>                        
				                    </li>
				                    <li class="nav-parent">
				                        <a class="nav-link" href="#">
				                            <i class="bx bx-detail" aria-hidden="true"></i>
				                            <span>Forms</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="forms-basic.html">
				                                    Basic
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="forms-advanced.html">
				                                    Advanced
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="forms-validation.html">
				                                    Validation
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="forms-layouts.html">
				                                    Layouts
				                                </a>
				                            </li>
				                        </ul>
				                    </li>
				                    <li class="nav-parent">
				                        <a class="nav-link" href="#">
				                            <i class="bx bx-table" aria-hidden="true"></i>
				                            <span>Tables</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="tables-basic.html">
				                                    Basic
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="tables-advanced.html">
				                                    Advanced
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="tables-responsive.html">
				                                    Responsive
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="tables-editable.html">
				                                    Editable
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="tables-ajax.html">
				                                    Ajax
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="tables-pricing.html">
				                                    Pricing
				                                </a>
				                            </li>
				                        </ul>
				                    </li>
				                    <li class="nav-parent">
				                        <a class="nav-link" href="#">
				                            <i class="bx bx-collection" aria-hidden="true"></i>
				                            <span>Menu Levels</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a>
				                                    First Level
				                                </a>
				                            </li>
				                            <li class="nav-parent">
				                                <a class="nav-link" href="#">
				                                    Second Level
				                                </a>
				                                <ul class="nav nav-children">
				                                    <li>
				                                        <a>
				                                            Second Level Link #1
				                                        </a>
				                                    </li>
				                                    <li>
				                                        <a>
				                                            Second Level Link #2
				                                        </a>
				                                    </li>
				                                    <li class="nav-parent">
				                                        <a class="nav-link" href="#">
				                                            Third Level
				                                        </a>
				                                        <ul class="nav nav-children">
				                                            <li>
				                                                <a>
				                                                    Third Level Link #1
				                                                </a>
				                                            </li>
				                                            <li>
				                                                <a>
				                                                    Third Level Link #2
				                                                </a>
				                                            </li>
				                                        </ul>
				                                    </li>
				                                </ul>
				                            </li>
				                        </ul>
				                    </li>
				                    <li>
				                        <a class="nav-link" href="http://themeforest.net/item/porto-responsive-html5-template/4106987?ref=Okler">
				                            <i class="bx bx-window-alt" aria-hidden="true"></i>
				                            <span>Front-End <em class="not-included">(Not Included)</em></span>
				                        </a>                        
				                    </li>
				                    <li>
				                        <a class="nav-link" href="https://www.okler.net/forums/topic/porto-admin-changelog/">
				                            <i class="bx bx-book-alt" aria-hidden="true"></i>
				                            <span>Changelog</span>
				                        </a>                        
				                    </li>

				                </ul>
				            </nav>

				            <hr class="separator" />

				            <div class="sidebar-widget widget-tasks">
				                <div class="widget-header">
				                    <h6>Projects</h6>
				                    <div class="widget-toggle">+</div>
				                </div>
				                <div class="widget-content">
				                    <ul class="list-unstyled m-0">
				                        <li><a href="#">Porto HTML5 Template</a></li>
				                        <li><a href="#">Tucson Template</a></li>
				                        <li><a href="#">Porto Admin</a></li>
				                    </ul>
				                </div>
				            </div>

				            <hr class="separator" />

				            <div class="sidebar-widget widget-stats">
				                <div class="widget-header">
				                    <h6>Company Stats</h6>
				                    <div class="widget-toggle">+</div>
				                </div>
				                <div class="widget-content">
				                    <ul>
				                        <li>
				                            <span class="stats-title">Stat 1</span>
				                            <span class="stats-complete">85%</span>
				                            <div class="progress">
				                                <div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
				                                    <span class="sr-only">85% Complete</span>
				                                </div>
				                            </div>
				                        </li>
				                        <li>
				                            <span class="stats-title">Stat 2</span>
				                            <span class="stats-complete">70%</span>
				                            <div class="progress">
				                                <div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">
				                                    <span class="sr-only">70% Complete</span>
				                                </div>
				                            </div>
				                        </li>
				                        <li>
				                            <span class="stats-title">Stat 3</span>
				                            <span class="stats-complete">2%</span>
				                            <div class="progress">
				                                <div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width: 2%;">
				                                    <span class="sr-only">2% Complete</span>
				                                </div>
				                            </div>
				                        </li>
				                    </ul>
				                </div>
				            </div>
				        </div>

				        <script>
				            // Maintain Scroll Position
				            if (typeof localStorage !== 'undefined') {
				                if (localStorage.getItem('sidebar-left-position') !== null) {
				                    var initialPosition = localStorage.getItem('sidebar-left-position'),
				                        sidebarLeft = document.querySelector('#sidebar-left .nano-content');

				                    sidebarLeft.scrollTop = initialPosition;
				                }
				            }
				        </script>

				    </div>

				</aside>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<header class="page-header">
						<h2>Projects</h2>

						<div class="right-wrapper text-end">
							
							<ol class="breadcrumbs">

								<li><a href="#" onClick="return changeLayoutColunm(1);"><span>column right none</span></a></li>

								<li><a href="#" onClick="return changeLayoutColunm(2);"><span>column right members</span></a></li>

								<li><a href="#" onClick="return changeLayoutColunm(3);"><span>column right clients</span></a></li>

							</ol>
							

							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->

					<div class="row">
						<!--PROJECT LIST-->
						<div id="opto-project-list-global" class="col-lg-12 mb-lg-2">
							<?php
								$sqlGetProjectList = mysqli_query($conexao, "SELECT * FROM projects");
								while($rowsprojects=mysqli_fetch_array($sqlGetProjectList)){

									$projectID = $rowsprojects['id'];
									
									$clientID = $rowsprojects['client'];
									$sqlGetClientData = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM clients WHERE id = '$clientID'"));
									$clientNumber = $sqlGetClientData['number'];

									if($rowsprojects['number'] < 10){
										$formatNumber = '0'.$rowsprojects['number'];
									}else{
										$formatNumber = $rowsprojects['number'];
									}
							?>
							<div class="opto-project-container">
								<div class="opto-project-header">
									<div class="opto-project-title-container">
										<h2 class="opto-project-title"><?php echo $sqlGetClientData['abbreviation'].$rowsprojects['year'].$formatNumber.'&nbsp;-&nbsp;'.$rowsprojects['projectName'];?></h2>
										<div class="opto-project-timeline">
											<div class="opto-project-timeline-borderline row">
												<a href="#" class="opto-project-timeline-format opto-project-timeline-production col-4"><div>PRODUCTION</div></a>
												<a href="#" class="opto-project-timeline-format opto-project-timeline-proof col-4"><div>PROOF</div>&nbsp;<i style="color: green;" class="fa-solid fa-thumbs-up"></i><i style="color: yellow;" class="fa-solid fa-hourglass-start"></i><i style="color: red;" class="fa-solid fa-thumbs-down"></i></a>
												<a href="#" class="opto-project-timeline-format opto-project-timeline-complete col-4"><div>COMPLETE</div></a>
											</div>
										</div>
									</div>
									<div class="opto-projects-images">
										<div class="opto-projects-images-member"><img src="opto/image/members/1135825450israel.jpg"></div>
										<div class="opto-projects-images-client"><img src="opto/image/clients/1498240461opto.jpg"></div>
									</div>
									<div class="opto-projects-toosl-right">
										<div class="opto-projects-toosl-right-icon"><a href="#"><i class="fa-solid fa-flag"></i></a></div>
										<div class="opto-projects-toosl-right-icon"><a href="#"><i class="fa-solid fa-trash"></i></a></div>
										<div class="opto-projects-toosl-right-icon"><a href="#"><i class="fa-solid fa-pen-to-square"></i></a></div>
										<div class="opto-projects-toosl-right-icon"><a href="#" onClick="return openProject(<?php echo $projectID; ?>);"><i class="fa-regular fa-folder-open"></i></a></div>
									</div>
									<div class="opto-projects-clock-right">
										<div class="opto-projects-toosl-clock-icon"><i class="fa-solid fa-clock">&nbsp;</i>02:25:40</div>
									</div>
								</div>
								<div class="opto-project-body" id="opto-project-body<?php echo $projectID; ?>">
									
									<div class="opto-project-tasks">
										<div>Tasks List &nbsp;<span><a class="badge badge-primary" onclick="return openModalCreateTask(<?php echo $projectID; ?>);" href="#"><i class="fa-solid fa-plus"></i></a></span></div>

										<?php
											$sqlGetTasks = mysqli_query($conexao, "SELECT * FROM tasks WHERE project_id = '$projectID'");
											while($rowsTasks=mysqli_fetch_array($sqlGetTasks)){
										?>
										<div>
											<div class="opto-project-tasks-list-container">
												<div class="opto-project-tasks-listView">
													<div class="opto-projects-tasks-listView-images-member"><img src="opto/image/members/1135825450israel.jpg"></div>
													<div class="opto-projects-tasks-listView-title">Video Production</div>
													<div class="opto-projects-tasks-listView-tools">
														<a href="#"><i class="fa-solid fa-trash"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
														<a href="#" onClick="return openTask(1);" id="opto-projects-tasks-open"><i class="fa-regular fa-folder-open"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
														<a href="#"><i class="fa-solid fa-folder-closed"></i></a>
													</div>
													<div class="opto-projects-tasks-listView-progressBar"><progress id="file" value="32" max="100"> 32% </progress></div>
												</div>
											</div>
											<!--INICIO DOS STEPS-->
											<div class="opto-project-steps" id="opto-project-steps1">
												<div class="opto-project-steps-list">
													<input class="opto-project-steps-checkbox" type="checkbox">
													<p class="opto-project-steps-title">Titulo do Step</p>
													<div class="opto-project-steps-delete"><i class="fa-solid fa-trash"></i></div>
												</div>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<?php } ?>
						</div>
						<!--MEMBERS LIST-->

							<div id="rightColumn1" class="col-lg-6 mb-lg-0">
								<div class="opto-members-container">
									<p class="bold">MEMBERS LIST</p>
									<?php
										$sqlGetmembers = mysqli_query($conexao, "SELECT * FROM members");
										while($rowsMembers=mysqli_fetch_array($sqlGetmembers)){
									?>
										<div class="opto-members-list">
											<div class="opto-members-list-image"><img width="30" height="30" src="opto/image/members/<?php echo $rowsMembers['image']; ?>"></div>
											<div class="opto-members-name"><?php echo $rowsMembers['fname']; ?>&nbsp;<?php echo $rowsMembers['lname']; ?></div>
											<div class="badge bg-warning opto-members-list-tasks">10</div>
										</div>
									<?php } ?>
								</div>
							</div>	
							<div id="rightColumn2" class="col-lg-6 mb-lg-0">
								<div class="opto-members-container">
									<p class="bold">CLIENTS LIST</p>
									<?php
										$sqlGetClients = mysqli_query($conexao, "SELECT * FROM clients");
										while($rowsClients=mysqli_fetch_array($sqlGetClients)){
									?>
										<div class="opto-members-list">
											<div class="opto-members-list-image"><img width="30" height="30" src="opto/image/clients/<?php echo $rowsClients['image']; ?>"></div>
											<div class="opto-members-name"><b><?php echo $rowsClients['abbreviation']; ?></b>&nbsp;-&nbsp;<?php echo $rowsClients['name']; ?></div>
											<div class="badge bg-warning opto-members-list-tasks">10</div>
										</div>
									<?php } ?>
								</div>
							</div>

					</div>

					<!-- end: page -->
				</section>

			</div>

			<aside id="sidebar-right" class="sidebar-right">
				<div class="nano">
					<div class="nano-content">
						<a href="#" class="mobile-close d-md-none">
							Collapse <i class="fas fa-chevron-right"></i>
						</a>

						<div class="sidebar-right-wrapper">

							<div class="sidebar-widget widget-calendar">
								<h6>Upcoming Tasks</h6>
								<div data-plugin-datepicker data-plugin-skin="dark"></div>

								<ul>
									<li>
										<time datetime="2021-04-19T00:00+00:00">04/19/2021</time>
										<span>Company Meeting</span>
									</li>
								</ul>
							</div>

							<div class="sidebar-widget widget-friends">
								<h6>Friends</h6>
								<ul>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="img/!sample-user.jpg" alt="Joseph Doe" class="rounded-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="img/!sample-user.jpg" alt="Joseph Doe" class="rounded-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="img/!sample-user.jpg" alt="Joseph Doe" class="rounded-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="img/!sample-user.jpg" alt="Joseph Doe" class="rounded-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
								</ul>
							</div>

						</div>
					</div>
				</div>
			</aside>

		</section>

		<!-- MODAL EDIT MEMBER  -->
		<div id="opto-edit-member" class="modal-block modal-block-primary mfp-hide">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Edit Member</h2>
				</header>
				<form enctype="multipart/form-data" action="" method="post">
					<div class="card-body">
						<div class="form-row">
							<div class="form-group">
								<label for="inputAddress">First Name</label>
								<input value="<?php echo $userInfo['fname']; ?>" name="fname" type="text" class="form-control" id="editFname">
							</div>
							<div class="form-group">
								<label for="inputAddress">Last Name</label>
								<input value="<?php echo $userInfo['lname']; ?>" name="lname" type="text" class="form-control" id="editLname">
							</div>
							<div class="form-group col-md-6">
								<label for="inputEmail4">Email</label>
								<input value="<?php echo $userInfo['email']; ?>" name="email" type="email" class="form-control" id="editEmail">
							</div>
							<div class="form-group col-md-6">
								<label for="inputEmail4">Image</label>
								<input name="imagem" type="file" class="form-control" id="imagem">
							</div>
							<div class="form-group col-md-6 mb-3 mb-lg-0">
								<label for="inputPassword4">Password</label>
								<input name="password" type="password" class="form-control" id="password" placeholder="Leave it blank to keep the same password">
							</div>
							<div class="form-group col-md-6 mb-3 mb-lg-0">
								<label for="inputPassword4">Password</label>
								<input name="vpassword" type="password" class="form-control" id="confirmPassword" placeholder="Leave it blank to keep the same password">
							</div>
						</div>
					</div>
					<footer class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<input type="hidden" name="editMember" value="ok">
								<button type="submit" class="btn btn-primary">Update</button>
								<button class="btn btn-default modal-dismiss">Cancel</button>
							</div>
						</div>
					</footer>
				</form>
			</section>
		</div>


		<!-- MODAL CREATE CLIENT  -->
		<div id="opto-create-client" class="modal-block modal-block-primary mfp-hide">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Create Client</h2>
				</header>
				<form enctype="multipart/form-data" action="" method="post">
					<div class="card-body">
						<div class="form-row">
							<div class="form-group">
								<label for="inputAddress">Client Name</label>
								<input name="clientCreateName" type="text" class="form-control" id="clientCreateName">
							</div>
							<div class="form-group">
								<label for="inputAddress">Client Abbreviation</label>
								<input maxlength="3" name="clientCreateAbbreviation" type="text" class="form-control" id="clientCreateAbbreviation">
							</div>
							<div class="form-group col-md-6">
								<label for="inputEmail4">Email</label>
								<input name="clientCreateEmail" type="email" class="form-control" id="clientCreateEmail">
							</div>
							<div class="form-group col-md-6">
								<label for="inputEmail4">Image</label>
								<input name="imagem" type="file" class="form-control" id="imagem">
							</div>
						</div>
					</div>
					<footer class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<input type="hidden" name="createClient" value="ok">
								<button type="submit" class="btn btn-primary">Create Client</button>
								<button class="btn btn-default modal-dismiss">Cancel</button>
							</div>
						</div>
					</footer>
				</form>
			</section>
		</div>


		<!-- MODAL CREATE PROJECT  -->
		<div id="opto-create-project" class="modal-block modal-block-primary mfp-hide">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Create Project</h2>
				</header>
				<form id="opto-form-create-project" action="" method="post">
					<div class="card-body">
						<div class="form-row">
							<div class="form-group">
								<label for="inputAddress">Project Name</label>
								<input name="projectCreateName" type="text" class="form-control" id="projectCreateName">
							</div>
							<div class="form-group col-md-6">
								<label for="projectCreateMember">Member</label>
								<select name="projectCreateMember" id="projectCreateMember" class="form-control">
									<?php
										$sqlGetmembers = mysqli_query($conexao, "SELECT * FROM members");
										while($rowsMembers=mysqli_fetch_array($sqlGetmembers)){
									?>
										<option value="<?php echo $rowsMembers['id']; ?>" <?php if($rowsMembers['id'] == $userID){echo 'selected';}?>><?php echo $rowsMembers['fname']."&nbsp;".$rowsMembers['lname']; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label for="projectCreateClient">Client</label>
								<select name="projectCreateClient" id="projectCreateClient" class="form-control">
									<?php
										$sqlGetClient = mysqli_query($conexao, "SELECT * FROM clients");
										while($rowsClient=mysqli_fetch_array($sqlGetClient)){
									?>
										<option value="<?php echo $rowsClient['id']; ?>"><?php echo $rowsClient['abbreviation']."&nbsp;-&nbsp;".$rowsClient['name']; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label for="projectCreatePreset">Preset</label>
								<select name="projectCreatePreset" id="projectCreatePreset" class="form-control">
									<option value="1">preset</option>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label for="projectCreateDueDate">Due Date</label>
								<input name="projectCreateDueDate" type="date" class="form-control" id="projectCreateDueDate">
							</div>
						</div>
					</div>
					<footer class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<input type="hidden" name="createProject" value="ok">
								<button type="submit" class="btn btn-primary">Create Client</button>
								<button class="btn btn-default modal-dismiss">Cancel</button>
							</div>
						</div>
					</footer>
				</form>
			</section>
		</div>

		<!-- MODAL CREATE TASK  -->
		<div id="opto-create-task" class="modal-block modal-block-primary mfp-hide">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Create Task</h2>
				</header>
				<form id="opto-form-create-task" action="" method="post">
					<div class="card-body">
						<div class="form-row">
							<div class="form-group">
								<label for="taskCreateTitle">Task Title</label>
								<input name="taskCreateTitle" type="text" class="form-control" id="taskCreateTitle">
							</div>
							<div class="form-group col-md-6">
								<label for="taskCreateMember">Member</label>
								<select name="taskCreateMember" id="taskCreateMember" class="form-control">
									<?php
										$sqlGetmembers = mysqli_query($conexao, "SELECT * FROM members");
										while($rowsMembers=mysqli_fetch_array($sqlGetmembers)){
									?>
										<option value="<?php echo $rowsMembers['id']; ?>" <?php if($rowsMembers['id'] == $userID){echo 'selected';}?>><?php echo $rowsMembers['fname']."&nbsp;".$rowsMembers['lname']; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label for="tasktCreateDueDate">Due Date</label>
								<input name="taskCreateDueDate" type="date" class="form-control" id="taskCreateDueDate">
							</div>
						</div>
					</div>
					<footer class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<input type="hidden" id="createTaskProjectID" name="createTaskProjectID" value="">
								<input type="hidden" name="createTask" value="ok">
								<button type="submit" class="btn btn-primary">Create Task</button>
								<button class="btn btn-default modal-dismiss">Cancel</button>
							</div>
						</div>
					</footer>
				</form>
			</section>
		</div>
		

		<!-- Vendor -->
		<script src="vendor/jquery/jquery.js"></script>
		<script src="vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="vendor/popper/umd/popper.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="vendor/common/common.js"></script>
		<script src="vendor/nanoscroller/nanoscroller.js"></script>
		<script src="vendor/magnific-popup/jquery.magnific-popup.js"></script>
		<script src="vendor/jquery-placeholder/jquery.placeholder.js"></script>

		<!-- Specific Page Vendor -->
		<script src="vendor/jquery-ui/jquery-ui.js"></script>
		<script src="vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js"></script>
		<script src="vendor/jquery-appear/jquery.appear.js"></script>
		<script src="vendor/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
		<script src="vendor/jquery.easy-pie-chart/jquery.easypiechart.js"></script>
		<script src="vendor/flot/jquery.flot.js"></script>
		<script src="vendor/flot.tooltip/jquery.flot.tooltip.js"></script>
		<script src="vendor/flot/jquery.flot.pie.js"></script>
		<script src="vendor/flot/jquery.flot.categories.js"></script>
		<script src="vendor/flot/jquery.flot.resize.js"></script>
		<script src="vendor/jquery-sparkline/jquery.sparkline.js"></script>
		<script src="vendor/raphael/raphael.js"></script>
		<script src="vendor/morris/morris.js"></script>
		<script src="vendor/gauge/gauge.js"></script>
		<script src="vendor/snap.svg/snap.svg.js"></script>
		<script src="vendor/liquid-meter/liquid.meter.js"></script>
		<script src="vendor/jqvmap/jquery.vmap.js"></script>
		<script src="vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
		<script src="vendor/jqvmap/maps/jquery.vmap.world.js"></script>
		<script src="vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
		<script src="vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
		<script src="vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
		<script src="vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
		<script src="vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
		<script src="vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>

		<!-- Theme Base, Components and Settings -->
		<script src="js/theme.js"></script>

		<!-- Theme Custom -->
		<script src="js/custom.js"></script>

		<!-- Theme Initialization Files -->
		<script src="js/theme.init.js"></script>

		<!-- Examples -->
		<script src="js/examples/examples.dashboard.js"></script>

		<!-- Examples -->
		<script src="js/examples/examples.modals.js"></script>

		<!-- JQUERY VALIDATION -->
		<script src="opto/js/jqueryValidation/jquery.validate.min.js"></script>

		<!-- OPTO-->
		<script src="opto/js/opto.js"></script>

		<script>
			$("#opto-form-create-project").validate({
				rules: {
					projectCreateName: {
						required: true
					}
				}
			})
		</script>

	</body>
</html>