 <?php
    // for Bulk Options Query
    if (isset($_POST['checkBoxArray'])) {
        foreach ($_POST['checkBoxArray'] as $checkBoxPostId) {
            $bulk_option = mysqli_real_escape_string($connection, $_POST['bulk_option']);
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
                    $comments_delete_query = "DELETE FROM comments WHERE comment_post_id = $checkBoxPostId";
                    $comments_delete = mysqli_query($connection, $comments_delete_query);
                    confirmQuery($comments_delete);
                    break;
                case "clone":
                    $query = "SELECT * FROM posts WHERE post_id = $checkBoxPostId";
                    $select_clone_query = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($select_clone_query)) {
                        $post_author = $row['post_author'];
                        $post_title = $row['post_title'];
                        $post_category_id = $row['post_category_id'];
                        $post_status = $row['post_status'];
                        $post_image = $row['post_image'];
                        $post_tags = $row['post_tags'];
                        $post_date = $row['post_date'];
                        $post_content = $row['post_content'];
                    }
                    $query = "INSERT INTO posts(post_author, post_title, post_category_id, post_status, post_image, post_tags, post_date, post_content) VALUES ('$post_author', '$post_title', '$post_category_id', '$post_status', '$post_image', '$post_tags', now(), '$post_content')";
                    $clone_query = mysqli_query($connection, $query);
                    confirmQuery($clone_query);
                    break;

                case "reset":
                    $query = "UPDATE posts SET post_view_count = 0 WHERE post_id = $checkBoxPostId";
                    $reset_view_query = mysqli_query($connection, $query);
                    confirmQuery($reset_view_query);
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
                 <option value="clone">Clone</option>
                 <option value="reset">Reset Views</option>
             </select>

         </div>
         <div class="col-xs-4">
             <input onclick="return confirm('Confirm Action?')" type="submit" name="submit" class="btn btn-success" value="Apply"> <a href="../admin/admin_posts.php?source=add_post" class="btn btn-primary">Add New Post</a>
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
                 <th>Views</th>
                 <th>Date</th>
                 <th colspan="3">Options</th>
             </tr>
         </thead>
         <tbody>
             <?php
                //  READ QUERY
                // Alternative way by JOINING TABLES
                $query = "SELECT posts.post_id, posts.post_author, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, posts.post_tags, posts.post_view_count, posts.post_date, categories.cat_id, categories.cat_title FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";
                // $query = "SELECT * FROM posts ORDER BY post_id DESC";
                $select_posts = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_posts)) {
                    $post_id = $row['post_id'];
                    $post_author = $row['post_author'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_view_count = $row['post_view_count'];
                    $post_date = $row['post_date'];
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    //  TO DISPLAY CATEGORY
                    // $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                    // $select_category = mysqli_query($connection, $query);
                    // while ($row = mysqli_fetch_assoc($select_category)) {
                    //     $cat_title = $row['cat_title'];
                    // }

                    // NEW query for post comment count
                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                    $comment_count_query = mysqli_query($connection, $query);
                    confirmQuery($comment_count_query);
                    $post_comment_count = mysqli_num_rows($comment_count_query);

                    $send_query = "UPDATE posts SET post_comment_count = $post_comment_count WHERE post_id = $post_id";
                    $comment_count = mysqli_query($connection, $send_query);
                    confirmQuery($comment_count);

                    echo "<tr>";
                    echo "<td><input type='checkbox' name='checkBoxArray[]' class='checkBoxes' value='$post_id'></td>";
                    echo "<td>$post_id</td>";
                    echo "<td>$post_author</td>";
                    echo "<td>$post_title</td>";
                    echo "<td>$cat_title</td>";
                    echo "<td>$post_status</td>";
                    echo "<td><img width='100px' src='../images/$post_image' alt='post image'></td>";
                    echo "<td>$post_tags</td>";

                    echo "<td><a href='admin_comments.php?source=post_comments&c_id=$post_id'>$post_comment_count</a></td>";
                    echo "<td>$post_view_count</td>";
                    echo "<td>$post_date</td>";
                    echo "<td><a class='btn btn-primary btn-sm' href='../post.php?p_id=$post_id'>View</a></td>";
                    echo "<td><a class='btn btn-info btn-sm' href='admin_posts.php?source=edit_post&p_id=$post_id'>Edit</a></td>";
                    echo "<td><a class='btn btn-danger btn-sm' onClick=\"javascript: return confirm('Delete confirm?');\" href='admin_posts.php?delete=$post_id'>Delete</a></td>";
                    echo "</tr>";
                }

                //  DELETE POST QUERY
                deletePost();
                ?>
         </tbody>
     </table>
 </form>