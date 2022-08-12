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
                    <h1 class="page-header">
                        Welcome to ADMIN
                        <small>Administrator</small>
                    </h1>
                    <div class="col-xs-6">
                        <?php
                        if (isset($_POST['submit'])) {
                            $cat_title = $_POST['cat_title'];

                            if ($cat_title == "" || empty($cat_title)) {
                                echo "This field should not be empty";
                            } else {
                                $query = "INSERT INTO categories(cat_title) VALUE ('$cat_title')";
                                $create_category_query = mysqli_query($connection, $query);

                                if (!$create_category_query) {
                                    die('QUERY FAILED' . mysqli_error($connection));
                                }
                            }
                        }








                        ?>
                        <div class="form-group">
                            <label for="cat-title">Add Category</label>
                            <form action="" method="post">
                                <input type="text" name="cat_title" class="form-control">

                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                        </div>
                        </form>
                    </div> <!-- Add Category Form -->
                </div>
                <div class="col-xs-6">
                    <?php
                    // FIND ALL CATEGORIES QUERY
                    $query = "SELECT * FROM categories";
                    $select_categories = mysqli_query($connection, $query);

                    // DELETE QUERY
                    if (isset($_GET['delete'])) {
                        $cat_id_delete = $_GET['delete'];
                        $query = "DELETE FROM categories WHERE cat_id = $cat_id_delete";
                        header("Location: admin_categories.php");
                    }
                    ?>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Title</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($select_categories)) {
                                $cat_id = $row['cat_id'];
                                $cat_title = $row['cat_title'];
                                echo "<tr><td>$cat_id</td>";
                                echo "<td>$cat_title</td>";
                                echo "<td><a href='admin_categories.php?delete=$cat_id'>Delete</a></td></tr>";
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <!-- footer codes -->
    <?php include "includes/admin_footer.php"; ?>