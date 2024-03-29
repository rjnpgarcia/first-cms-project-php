<?php

if (isset($_POST['create_post'])) {
    $post_title = mysqli_real_escape_string($connection, $_POST['post_title']);
    $post_category_id = mysqli_real_escape_string($connection, $_POST['post_category_id']);
    $post_status = mysqli_real_escape_string($connection, $_POST['post_status']);
    $post_author = $_SESSION['username'];

    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];

    $post_tags = mysqli_real_escape_string($connection, $_POST['post_tags']);
    $post_content = mysqli_real_escape_string($connection, $_POST['post_content']);
    $post_date = date('d-m-y');


    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) VALUES ('$post_category_id', '$post_title', '$post_author', now(), '$post_image', '$post_content', '$post_tags', '$post_status')";

    $create_post_query = mysqli_query($connection, $query);
    if (!$create_post_query) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
    $the_post_id = mysqli_insert_id($connection);
    echo "<p class='text-success'>Post Successfully Added: <a href='/demo/cms/first-cms-project-php/post/$the_post_id'>View Post</a> or <a href='../admin/admin_posts.php'>Edit More Posts</a></p>";
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" name="post_title" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_category_id">Post Category</label><br>
        <select name="post_category_id" id="">
            <?php
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<option value='$cat_id'>$cat_title</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_author">Post Author:</label>
        <input type="text" name="post_author" class="form-control" value="<?php echo $_SESSION['username']; ?>" disabled>
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label><br>
        <select name="post_status" id="">
            <option value="draft">draft</option>
            <option value="published">published</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" name="post_tags" class="form-control">
    </div>
    <div class="form-group">
        <label for="summernote">Post Content</label>
        <textarea name="post_content" class="form-control" id="summernote" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
    </div>
</form>