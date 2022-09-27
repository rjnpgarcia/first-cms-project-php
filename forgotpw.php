<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



include "includes/header.php";
include "includes/navigation.php";

require './vendor/autoload.php';
require './classes/config.php';




if (!ifMethod('get') && !$_GET['forgot']) {
    redirect('index');
}

if (ifMethod('post')) {
    if (isset($_POST['email'])) {
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));

        if (checkEmailExists($email)) {
            if ($stmt = mysqli_prepare($connection, "UPDATE users SET token = '$token' WHERE user_email = ?"));
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $resetPasswordLink = "http://localhost/demo/cms/first-cms-project-php/reset.php?email=$email&token=$token";

            // Configure PHPMailer
            $mail = new PHPMailer();
            //Server settings
            $mail->isSMTP();
            $mail->Host       = config::SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = config::SMTP_USER;
            $mail->Password   = config::SMTP_PASSWORD;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = config::SMTP_PORT;
            $mail->isHTML(true);

            $mail->setFrom('rjnpgarcia@gmail.com', 'Ralph Garcia');
            $mail->addAddress($email);
            $mail->Subject = 'This is a test email';
            $mail->Body = "<p>Please click here to reset your password</p><br>
            <a href='$resetPasswordLink'>$resetPasswordLink</a>";
            $mail->CharSet = 'UTF-8';

            if ($mail->send()) {
                echo 'Email sent';
            } else {
                echo 'sending failed';
            }
        }
    }
}

?>


<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Forgot Password?</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">




                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                            <input id="email" name="email" placeholder="email address" class="form-control" type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
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