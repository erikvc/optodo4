<?php session_start(); ?>
<!doctype html>
<html class="fixed dark">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

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

		<!-- Theme CSS -->
		<link rel="stylesheet" href="css/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="css/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="css/custom.css">

		<!-- Head Libs -->
		<script src="vendor/modernizr/modernizr.js"></script>

	</head>
	<body>
		<!-- start: page -->
		<section class="body-sign">
			<div class="center-sign">
				<a href="/" class="logo float-start">
					<img src="img/logo.png" height="70" alt="Porto Admin" />
				</a>

				<div class="panel card-sign">
					<div class="card-title-sign mt-3 text-end">
						<h2 class="title text-uppercase font-weight-bold m-0"><i class="bx bx-user-circle me-1 text-6 position-relative top-5"></i> Sign In</h2>
					</div>
					<div class="card-body">
						<form id="opto-form-login" action="" method="post">
							<div class="form-group mb-3">
								<label>Email</label>
								<div class="input-group">
									<input name="email" type="email" class="form-control form-control-lg" />
									<span class="input-group-text">
										<i class="bx bx-user text-4"></i>
									</span>
								</div>
							</div>

							<div class="form-group mb-3">
								<div class="clearfix">
									<label class="float-start">Password</label>
									<a href="pages-recover-password.html" class="float-end">Lost Password?</a>
								</div>
								<div class="input-group">
									<input name="password" type="password" class="form-control form-control-lg" />
									<span class="input-group-text">
										<i class="bx bx-lock text-4"></i>
									</span>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-8">
									<div class="checkbox-custom checkbox-default">
										<input id="RememberMe" name="rememberme" type="checkbox" value="1"/>
										<label for="RememberMe">Remember Me</label>
									</div>
								</div>
								<div class="col-sm-4 text-end">
									<input type="hidden" name="acao" value="ok">
									<button type="submit" class="btn btn-primary mt-2">Sign In</button>
								</div>
							</div>

							

							<p class="text-center">Don't have an account yet? <a href="register.php">Sign Up!</a></p>

						</form>
					</div>
				</div>

				<p class="text-center text-muted mt-3 mb-3">&copy; Copyright <?php echo date("Y"); ?>. All Rights Reserved.</p>
			</div>
		</section>





		<!----------MODAL WARNING----------->
		<div id="opto-modal-warning-login" class="modal-block modal-header-color modal-block-warning mfp-hide">
				<section class="card">
					<header class="card-header">
						<h2 class="card-title">Warning!</h2>
					</header>
					<div class="card-body">
						<div class="modal-wrapper">
							<div class="modal-icon">
								<i class="fas fa-exclamation-triangle"></i>
							</div>
							<div class="modal-text">
								<h4 class="font-weight-bold text-dark">Warning</h4>
								<p>Email or password are invalid.</p>
							</div>
						</div>
					</div>
					<footer class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<a href="#" onclick="return goToPage('login.php')" class="btn btn-warning modal-dismiss">OK</button>
							</div>
						</div>
					</footer>
				</section>
			</div>
		<!-- end: page -->

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

		<!-- Theme Base, Components and Settings -->
		<script src="js/theme.js"></script>

		<!-- Theme Custom -->
		<script src="js/custom.js"></script>

		<!-- Theme Initialization Files -->
		<script src="js/theme.init.js"></script>

		<!-- OPTO-->
		<script src="opto/js/opto.js"></script>



		<!-- JQUERY VALIDATION -->
		<script src="opto/js/jqueryValidation/jquery.validate.min.js"></script>



		<script>
			$("#opto-form-login").validate({
				rules: {

					email: {
						required: true,
						email: true
					},
					password: {
						required: true,
						maxlength: 10
					}
				}
			})


			//***FUNÇÃO QUE ABRE POPUP DE ALERT APOS A CRIAÇÂO DE UM USUARIO */
			function loginAlert(){
				$.magnificPopup.open({
					items: {
						src: $('#opto-modal-warning-login'),
					},
					type: 'inline',
					preloader: false,
					modal: true,
				});
			}
		</script>


		<?php
			if(isset($_POST['acao'])){
				$email = trim($_POST['email']);
				$password = md5($_POST['password']);

				require("conexaoPDO.php");

				//$email = mysql_real_escape_string($conexao, $_POST['email']);
				//$password = mysql_real_escape_string($conexao, $_POST['password']);
				$selectUser = "SELECT * FROM members WHERE email = '$email' AND password = '$password'";
				$runUser = mysqli_query($conexao, $selectUser) or die(mysqli_error($conexao));
				$verifica = mysqli_num_rows($runUser);
				//echo '<script>alert("'.$verifica.'")</script>';
				if($verifica != 0){
					session_start();
					$_SESSION['optodo'] = $email;
					$SQLLastLogin = mysqli_query($conexao, "UPDATE members SET lastLogin=NOW() WHERE email = '$username'");
					echo '<script>window.location.href="index.php"</script>';
				}else{
					echo '<script>loginAlert();</script>'; //USER NOT EXIST!!!
				}
			}
		?>

	</body>
</html>