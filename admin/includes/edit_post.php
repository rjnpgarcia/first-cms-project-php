<?php

if (isset($_GET['p_id'])) {
    $post_id_edit = mysqli_real_escape_string($connection, $_GET['p_id']);

    $query = "SELECT * FROM posts WHERE post_id = $post_id_edit";
    $select_posts_edit = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_posts_edit)) {
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_content = $row['post_content'];
        $post_id = $row['post_id'];
    }
    if (!isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin' || $_SESSION['username'] !== $post_author) {
        header('Location: admin_posts.php');
    }
}

if (isset($_POST['update_post'])) {
    $post_title = mysqli_real_escape_string($connection, $_POST['post_title']);
    $post_category_id = mysqli_real_escape_string($connection, $_POST['post_category_id']);
    $post_status = mysqli_real_escape_string($connection, $_POST['post_status']);

    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];

    $post_tags = mysqli_real_escape_string($connection, $_POST['post_tags']);
    $post_content = mysqli_real_escape_string($connection, $_POST['post_content']);
    $post_date = date('d-m-y');

    move_uploaded_file($post_image_temp, "../images/$post_image");

    if (empty($post_image)) {
        $query = "SELECT * FROM posts WHERE post_id = $post_id_edit";
        $select_image = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_image)) {
            $post_image = $row['post_image'];
        }
    }

    $query = "UPDATE posts SET post_title = '$post_title', post_category_id = '$post_category_id', post_status = '$post_status', post_image = '$post_image', post_tags = '$post_tags', post_date = now(), post_content = '$post_content' WHERE post_id = $post_id_edit";

    $update_post = mysqli_query($connection, $query);
    confirmQuery($update_post);
    echo "<p class='text-success'>Post Successfully Updated: <a href='../post.php?p_id=$post_id'>View post</a> or <a href='../admin/admin_posts.php'>Edit more posts</a></p>";
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" name="post_title" class="form-control" value="<?php echo "$post_title"; ?>">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category</label><br>
        <select name="post_category_id" id="">
            <?php
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);
            confirmQuery($select_categories);
            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                if ($cat_id == $post_category_id) {
                    echo "<option selected value='$cat_id'>$cat_title</option>";
                } else {
                    echo "<option value='$cat_id'>$cat_title</option>";
                }
            }
            ?>
        </select>
    </div>
    <div class=" form-group">
        <label for="post_author">Post Author</label>
        <input type="text" name="post_author" class="form-control" value="<?php echo "$post_author"; ?>" disabled>
    </div>
    <div class=" form-group">
        <label for="post_status">Post Status</label><br>
        <select name="post_status" id="">
            <option value="<?php echo "$post_status"; ?>"><?php echo "$post_status"; ?></option>
            <?php
            if ($post_status === 'draft') {
                echo "<option value='published'>published</option>";
            } else {
                echo "<option value='draft'>draft</option>";
            }
            ?>
        </select>
    </div>
    <div class=" form-group">
        <label for="post_image">Post Image</label><br>
        <img width="200px" src="../images/<?php echo "$post_image"; ?>" alt="post image">
        <input type="file" name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" name="post_tags" class="form-control" value="<?php echo "$post_tags"; ?>">
    </div>
    <div class=" form-group">
        <label for="summernote">Post Content</label>
        <textarea name="post_content" class="form-control" id="summernote" cols="30" rows="10"><?php echo "$post_content"; ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>
</form>