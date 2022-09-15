<!-- header codes -->
<?php include "includes/admin_header.php";
//  Read Query for User Profile
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE user_id = '$user_id'";
    $select_user_profile_query = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($select_user_profile_query)) {
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $username = $row['username'];
        $user_email = $row['user_email'];
        $user_password = $row['user_password'];
    }
}
// Update Query for User Profile
if (isset($_POST['edit_profile'])) {
    $new_user_firstname = $_POST['user_firstname'];
    $new_user_lastname = $_POST['user_lastname'];
    $new_username = $_POST['username'];
    $new_user_password = $_POST['user_password'];
    $new_user_email = $_POST['user_email'];

    // (OLD SYSTEM) new password encryption
    // $query = "SELECT randSalt FROM users";
    // $select_randsalt_query = mysqli_query($connection, $query);
    // if (!$select_randsalt_query) {
    //     die('QUERY FAILED' . mysqli_error($connection));
    // }
    // $row = mysqli_fetch_array($select_randsalt_query);
    // $salt = $row['randSalt'];
    // $hashed_password = crypt($user_password, $salt);

    // NEW SYSTEM password encryption
    if (empty($new_user_password) || $new_user_password === $user_password) {
        $new_user_password = $user_password;
    } else {
        $new_user_password = password_hash($new_user_password, PASSWORD_BCRYPT, ['cost' => 10]);
    }

    $query = "UPDATE users SET user_firstname = '$new_user_firstname', user_lastname = '$new_user_lastname', username = '$new_username', user_password = '$new_user_password', user_email = '$new_user_email' WHERE user_id = '$user_id'";

    $edit_user_query = mysqli_query($connection, $query);

    if (!$edit_user_query) {
        die('QUERY FAILED' . mysqli_error($connection));
    }
}
?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to ADMIN
                        <small><?php echo $_SESSION['firstname']; ?> <?php echo $_SESSION['lastname']; ?></small>
                    </h1>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <?php
                            if (!empty($edit_user_query)) {
                                echo "<p class='text-success'>Profile Successfully Updated: <a href='admin_users.php'>View Users</a></p>";
                            }
                            ?>
                            <label for="user_firstname">Firstname</label>
                            <input type="text" name="user_firstname" class="form-control" value="<?php echo $user_firstname; ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_lastname">Lastname</label>
                            <input type="text" name="user_lastname" class="form-control" value="<?php echo $user_lastname; ?>">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input type="text" name="user_email" class="form-control" value="<?php echo $user_email; ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input type="password" name="user_password" class="form-control" value="<?php echo $user_password; ?>">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="edit_profile" value="Update Profile">
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <!-- footer codes -->
    <?php include "includes/admin_footer.php"; ?>