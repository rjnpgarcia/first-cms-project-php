<!-- header codes -->
<?php include "includes/admin_header.php"; ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <small><?php echo checkUserAdmin($_SESSION['username']) ? 'Role: ADMIN' : 'ROLE: SUBSCRIBER'; ?></small>
                    <h1 class="page-header">
                        <?php echo checkUserAdmin($_SESSION['username']) ? 'Welcome to the ADMIN' : 'Welcome to your DATA'; ?>
                        <small><?php echo $_SESSION['firstname']; ?> <?php echo $_SESSION['lastname']; ?></small>
                    </h1>
                    <?php
                    if (isset($_GET['source'])) {
                        $source = mysqli_real_escape_string($connection, $_GET['source']);
                    } else {
                        $source = "";
                    }
                    switch ($source) {
                        case "add_post":
                            include "includes/add_post.php";
                            break;

                        case "edit_post":
                            include "includes/edit_post.php";
                            break;

                        default:
                            include "includes/view_all_posts.php";
                            break;
                    }


                    ?>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <!-- footer codes -->
    <?php include "includes/admin_footer.php"; ?>