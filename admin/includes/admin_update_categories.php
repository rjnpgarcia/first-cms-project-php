<!-- UPDATE CATEGORY -->
<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Category</label>
        <?php
        if (isset($_GET['edit'])) {
            $cat_id = $_GET['edit'];
            $query = "SELECT * FROM categories WHERE cat_id = '$cat_id'";
            $select_cat_title = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_cat_title)) {
                $cat_title = $row['cat_title'];
        ?>

                <input value="<?php if (isset($cat_title)) {
                                    echo "$cat_title";
                                } ?>" type="text" name="cat_title" class="form-control">

        <?php }
            if (isset($_POST['update_category'])) {
                $cat_title_update = $_POST['cat_title'];
                $query = "UPDATE categories SET cat_title = '$cat_title_update' WHERE cat_id = '$cat_id'";
                $cat_update_query = mysqli_query($connection, $query);
                if (!$cat_update_query) {
                    die('Update Query Failed' . mysqli_error($connection));
                }
                echo "Category Successfully Updated: <a href='../admin/admin_categories.php'>View Category</a>";
            }
        }
        ?>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
    </div>
</form>