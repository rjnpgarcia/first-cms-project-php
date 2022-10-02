<?php

//  CONFIRM QUERY CONNECTION FUNCTION
function confirmQuery($result)
{
    global $connection;

    if (!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}


// CREATE CATEGORY QUERY
function createCategory()
{
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = mysqli_real_escape_string($connection, $_POST['cat_title']);
        $cat_user_id = $_SESSION['user_id'];

        if ($cat_title == "" || empty($cat_title)) {
            echo "<p class='text-danger'>This field should not be empty</p>";
        } else {
            $query = "INSERT INTO categories(cat_title, cat_user_id) VALUE ('$cat_title', $cat_user_id)";
            $create_category_query = mysqli_query($connection, $query);

            if (!$create_category_query) {
                die('QUERY FAILED' . mysqli_error($connection));
            }
            echo "Category Successfully Added";
        }
    }
}

// FIND ALL CATEGORIES QUERY
function findAllCategory()
{
    global $connection;
    $query = "SELECT * FROM categories ORDER BY cat_id DESC";
    $select_categories = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>$cat_id</td>";
        echo "<td>$cat_title</td>";
        echo "<td><a onClick=\" javascript: return confirm('Delete confirm?'); \" href='admin_categories.php?delete=$cat_id'>Delete</a></td>";
        echo "<td><a href='admin_categories.php?edit=$cat_id'>Edit</a>";
        echo "</tr>";
    }
}

// FIND USER CATEGORIES QUERY
function findUserCategory($user_id)
{
    global $connection;
    $query = "SELECT * FROM categories WHERE cat_user_id = $user_id ORDER BY cat_id DESC";
    $select_categories = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>$cat_id</td>";
        echo "<td>$cat_title</td>";
        echo "<td><a onClick=\" javascript: return confirm('Delete confirm?'); \" href='admin_categories.php?delete=$cat_id'>Delete</a></td>";
        echo "<td><a href='admin_categories.php?edit=$cat_id'>Edit</a>";
        echo "</tr>";
    }
}

//  DELETE CATEGORY QUERY
function deleteCategory()
{
    global $connection;
    if (isset($_GET['delete'])) {
        $cat_id_delete = mysqli_real_escape_string($connection, $_GET['delete']);
        $query = "DELETE FROM categories WHERE cat_id = '$cat_id_delete'";
        mysqli_query($connection, $query);
        header("Location: admin_categories.php");
    }
}

//  DELETE COMMENT QUERY
function deleteComment()
{
    global $connection;
    if (isset($_GET['delete'])) {
        $comment_id_delete = mysqli_real_escape_string($connection, $_GET['delete']);
        $query = "DELETE FROM comments WHERE comment_id = $comment_id_delete";
        mysqli_query($connection, $query);
        header('Location: admin_comments.php');
    }
}

// Users Online Count
function usersOnline()
{
    if (isset($_GET['onlineusers'])) {
        global $connection;
        if (!$connection) {
            session_start();
            include "../../includes/db.php";

            $session = session_id();
            $time = time();
            $time_out_in_seconds = 30;
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if ($count == null) {
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES ('$session', '$time')");
            } else {
                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }

            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
            echo mysqli_num_rows($users_online_query);
        }
    }
}
usersOnline();

// *****Dashboard Widgets*****
// Table Data Counts
function recordCount($table)
{
    global $connection;
    $query = "SELECT * FROM $table";
    $select_table = mysqli_query($connection, $query);
    return mysqli_num_rows($select_table);
}

// Specific user posts Counts
function userPostCount($username)
{
    global $connection;
    $query = "SELECT * FROM posts WHERE post_author = '$username'";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);
}

//  Specific user comment counts
function userCommentCounts($username)
{
    global $connection;
    $query = "SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE post_author = '$username'";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);
}

// Specific user category counts
function userCategoryCount($user_id)
{
    global $connection;
    $query = "SELECT * FROM categories WHERE cat_user_id = '$user_id'";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);
}

// Data Status for Graph
function checkStatus($table, $column, $status)
{
    global $connection;
    $query = "SELECT * FROM $table WHERE $column = '$status'";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);
}

// Data Status for Posts (Specific user data)
function checkUserPostStatus($username, $status)
{
    global $connection;
    $query = "SELECT * FROM posts WHERE post_status = '$status' AND post_author = '$username'";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);
}

// Data Status for Comments (Specific user data)
function checkUserCommentsStatus($username, $status)
{
    global $connection;
    $query = "SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE post_author = '$username' AND comment_status = '$status'";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);
}

// Detector if user is Admin
function checkUserAdmin($username)
{
    global $connection;
    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    $row = mysqli_fetch_array($result);
    if ($row['user_role'] == 'admin') {
        return true;
    } else {
        return false;
    }
}

// To Prevent Duplicate Username
function checkUsernameExists($username)
{
    global $connection;
    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

// To Prevent Duplicate Email
function checkEmailExists($email)
{
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

// for Register user
function register($username, $email, $password)
{
    global $connection;
    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);
    // NEW SYSTEM for Password Encrytion
    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

    // CREATE registration query
    $query = "INSERT INTO users(username, user_email, user_password, user_role) VALUES ('$username', '$email', '$password', 'subscriber')";
    $register_user_query = mysqli_query($connection, $query);
    confirmQuery($register_user_query);
}

// If it is method
function ifMethod($method)
{
    if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    } else {
        return false;
    }
}

// redirect to location
function redirect($location)
{
    header("Location: $location");
    exit;
}

// Check if user is logged in
function isLoggedIn()
{
    if (isset($_SESSION['user_role'])) {
        return true;
    } else {
        return false;
    }
}

// To check if user is logged in then redirect
function ifUserLoggedRedirect($redirectLocation)
{
    if (isLoggedIn()) {
        redirect($redirectLocation);
    }
}

// for image placeholder
function imagePlaceholder($image)
{
    if (!$image) {
        return 'SM-placeholder.png';
    } else {
        return $image;
    }
}

// for the user_id of the logged-in user
function loggedInUserId()
{
    global $connection;
    if (isLoggedIn()) {
        $username = $_SESSION['username'];
        $result = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username'");
        confirmQuery($result);
        $user = mysqli_fetch_array($result);
        return $user['user_id'];
    } else {
        return false;
    }
}

// to know if user liked the post
function userLikedPost($post_id)
{
    global $connection;
    $user_id = loggedInUserId();
    $result = mysqli_query($connection, "SELECT * FROM likes WHERE user_id = '$user_id' AND post_id = '$post_id'");
    confirmQuery($result);
    return mysqli_num_rows($result) >= 1 ? true : false;
}


// Get the likes count
function getLikesCount($post_id)
{
    global $connection;
    $result = mysqli_query($connection, "SELECT * FROM likes WHERE post_id = $post_id");
    confirmQuery($result);
    return mysqli_num_rows($result);
}
