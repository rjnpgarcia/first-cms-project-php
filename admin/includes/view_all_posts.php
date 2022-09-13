 <?php
    // for Bulk Options Query
    if (isset($_POST['checkBoxArray'])) {
        foreach ($_POST['checkBoxArray'] as $checkBoxPostId) {
            $bulk_option = $_POST['bulk_option'];
            switch ($bulk_option) {
                case "published":
                    $query = "UPDATE posts SET post_status = '$bulk_option' WHERE post_id = $checkBoxPostId";
                    $published_query = mysqli_query($connection, $query);
                    confirmQuery($published_query);
                    break;
                case "draft":
                    $query = "UPDATE posts SET post_status = '$bulk_option' WHERE post_id = $checkBoxPostId";
                    $draft_query = mysqli_query($connection, $query);
                    confirmQuery($draft_query);
                    break;
                case "delete":
                    $query = "DELETE FROM posts WHERE post_id = $checkBoxPostId";
                    $delete_query = mysqli_query($connection, $query);
                    confirmQuery($delete_query);
                    break;
            }
        }
    }

    ?>

 <form action="" method="post">
     <!-- ADMIN ALL POSTS TABLE -->
     <table class="table table-bordered table-hover">
         <!-- Bulk Options Selector -->
         <div id="bulkOptionContainer" class="col-xs-4">
             <select name="bulk_option" id="" class="form-control">
                 <option value="">Select Options</option>
                 <option value="published">Publish</option>
                 <option value="draft">Draft</option>
                 <option value="delete">Delete</option>
             </select>

         </div>
         <div class="col-xs-4">
             <input type="submit" name="submit" class="btn btn-success" value="Apply"> <a href="../admin/admin_posts.php?source=add_post" class="btn btn-primary">Add New Post</a>
         </div>
         <thead>
             <tr>
                 <th><input type="checkbox" id="selectAllBoxes"></th>
                 <th>ID</th>
                 <th>Author</th>
                 <th>Title</th>
                 <th>Category</th>
                 <th>Status</th>
                 <th>Image</th>
                 <th>Tags</th>
                 <th>Comments</th>
                 <th>Date</th>
                 <th colspan="3">Options</th>
             </tr>
         </thead>
         <tbody>
             <?php
                //  READ QUERY
                $query = "SELECT * FROM posts";
                $select_posts = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_posts)) {
                    $post_id = $row['post_id'];
                    $post_author = $row['post_author'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_date = $row['post_date'];

                    //  TO DISPLAY CATEGORY
                    $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                    $select_category = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($select_category)) {
                        $cat_title = $row['cat_title'];
                    }
                    echo "<tr>";
                    echo "<td><input type='checkbox' name='checkBoxArray[]' class='checkBoxes' value='$post_id'></td>";
                    echo "<td>$post_id</td>";
                    echo "<td>$post_author</td>";
                    echo "<td>$post_title</td>";
                    echo "<td>$cat_title</td>";
                    echo "<td>$post_status</td>";
                    echo "<td><img width='100px' src='../images/$post_image' alt='post image'></td>";
                    echo "<td>$post_tags</td>";
                    echo "<td>$post_comment_count</td>";
                    echo "<td>$post_date</td>";
                    echo "<td><a href='../post.php?p_id=$post_id'>View</a></td>";
                    echo "<td><a href='admin_posts.php?source=edit_post&p_id=$post_id'>Edit</a></td>";
                    echo "<td><a onClick=\"javascript: return confirm('Delete confirm?');\" href='admin_posts.php?delete=$post_id'>Delete</a></td>";
                    echo "</tr>";
                }

                //  DELETE POST QUERY
                deletePost();
                ?>
         </tbody>
     </table>
 </form>