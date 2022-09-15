<?php
// For READ USER QUERY
if (isset($_GET['u_id'])) {
    $user_id_edit = $_GET['u_id'];

    $query = "SELECT * FROM users WHERE user_id = $user_id_edit";
    $edit_user_query = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($edit_user_query)) {
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_role = $row['user_role'];
        $username = $row['username'];
        $user_email = $row['user_email'];
        $user_password = $row['user_password'];
    }


    //  UPDATE USER QUERY
    if (isset($_POST['edit_user'])) {
        $new_user_firstname = $_POST['user_firstname'];
        $new_user_lastname = $_POST['user_lastname'];
        $new_user_role = $_POST['user_role'];
        $new_username = $_POST['username'];
        $new_user_password = $_POST['user_password'];
        $new_user_email = $_POST['user_email'];

        // (OLD SYSTEM) password encryption
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



        $query = "UPDATE users SET user_firstname = '$new_user_firstname', user_lastname = '$new_user_lastname', user_role = '$new_user_role', username = '$new_username', user_password = '$new_user_password', user_email = '$new_user_email' WHERE user_id = $user_id_edit";

        $edit_user_query = mysqli_query($connection, $query);

        if (!$edit_user_query) {
            die('QUERY FAILED' . mysqli_error($connection));
        }
        echo "<p class='text-success'>User Successfully Updated: <a href='admin_users.php'>View Users</a></p>";
    }
} else {
    header('Location: ../admin/index.php');
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" name="user_firstname" class="form-control" value="<?php echo $user_firstname; ?>">
    </div>
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" name="user_lastname" class="form-control" value="<?php echo $user_lastname; ?>">
    </div>
    <div class="form-group">
        <label for="user_role">User Role</label><br>
        <select name="user_role" id="">
            <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
            <?php
            if ($user_role === 'admin') {
                echo "<option value='subscriber'>subscriber</option>";
            } else {
                echo "<option value='admin'>admin</option>";
            }
            ?>
        </select>
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
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>
</form>