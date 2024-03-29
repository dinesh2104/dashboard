<?php

if (isset($_POST['reg-email'])) {
	$email = $_POST['reg-email'];
	if (User::resetPassword($email)) {
		echo "Success";
	}
}

?>

<body class="app app-signup p-0">

	<div class="row g-0 app-auth-wrapper">
		<div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
			<div class="d-flex flex-column align-content-end">
				<div class="app-auth-body mx-auto">
					<div class="app-auth-branding mb-4"><a class="app-logo" href="index.php"><img class="logo-icon me-2" src="/assets/images/app-logo.svg" alt="logo"></a></div>
					<h2 class="auth-heading text-center mb-4">Password Reset</h2>

					<div class="auth-intro mb-4 text-center">Enter your email address below. We'll email you a link to a page where you can easily create a new password.</div>

					<div class="auth-form-container text-left">

						<form class="auth-form resetpass-form" action="reset-password.php" method="POST">
							<div class="email mb-3">
								<label class="sr-only" for="reg-email">Your Email</label>
								<input id="reg-email" name="reg-email" type="email" class="form-control login-email" placeholder="Your Email" required="required">
							</div><!--//form-group-->
							<div class="text-center">
								<button type="submit" class="btn btn-primary btn-block theme-btn mx-auto">Reset Password</button>
							</div>
						</form>

						<div class="auth-option text-center pt-5"><a class="link" href="login.php">Log in</a> <span class="px-2">|</span> <a class="link" href="signup.php">Sign up</a></div>
					</div><!--//auth-form-container-->


				</div><!--//auth-body-->

			</div><!--//flex-column-->
		</div><!--//auth-main-col-->
		<div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
			<div class="auth-background-holder">
			</div>
			<div class="auth-background-mask"></div>
			<div class="auth-background-overlay p-3 p-lg-5">
				<div class="d-flex flex-column align-content-end h-100">
					<div class="h-100"></div>
					<!-- <div class="overlay-content p-3 p-lg-4 rounded">
						<h5 class="mb-3 overlay-title">Explore Portal Admin Template</h5>
						<div>Portal is a free Bootstrap 5 admin dashboard template. You can download and view the
							template license <a
								href="https://themes.3rdwavemedia.com/bootstrap-templates/admin-dashboard/portal-free-bootstrap-admin-dashboard-template-for-developers/">here</a>.
						</div>
					</div> -->
				</div>
			</div><!--//auth-background-overlay-->
		</div>

	</div><!--//row-->

</body>