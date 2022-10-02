<?php
// INCLUDES
include "includes/header.php";
include "includes/navigation.php";

// Setting Language Variables
if (isset($_GET['lang']) && !empty($_GET['lang'])) {
    $_SESSION['lang'] = mysqli_real_escape_string($connection, $_GET['lang']);

    if (isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']) {
        echo "<script type='text/javascript'>location.reload(); </script>";
    }
}

if (isset($_SESSION['lang'])) {
    $language = $_SESSION['lang'];
    include "includes/languages/$language.php";
} else {
    include "includes/languages/en.php";
}


// Registration Form Query
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $error = [
        'username' => '',
        'email' => '',
        'password' => '',
    ];

    if (strlen($username) < 4) {
        $error['username'] = 'Username is too short!';
    }

    if (empty($username)) {
        $error['username'] = 'Username should not be empty!';
    }

    if (checkUsernameExists($username)) {
        $error['username'] = 'Username already exists!';
    }

    if (empty($email)) {
        $error['email'] = 'Email should not be empty!';
    }

    if (checkEmailExists($email)) {
        $error['email'] = 'Email already exists!';
    }

    if (empty($password)) {
        $error['password'] = 'Password should not be empty!';
    }

    // for Valid Registration
    foreach ($error as $key => $value) {
        if (empty($value)) {
            unset($error[$key]);
        }
    }
    if (empty($error)) {
        register($username, $email, $password);
        $success = "Successfully registered! <a href='/demo/cms/first-cms-project-php/index'>Login here</a>";
    }
    /*
    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);
    // check duplicate username
    if (checkUsernameExists($username)) {
        $message = "<h6 class='text-center text-danger'>Username already exists</h6>";
    } elseif (!empty($username) && !empty($email) && !empty($password)) {

        // NEW SYSTEM for Password Encrytion
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

        // CREATE registration query
        $query = "INSERT INTO users(username, user_email, user_password, user_role) VALUES ('$username', '$email', '$password', 'subscriber')";
        $register_user_query = mysqli_query($connection, $query);
        confirmQuery($register_user_query);
        $message = "<h6 class='text-center text-success'>Registration has been submitted</h6>";
    } else {
        $message = "<h6 class='text-danger'>This field should not be empty</h6>";
    }
} else {
    $message = '';
    */
}
?>


<!-- Page Content -->
<div class="container">

    <!-- for Languages selection-->
    <form method="get" action="" class="navbar-form navbar-right" id="language_form">
        <div class="form-group">
            <select name="lang" onchange="changeLanguage()" class="form-control">
                <option value="en" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') {
                                        echo 'selected';
                                    } ?>>English</option>
                <option value="es" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'es') {
                                        echo 'selected';
                                    } ?>>Spanish</option>
            </select>
        </div>
    </form>

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1><?php echo _REGISTER; ?></h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <!-- success register notification -->
                                <p class="text-center text-success"><?php echo !empty($success) ? $success : ''; ?></p>

                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME; ?>" autocomplete="on" value="<?php echo isset($username) ? $username : ''; ?>">
                                <p class="text-danger"><?php echo isset($error['username']) ? $error['username'] : ''; ?></p>
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL; ?>" autocomplete="on" value="<?php echo isset($username) ? $email : ''; ?>">
                                <p class="text-danger"><?php echo isset($error['email']) ? $error['email'] : ''; ?></p>
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo _PASSWORD; ?>">
                                <p class="text-danger"><?php echo isset($error['password']) ? $error['password'] : ''; ?></p>
                            </div>
                            <input type="submit" name="register" id="btn-login" class="btn btn-info btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>

    <script>
        function changeLanguage() {
            document.getElementById('language_form').submit();
        }
    </script>

    <?php include "includes/footer.php"; ?>