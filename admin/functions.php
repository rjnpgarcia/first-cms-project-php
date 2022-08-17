<?php

//  CONFIRM QUERY CONNECTION FUNCTION
function confirmQuery($result)
{
    global $connection;

    if (!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

function confirmQueryAlert($result)
{
    global $connection;

    if ($result) {
        echo "Successfully Added";
    } else {
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
            echo "This field should not be empty";
        } else {
            $query = "INSERT INTO categories(cat_title) VALUE ('$cat_title')";
            $create_category_query = mysqli_query($connection, $query);

            if ($create_category_query) {
                echo "Category succesfully added";
            } else {
                die('QUERY FAILED' . mysqli_error($connection));
            }
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
        echo "<td><a href='admin_categories.php?delete=$cat_id'>Delete</a></td>";
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
