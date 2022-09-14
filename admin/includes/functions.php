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
        $cat_title = $_POST['cat_title'];

        if ($cat_title == "" || empty($cat_title)) {
            echo "<p class='text-danger'>This field should not be empty</p>";
        } else {
            $query = "INSERT INTO categories(cat_title) VALUE ('$cat_title')";
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
    $query = "SELECT * FROM categories";
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
        $cat_id_delete = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = '$cat_id_delete'";
        mysqli_query($connection, $query);
        header("Location: admin_categories.php");
    }
}

//  DELETE POST QUERY
function deletePost()
{
    global $connection;
    if (isset($_GET['delete'])) {
        $post_id_delete = $_GET['delete'];
        $query = "DELETE FROM posts WHERE post_id = '$post_id_delete'";
        mysqli_query($connection, $query);
        header("Location: admin_posts.php");
    }
}

//  DELETE COMMENT QUERY
function deleteComment()
{
    global $connection;
    if (isset($_GET['delete'])) {
        $comment_id_delete = $_GET['delete'];
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
