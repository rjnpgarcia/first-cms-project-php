<!-- Header -->
<?php include "includes/header.php"; ?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>

            <!-- First Blog Post -->
            <?php
            if (isset($_GET['p_id'])) {
                $post = $_GET['p_id'];


                $query = "SELECT * FROM posts WHERE post_id = $post";
                $selectPost = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($selectPost)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
            ?>
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                    <hr>
                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    </a>
                    <hr>
                    <p><?php echo $post_content ?></p>
                    <hr>
            <?php
                }
            }
            ?>
            <!-- Blog Comments -->

            <!-- Comments Form -->
            <?php
            if (isset($_POST['create_comment'])) {
                $post = $_GET['p_id'];

                $comment_author = $_POST['comment_author'];
                $comment_email = $_POST['comment_email'];
                $comment_content = $_POST['comment_content'];

                $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ($post, '$comment_author', '$comment_email', '$comment_content', 'unapproved', now())";

                $create_comment = mysqli_query($connection, $query);
                if ($create_comment) {
                    echo "Comment Successfully Submitted";
                } else {
                    die("QUERY FAILED" . mysqli_error($connection));
                }
                //  QUERY FOR COMMENT COUNT
                $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $post";
                $update_comment_count = mysqli_query($connection, $query);
                if (!$update_comment_count) {
                    die("QUERY FAILED" . mysqli_error($connection));
                }
            }


            ?>

            <div class="well">
                <h4>Leave a Comment:</h4>
                <form action="" method="post" role="form">
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" class="form-control" name="comment_author">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="comment_email">
                    </div>
                    <div class="form-group">
                        <label for="comment">Your Comment</label>
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
    <?php include "includes/footer.php";
