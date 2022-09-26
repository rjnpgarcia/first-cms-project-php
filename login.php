<?php
include "includes/header.php";
include "includes/navigation.php";

// if logged in, redirect
ifUserLoggedRedirect("/demo/cms/first-cms-project-php/index");

// LOGIN Username and Password Query
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '$username'";
    $select_user_query = mysqli_query($connection, $query);
    if (!$select_user_query) {
        die("QUERY FAILED" . mysqli_error($connection));
    }

    while ($row = mysqli_fetch_array($select_user_query)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];

        // NEW SYSTEM for password verification
        if (password_verify($password, $db_user_password)) {
            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;
            $_SESSION['user_id'] = $db_user_id;
            header('Location: /demo/cms/first-cms-project-php/admin/index.php');
            exit;
        }
    }
    // for errors
    // if (empty($db_username) || empty($db_user_password)) {
    //     $db_user_password = '';
    //     $db_username = '';
    // }
    // (OLD SYSTEM) password verification
    // $password = crypt($password, $db_user_password);

    $errormessage = "<h5 class='text-danger text-center'>Username and Password invalid</h5>";
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


                            <h3><i class="fa fa-user fa-4x"></i></h3>
                            <h2 class="text-center">Login</h2>
                            <div class="panel-body">

                                <?php echo !empty($errormessage) ? $errormessage : ''; ?>
                                <form id="login-form" role="form" autocomplete="off" class="form" method="post">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>

                                            <input name="username" type="text" class="form-control" placeholder="Enter Username">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                            <input name="password" type="password" class="form-control" placeholder="Enter Password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <a href="forgotpw.php?forgot=<?php echo uniqid(true); ?>">Forgot password?</a>
                                    </div>

                                    <div class="form-group">

                                        <input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
                                    </div>


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