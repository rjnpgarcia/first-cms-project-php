<div class="col-md-4">
    <!-- Login form -->
    <?php if (isset($_SESSION['user_role'])) : ?>
        <div class="well">
            <h4>Logged in as: <?php echo strtoupper($_SESSION['username']); ?></h4>
            <a href="/demo/cms/first-cms-project-php/includes/logout.php" class="btn btn-primary btn-xs">Logout</a>
        </div>
    <?php endif; ?>

    <!-- Blog Search Well -->
    <form action="search.php" method="post">
        <div class="well">
            <h4>Blog Search</h4>
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </div>
    </form> <!-- Search bar -->
    <!-- Blog Search Well -->

    <!-- /.input-group -->


    <!-- Blog Categories Well -->
    <div class="well">
        <?php
        $query = "SELECT * FROM categories";
        $selectSidebarCategories = mysqli_query($connection, $query);
        ?>
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    while ($row = mysqli_fetch_assoc($selectSidebarCategories)) {
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];

                        echo "<li><a href='/demo/cms/first-cms-project-php/category/$cat_id'>$cat_title</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "widget.php"; ?>
</div>
</div>