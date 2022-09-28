<?php
include "includes/header.php";
include "includes/navigation.php";

// For invalid page access prevention
// if (!isset($_GET['email']) && !isset($_GET['token'])) {
//     redirect('index');
// }

// Pulling data
$token = mysqli_real_escape_string($connection, $_GET['token']);
$email = mysqli_real_escape_string($connection, $_GET['email']);

if ($stmt = mysqli_prepare($connection, 'SELECT username, user_email, token FROM users WHERE token = ?')) {
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $username, $user_email, $token);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Protection
    if (($_GET['token']) !== $token || $_GET['email'] !== $email) {
        redirect('index');
    }

    if (isset($_POST['password']) && isset($_POST['confirmPassword'])) {
        if ($_POST['password'] === mysqli_real_escape_string($connection, $_POST['confirmPassword'])) {
            $password = mysqli_real_escape_string($connection, $_POST['password']);
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));
            if ($stmt = mysqli_prepare($connection, "UPDATE users SET token = '', user_password = '$hashedPassword' WHERE user_email = ?")) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                redirect('login.php');
            }
        } else {
            $passwordMismatch = true;
        }
    }
}
?>



<!-- Page Content -->
<div class="container">



    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">


                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                    <?php echo isset($passwordMismatch) ? "<h5 class='text-center text-danger'>Passwords does not match</h5>" : ""; ?>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input id="password" name="password" placeholder="Enter password" class="form-control" type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                            <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control" type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>

                            </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php"; ?>

</div> <!-- /.container -->