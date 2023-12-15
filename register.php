
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
						<h2 class="title text-uppercase font-weight-bold m-0"><i class="bx bx-user-circle me-1 text-6 position-relative top-5"></i> Sign Up</h2>
					</div>
					<div class="card-body">
						<form id="opto-form-register" method="post" action="" enctype="multipart/form-data">
							<div class="form-group mb-3">
								<label>First Name</label>
								<input name="fname" type="text" class="form-control form-control-lg" />
							</div>

							<div class="form-group mb-3">
								<label>Last Name</label>
								<input name="lname" type="text" class="form-control form-control-lg" />
							</div>

							<div class="form-group mb-3">
								<label>E-mail Address</label>
								<input name="email" type="email" class="form-control form-control-lg" />
							</div>

							<div class="form-group mb-3">
								<label>Upload Image</label>
								<input name="imagem" type="file" class="form-control form-control-lg" />
							</div>

							<div class="form-group mb-0">
								<div class="row">
									<div class="col-sm-6 mb-3">
										<label>Password</label>
										<input name="password" id="password" type="password" class="form-control form-control-lg" />
									</div>
									<div class="col-sm-6 mb-3">
										<label>Password Confirmation</label>
										<input name="confirm" type="password" class="form-control form-control-lg" />
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-8">
									<div class="checkbox-custom checkbox-default">
										<input id="AgreeTerms" name="agreeterms" type="checkbox"/>
										<label for="AgreeTerms">I agree with <a href="#">terms of use</a></label>
									</div>
								</div>
								<div class="col-sm-4 text-end">
									<input type="hidden" name="acao" value="ok">
									<button type="submit" class="btn btn-primary mt-2">Sign Up</button>
								</div>
							</div>

						
							<p class="text-center">Already have an account? <a href="pages-signin.html">Sign In!</a></p>

						</form>
					</div>
				</div>

				<p class="text-center text-muted mt-3 mb-3">&copy; Copyright <?php echo date("Y"); ?>. All Rights Reserved.</p>
			</div>


			<!----------MODAL WARNING----------->
			<div id="opto-modal-warning-register" class="modal-block modal-header-color modal-block-warning mfp-hide">
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
								<p>This is a warning message.</p>
							</div>
						</div>
					</div>
					<footer class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<button class="btn btn-warning modal-dismiss">OK</button>
							</div>
						</div>
					</footer>
				</section>
			</div>

			<!------------MODAL SUSCCESS----------->
			<div id="opto-modal-success-register" class="modal-block modal-header-color modal-block-success mfp-hide">
				<section class="card">
					<header class="card-header">
						<h2 class="card-title">Success!</h2>
					</header>
					<div class="card-body">
						<div class="modal-wrapper">
							<div class="modal-icon">
								<i class="fas fa-check"></i>
							</div>
							<div class="modal-text">
								<h4 class="font-weight-bold text-dark">Success</h4>
								<p>You can use the registered data to access and manage your account.</p>
							</div>
						</div>
					</div>
					<footer class="card-footer">
						<div class="row">
							<div class="col-md-12 text-end">
								<a href="#" onClick="return goToPage('login.php');" class="btn btn-success modal-dismiss">OK</a>
							</div>
						</div>
					</footer>
				</section>
			</div>




		</section>
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

		<!-- JQUERY VALIDATION -->
		<script src="opto/js/jqueryValidation/jquery.validate.min.js"></script>

		<!-- OPTO-->
		<script src="opto/js/opto.js"></script>




		<script>
			
			//***FUNÇÃO QUE ABRE POPUP DE ALERT APOS A CRIAÇÂO DE UM USUARIO */
			function registerAlert(){
				$.magnificPopup.open({
					items: {
						src: $('#opto-modal-success-register'),
					},
					type: 'inline',
					preloader: false,
					modal: true,
				});
			}
		</script>

		<script>
			$("#opto-form-register").validate({
				rules: {
					fname: {
						required: true
					},
					lname: {
						required: true
					},
					email: {
						required: true,
						email: true
					},
					image: {
						required: true
					},
					password: {
						required: true,
						maxlength: 10
					},
					confirm: {
						required: true,
						equalTo: "#password",
						maxlength: 10
					}
				}
			})
		</script>

		<?php

		if(isset($_POST['acao'])){

			require("conexaoPDO.php");	

			$fname = trim($_POST['fname']);
			$lname = trim($_POST['lname']);
			$email = trim($_POST['email']);
			$password = md5($_POST['password']);

			$tiposPermitidos= array('jpeg', 'jpg', 'png');
			$images    = $_FILES['imagem']['name'];
			$imagesType    = $_FILES['imagem']['type'];
			$rand	   = rand();
			$errorUpload = 'N';

			$sqlVerificaEmailExiste = mysqli_query($conexao, "SELECT * FROM members WHERE email = '$email'");
			$contagemVerificaEmailExiste = mysqli_num_rows($sqlVerificaEmailExiste);
			
			if (array_search($imagesType, $tiposPermitidos) != false) {
					echo 'File Not Allowed!';
			}else if($contagemVerificaEmailExiste != 0){
				echo 'This user already exists!';
			}
			else{
				$images = str_replace("'", "", $images);
				$imgFileName = $rand.$images;
				$path 		 = 'opto/image/members/temp/'.$imgFileName;

				move_uploaded_file($_FILES['imagem']['tmp_name'], $path);
					
				include("resize-class.php");
				$resizeObj = new resize('opto/image/members/temp/'.$imgFileName);
				$resizeObj -> resizeImage(200, 200, 'crop');
				$resizeObj -> saveImage('opto/image/members/'.$imgFileName, 100);
					
				$sqlPegaTasks = mysqli_query($conexao, "INSERT INTO members (fname, lname, email, password, image, creation_date)VALUES('$fname', '$lname', '$email', '$password', '$imgFileName', NOW())") or die(mysqli_error($conexao));
					
				$removeTemp = unlink('opto/image/members/temp/'.$imgFileName);
					
				echo '<script>registerAlert();</script>';
			}
		}

		?>
	</body>
</html>