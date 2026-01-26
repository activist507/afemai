<main>
	<!-- form design -->
	<div class="container">

		<section class="section register min-vh-80 d-flex flex-column align-items-center justify-content-center py-4">
			<!-- <div class="container"> -->
			<div class="row justify-content-center">
				<div class="col-lg-8 col-md-8 col-sm-4 d-flex flex-column align-items-center justify-content-center">

					<div class="d-flex justify-content-center py-4">
						<a href="index.php" class="logo d-flex align-items-center w-auto">
							<img src="assets/img/logo.png" alt="">
							<span class="d-none d-lg-block"><strong>IDEA-CBT</strong></span>
						</a>
					</div><!-- End Logo Login to Your -->

					<div class="card mb-3">

						<div class="card-body">

							<div class="pt-4 pb-2">
								<h5 class="card-title text-center pb-0 fs-4"><strong>Staff Account</strong></h5>
								<p class="text-center small">Enter Your Staff_ID & Password to Login</p>
							</div>

							<form class="row g-3 needs-validation">

								<div class="col-12">
									<label for="yourUsername" class="form-label">Staff_ID</label>
									<div class="input-group has-validation">
										<span class="input-group-text" id="inputGroupPrepend">@</span>
										<input type="number" maxlength="4" name="username" id="username"
											class="form-control" required>
										<div class="invalid-feedback">Please Enter Your Staff_ID.</div>
									</div>
								</div>

								<div class="col-12">
									<label for="yourPassword" class="form-label">Password</label>
									<input type="password" name="password" id="password" class="form-control"
										maxlength="20" required>
									<div class="invalid-feedback">Please enter your password</div>
								</div>

								<div class="col-12">
									<button class="btn btn-primary w-100" type="submit" id="stafflogin">Login</button>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
			<!-- </div> -->
		</section>
	</div>
</main><!-- End #main -->