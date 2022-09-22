<?php
// INCLUDES
include "includes/header.php";
include "includes/navigation.php";
// Registration Form Query
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);
    // check duplicate username
    if (checkUsernameExists($username)) {
        $message = "<p class='text-danger'>Username exists</p>";
    } elseif (!empty($username) && !empty($email) && !empty($password)) {

        // NEW SYSTEM for Password Encrytion
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

        // (OLD SYSTEM) randSalt query and password encrypt
        // $query = "SELECT randSalt FROM users";
        // $select_randsalt_query = mysqli_query($connection, $query);
        // if (!$select_randsalt_query) {
        //     die('QUERY FAILED' . mysqli_error($connection));
        // }
        // $row = mysqli_fetch_array($select_randsalt_query);
        // $salt = $row['randSalt'];
        // $password = crypt($password, $salt);


        // CREATE registration query
        $query = "INSERT INTO users(username, user_email, user_password, user_role) VALUES ('$username', '$email', '$password', 'subscriber')";
        $register_user_query = mysqli_query($connection, $query);
        if (!$register_user_query) {
            die('QUERY FAILED' . mysqli_error($connection));
        }
        $message = "<h6 class='text-center text-success'>Registration has been submitted</h6>";
    } else {
        $message = "<h6 class='text-danger'>This field should not be empty</h6>";
    }
} else {
    $message = '';
}
?>


<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <?php
                            // Success Notification
                            if (!empty($register_user_query)) {
                                echo $message;
                            }
                            ?>
                            <div class="form-group">
                                <?php
                                // Field empty notif
                                if (empty($username)) {
                                    echo $message;
                                }
                                ?>
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                            </div>
                            <div class="form-group">
                                <?php
                                // Field empty notif
                                if (empty($email)) {
                                    echo $message;
                                }
                                ?>
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <?php
                                // Field empty notif
                                if (empty($password)) {
                                    echo $message;
                                }
                                ?>
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-info btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>