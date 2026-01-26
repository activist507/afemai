<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Login - Idea</title>
	<meta content="" name="description">
	<meta content="" name="keywords">

	<!-- Vendor CSS Files -->
	<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="admin/assets/css/jquery-confirm.min.css" rel="stylesheet">


	<!-- Template Main CSS File -->
	<link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

	<main>
		<div class="container">
			<section
				class="section register min-vh-80 d-flex flex-column align-items-center justify-content-center py-4">
				<!-- <div class="container"> -->
				<div class="row justify-content-center">
					<div
						class="col-lg-8 col-md-8 col-sm-4 d-flex flex-column align-items-center justify-content-center">

						<div class="d-flex justify-content-center py-4">
							<a href="index.php" class="logo d-flex align-items-center w-auto">
								<img src="assets/img/logo.png" alt="">
								<span class="d-none d-lg-block"><strong>IDEA-CBT</strong></span>
							</a>
						</div><!-- End Logo -->

						<div class="card mb-3">
							<div class="card-body">
								<div class="pt-4 pb-2">
									<h5 class="card-title text-center pb-0 fs-4"><strong>Members Account</strong></h5>
									<p class="text-center small">Enter your Member_ID & password to login</p>
								</div>

								<form class="row g-3 needs-validation">

									<div class="col-12">
										<label for="yourUsername" class="form-label">Member_ID</label>
										<div class="input-group has-validation">
											<span class="input-group-text" id="inputGroupPrepend">@</span>
											<input type="number" name="username" class="form-control" id="Member_ID"
												maxlength="4" required>
											<div class="invalid-feedback">Please enter your Member_ID.</div>
										</div>
									</div>

									<div class="col-12">
										<label for="yourPassword" class="form-label">Password</label>
										<input type="password" name="password" maxlength="6" class="form-control"
											id="password" required>
										<div class="invalid-feedback">Please enter your password</div>
									</div>

									<div class="col-12">
										<button class="btn btn-primary w-100" type="submit"
											id="memberLogin">Login</button>
									</div>
									<a href="reset.php" class="fw-bold text-danger">Forgot Password ?</a>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- </div> -->
			</section>
		</div>
	</main><!-- End #main -->

	<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
			class="bi bi-arrow-up-short"></i></a>

	<!-- Vendor JS Files -->
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/php-email-form/validate.js"></script>
	<script src="admin/assets/js/jquery-3.7.1.min.js"></script>
 	<script src="admin/assets/js/jquery-confirm.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#memberLogin').click(function(e) {
				e.preventDefault();
				var Member_ID = $('#Member_ID').val();
				var password = $('#password').val();
				$.ajax({
					url: 'Functions.php',
					type: 'POST',
					dataType: 'json',
					cache: false,
					data: {
						"Member_ID": Member_ID,
						"password": password,
						"type": "memberLogin"
					},

					success: function(response) {
						if (response.success == 'failed') {
							$.confirm({
								icon: 'bi bi-patch-question',
								theme: 'bootstrap',
								title: 'Message',
								content: response.message,
								animation: 'scale',
								type: 'orange'
							})
						} else if (response.success == 'successful') {
							window.location = response.link
						} else if (response.success = 'unpermitted') {
							$.confirm({
								icon: 'bi bi-patch-question',
								theme: 'bootstrap',
								title: 'Message',
								content: response.message,
								animation: 'scale',
								type: 'orange'
							})
						}
					},
					error: function(error) {
						console.log(error);
					}
				})
			})
		})
	</script>

</body>

</html>