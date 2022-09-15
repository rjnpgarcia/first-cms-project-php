<?php
//  CREATE USER QUERY
if (isset($_POST['create_user'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    $username = $_POST['username'];
    $user_password = $_POST['user_password'];
    $user_email = $_POST['user_email'];

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
    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, ['cost' => 10]);

    $query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) VALUES ('$user_firstname', '$user_lastname', '$user_role', '$username', '$user_email', '$hashed_password')";
    $create_user_query = mysqli_query($connection, $query);
    confirmQuery($create_user_query);
    echo "<p class='text-success'>User Successfully Added: <a href='admin_users.php'>View Users</a></p>";
}


?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" name="user_firstname" class="form-control">
    </div>
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" name="user_lastname" class="form-control">
    </div>
    <div class="form-group">
        <label for="user_role">User Role</label><br>
        <select name="user_role" id="">
            <option value="subscriber">SELECT OPTION</option>
            <option value="admin">admin</option>
            <option value="subscriber">subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" class="form-control">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="text" name="user_email" class="form-control">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" name="user_password" class="form-control">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
    </div>
</form>