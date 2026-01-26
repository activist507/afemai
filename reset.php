
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Reset Password</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <!-- <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet"> -->

    <!-- Template Main CSS File -->
    <link href="admin/assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/assets/css/jquery-confirm.min.css">
    <style>
        .logo {
            line-height: 1;
        }

        @media (min-width: 1200px) {
            .logo {
                width: 500px;
            }
        }

        .logo img {
            max-height: 120px;
            margin-right: 6px;
        }

        .logo span {
            font-size: 26px;
            font-weight: 700;
            color: #012970;
            font-family: "Nunito", sans-serif;
        }
    </style>
</head>

<body>

<div class="container">

		<section class="section register min-vh-80 d-flex flex-column align-items-center justify-content-center py-4">
			<!-- <div class="container"> -->
			<div class="row justify-content-center">
				<div class="col-lg-8 col-md-8 col-sm-4 d-flex flex-column align-items-center justify-content-center">

					<div class="d-flex justify-content-center py-4">
						<a href="index.php" class="logo d-flex w-auto">
							<!-- <img src="assets/img/logo22.png" alt=""> -->
						</a>
					</div>

					<div class="card mb-3">

						<div class="card-body">

							<div class="pt-4 pb-2">
								<h5 class="card-title text-center pb-0 fs-4"><strong>RAAID MEMBER</strong></h5>
								<p class="text-center small">Reset Password</p>
							</div>

							<form class="row g-3 needs-validation">

								<div class="col-12">
									<label for="yourMember_ID" class="form-label">MEMBER_ID</label>
									<div class="input-group has-validation">
										<span class="input-group-text" id="inputGroupPrepend">@</span>
										<input type="text" name="Member_ID" id="Member_ID"
											class="form-control" required>
										<div class="invalid-feedback">Please Enter Your MEMBER_ID.</div>
									</div>
								</div>

								<div class="col-12">
									<label for="yourPassword" class="form-label">New Password</label>
									<input type="password" name="password" id="password" class="form-control"
										maxlength="20" required>
								</div>
                                <div class="col-12">
									<label for="yourPassword" class="form-label">Confirm Password</label>
									<input type="password" name="confirm_password" id="confirm_password" class="form-control"
										maxlength="20" required>
								</div>

								<div class="col-12">
									<button class="btn btn-primary w-100" type="submit" id="resetBtn" disabled> Reset Password</button>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
			<!-- </div> -->
		</section>
	</div>


    <!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="assets/vendor/chart.js/chart.umd.js"></script>     -->
    <!-- <script src="assets/vendor/simple-datatables/simple-datatables.js"></script> -->
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="admin/assets/js/jquery-3.7.1.min.js"></script>
    <script src="admin/assets/js/jquery-confirm.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {

        //<====== check confirm password
        $('#confirm_password').keyup(function(){
            let password = $('#password').val();
            var confirm_password = $(this).val();
            if(confirm_password != '' && confirm_password == password){
                $('#resetBtn').attr("disabled",false);
            } else {
                $('#resetBtn').attr("disabled",true);
            }
        })

        //<!-- Login button clicked -->
        $('#resetBtn').click(function(e) {
            e.preventDefault();
            var Member_ID = $('#Member_ID').val();
            var password = $('#confirm_password').val();

            if (Member_ID !== '' && password !== '') {
                $.ajax({
                    url: 'reset_db.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        "Member_ID": Member_ID,
                        "password": password,
                        "type": "reset"
                    },
                    success: function(response) {
                        // console.log(response)
                        if (response.success == 'successful') {
                            $.alert({title: 'Message',content: response.message});
                            setTimeout(function() {window.location = response.link}, 2000);
                        } else {
                            $.alert({title: 'Alert!!',content: response.message });
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            } else {
                toastr.error('Sorry, an input field is empty');
            }
        })
        //<!--END Login button clicked -->
    })
    </script>

</body>

</html>