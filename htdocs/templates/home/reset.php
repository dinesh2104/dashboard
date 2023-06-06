<?php

if (isset($_POST['token']) && isset($_POST['new-password']) && isset($_POST['confirm-new-password'])) {
    $new_pass = $_POST['new-password'];
    $confirm_pass = $_POST['confirm-new-password'];
    $token = $_POST['token'];
    print_r($token);
    print_r($new_pass);
    if ($new_pass == $confirm_pass) {
        $res = User::changePassword($new_pass, $token);
        if ($res == true) {
            header("Location: /");
        } else {
            echo "Try again later";
        }
    } else {
        echo "Password Mismatch";
    }
}

$res = false;

if (isset($_GET['token'])) {
    // echo "<pre>";
    // print_r($_SERVER);
    // echo "</pre>";
    $res = User::validateResetToken($_GET['token']);
}

if ($res == true) {
?>

    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.php"><img class="logo-icon me-2" src="/assets/images/app-logo.svg" alt="logo"></a></div>
                    <h2 class="auth-heading text-center mb-4">Password Reset</h2>

                    <div class="auth-intro mb-4 text-center">Enter your New Password</div>

                    <div class="auth-form-container text-left">

                        <form class="auth-form resetpass-form" action="reset.php" method="POST">
                            <div class="password mb-3">
                                <label class="sr-only" for="signup-password">New Password</label>
                                <input id="signup-password" name="new-password" type="password" class="form-control signup-password" placeholder="Create a New password" required="required">
                            </div>
                            <div class="password mb-3">
                                <label class="sr-only" for="confirm-password">Confirm Password</label>
                                <input id="confirm-password" name="confirm-new-password" type="password" class="form-control signup-password" placeholder="Retype the password" required="required">
                            </div>
                            <input hidden name="token" value="<?= $_GET['token'] ?>">
                            <div class=" text-center">
                                <button type="submit" class="btn btn-primary btn-block theme-btn mx-auto">Submit</button>
                            </div>
                        </form>

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
<?php

} else {

?>

    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.php"><img class="logo-icon me-2" src="/assets/images/app-logo.svg" alt="logo"></a></div>
                    <h2 class="auth-heading text-center mb-4">Reset Token Expired. Please try again with new Token</h2>

                </div><!--//auth-body-->

            </div><!--//flex-column-->
        </div><!--//auth-main-col-->

        <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col bg-success">
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
        </div><!--//auth-background-col-->

    </div><!--//row-->

<?php
}
?>