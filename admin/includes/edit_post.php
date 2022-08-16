<?php
if (isset($_GET['p_id'])) {
    $post_id_edit = $_GET['p_id'];

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
    }
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" name="post_title" class="form-control" value="<?php echo "$post_title"; ?>">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category</label><br>
        <select name="post_category" id="post_category">
            <?php
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);
            confirmQuery($select_categories);
            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<option value='$cat_id'>$cat_title</option>";
            }
            ?>
        </select>
    </div>
    <div class=" form-group">
        <label for="post_author">Post Author</label>
        <input type="text" name="post_author" class="form-control" value="<?php echo "$post_author"; ?>">
    </div>
    <div class=" form-group">
        <label for="post_status">Post Status</label>
        <input type="text" name="post_status" class="form-control" value="<?php echo "$post_status"; ?>">
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
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" id="" cols="30" rows="10"><?php echo "$post_content"; ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Update Post">
    </div>
</form>