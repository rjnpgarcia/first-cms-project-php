<!-- Header -->
<?php include "includes/header.php"; ?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>


<?php
// for LIKE
if (isset($_POST['liked'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    $query = "SELECT * FROM posts WHERE post_id = $post_id";
    $postResult = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($postResult);
    $likes = $row['likes'];

    mysqli_query($connection, "UPDATE posts SET likes = $likes+1 WHERE post_id = $post_id");

    mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES ($user_id, $post_id)");
    exit();
}

// for UNLIKE
if (isset($_POST['unliked'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    $query = "SELECT * FROM posts WHERE post_id = $post_id";
    $postResult = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($postResult);
    $likes = $row['likes'];

    mysqli_query($connection, "DELETE FROM likes WHERE user_id = $user_id AND post_id = $post_id");
    mysqli_query($connection, "UPDATE posts SET likes = $likes-1 WHERE post_id = $post_id");

    exit();
}

?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">
                DEV TALKS
                <small>we can echo anything!</small>
            </h1>

            <!-- First Blog Post -->
            <?php
            if (isset($_GET['p_id'])) {
                $post = $_GET['p_id'];
                $post = mysqli_real_escape_string($connection, $post);

                // for post view count
                $view_query = "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = $post";
                $send_view_query = mysqli_query($connection, $view_query);
                if (!$send_view_query) {
                    die('QUERY FAILED' . mysqli_error($connection));
                }

                // Display Post Query
                $query = "SELECT * FROM posts WHERE post_id = $post";
                $selectPost = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($selectPost)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
                    $post_status = $row['post_status'];
                    if ($post_status === 'draft') {
                        echo "<h4 class='text-danger'>Status: DRAFT</h4>";
                    }
            ?>
                    <h2>
                        <a href="/demo/cms/first-cms-project-php/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="/demo/cms/first-cms-project-php/author_post.php?author=<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                    <hr>
                    <a href="/demo/cms/first-cms-project-php/post/<?php echo $post_id; ?>">
                        <img class="img-responsive" src="/demo/cms/first-cms-project-php/images/<?php echo imagePlaceholder($post_image); ?>" alt="">
                    </a>
                    <hr>
                    <p><?php echo $post_content ?></p>
                    <hr>
            <?php
                }
            } else {
                header('Location: /demo/cms/first-cms-project-php/index');
            }
            ?>
            <!-- Blog Comments -->

            <!-- For LIKES and UNLIKES -->
            <div class="row">
                <p class="pull-right"><a class="<?php echo userLikedPost($post_id) ? 'unlike' : 'like'; ?>" href=""><span class="glyphicon glyphicon-thumbs-up"><?php echo userLikedPost($post_id) ? ' Unlike' : ' Like'; ?></span></a></p>
            </div>

            <div class="row">
                <p class="pull-right">Likes: 10</p>
            </div>

            <!-- Comments Form -->
            <?php
            if (isset($_POST['create_comment'])) {
                $post = mysqli_real_escape_string($connection, $_GET['p_id']);

                $comment_author = mysqli_real_escape_string($connection, $_POST['comment_author']);
                $comment_email = mysqli_real_escape_string($connection, $_POST['comment_email']);
                $comment_content = mysqli_real_escape_string($connection, $_POST['comment_content']);
                if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                    $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ($post, '$comment_author', '$comment_email', '$comment_content', 'unapproved', now())";

                    $create_comment = mysqli_query($connection, $query);
                    if (!$create_comment) {
                        die("QUERY FAILED" . mysqli_error($connection));
                    }
                    //  (OLD) QUERY FOR COMMENT COUNT
                    // $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $post";
                    // $update_comment_count = mysqli_query($connection, $query);
                    // if (!$update_comment_count) {
                    //     die("QUERY FAILED" . mysqli_error($connection));
                    // }

                    // For Notification
                    $message = "<p class='text-success text-center'>Comment successfully submitted</p>";
                } else {
                    $message = "<p class='text-danger'>This field cannot be empty!</p>";
                }
            } else {
                $message = "";
            }

            ?>

            <div class="well">
                <h4>Leave a Comment:</h4>
                <form action="" method="post" role="form">
                    <?php
                    // Success notification
                    if (!empty($create_comment)) {
                        echo $message;
                    }
                    ?>
                    <div class="form-group">
                        <label for="author">Author</label>
                        <?php
                        // Field empty notif
                        if (empty($comment_author)) {
                            echo $message;
                        }
                        ?>
                        <input type="text" class="form-control" name="comment_author">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <?php
                        // Field empty notif
                        if (empty($comment_email)) {
                            echo $message;
                        }
                        ?>
                        <input type="email" class="form-control" name="comment_email">
                    </div>
                    <div class="form-group">
                        <label for="comment">Your Comment</label>
                        <?php
                        // Field empty notif
                        if (empty($comment_content)) {
                            echo $message;
                        }
                        ?>
                        <textarea name="comment_content" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                </form>
            </div>

            <hr>

            <!-- Posted Comments -->

            <!-- Comment -->
            <?php
            // READ QUERY FOR COMMENTS
            $query = "SELECT * FROM comments WHERE comment_post_id = $post AND comment_status = 'approved' ORDER BY comment_id DESC";
            $select_comment_query = mysqli_query($connection, $query);
            if (!$select_comment_query) {
                die("COMMENT QUERY FAILED" . mysqli_error($connection));
            }
            while ($row = mysqli_fetch_assoc($select_comment_query)) {
                $comment_author = $row['comment_author'];
                $comment_date = $row['comment_date'];
                $comment_content = $row['comment_content'];

            ?>

                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>

            <?php } ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

    <hr>
    <!-- Footer -->
    <?php include "includes/footer.php"; ?>

    <script>
        // for LIKE
        $(document).ready(function() {
            var post_id = <?php echo $post; ?>;
            var user_id = <?php echo $_SESSION['user_id']; ?>;

            $('.like').click(function() {
                $.ajax({
                    url: "/demo/cms/first-cms-project-php/post.php?p_id=<?php echo $post; ?>",
                    type: 'post',
                    data: {
                        'liked': 1,
                        'post_id': post_id,
                        'user_id': user_id
                    }
                })
            })


            // for UNLIKE
            $('.unlike').click(function() {
                $.ajax({
                    url: "/demo/cms/first-cms-project-php/post.php?p_id=<?php echo $post; ?>",
                    type: 'post',
                    data: {
                        'unliked': 1,
                        'post_id': post_id,
                        'user_id': user_id
                    }
                })
            })
        })
    </script>