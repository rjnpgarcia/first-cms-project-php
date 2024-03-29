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
                DEV TALKS
                <small>we can echo anything!</small>
            </h1>

            <!-- First Blog Post -->
            <?php
            if (isset($_GET['category'])) {
                $post_category_id = mysqli_real_escape_string($connection, $_GET['category']);

                // Pagination query
                $per_page = 4;

                if (isset($_GET['page'])) {
                    $page = mysqli_real_escape_string($connection, $_GET['page']);
                } else {
                    $page = "";
                }
                if ($page === "" || $page === 1) {
                    $page_1 = 0;
                } else {
                    $page_1 = ($page * $per_page) - $per_page;
                }

                // To display all (published and draft) for Admin only
                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                    $post_count_query = "SELECT * FROM posts WHERE post_category_id = $post_category_id";
                    $find_count = mysqli_query($connection, $post_count_query);
                    $post_count = (mysqli_num_rows($find_count));
                    if ($post_count < 1) {
                        echo "<h1 class='text-center'>No posts available</h1>";
                    }
                    $post_count = ceil($post_count / $per_page);

                    $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id ORDER BY post_id DESC LIMIT $page_1, $per_page";
                    $selectAllPosts = mysqli_query($connection, $query);
                } else {
                    $post_count_query = "SELECT * FROM posts WHERE post_category_id = $post_category_id AND post_status = 'published'";
                    $find_count = mysqli_query($connection, $post_count_query);
                    $post_count = (mysqli_num_rows($find_count));
                    if ($post_count < 1) {
                        echo "<h1 class='text-center'>No posts available</h1>";
                    }
                    $post_count = ceil($post_count / $per_page);

                    $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id AND post_status = 'published' ORDER BY post_id DESC LIMIT $page_1, $per_page";
                    $selectAllPosts = mysqli_query($connection, $query);
                }
                while ($row = mysqli_fetch_assoc($selectAllPosts)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'], 0, 200);
                    $post_status = $row['post_status'];
                    // Draft post indicator
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
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                    <hr>
                    <a href="/demo/cms/first-cms-project-php/post/<?php echo $post_id; ?>">
                        <img class="img-responsive" src="/demo/cms/first-cms-project-php/images/<?php echo imagePlaceholder($post_image); ?>" alt="">
                    </a>
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="/demo/cms/first-cms-project-php/post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>
            <?php
                }
            } else {
                header('Location: index.php');
            }
            ?>
            <!-- Pagination links -->
            <ul class="pagination">
                <?php
                for ($i = 1; $i <= $post_count; $i++) {
                    if ($i == $page || ($i == 1 && $page == null)) {
                        echo "<li class='active'><a href='category.php?category=$post_category_id&page=$i'>$i</a></li>";
                    } else {
                        echo "<li><a href='category.php?category=$post_category_id&page=$i'>$i</a></li>";
                    }
                }
                ?>
            </ul>

        </div>


        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

    <hr>
    <!-- Footer -->
    <?php include "includes/footer.php"; ?>