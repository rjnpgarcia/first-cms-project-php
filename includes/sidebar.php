<div class="col-md-4">

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

    <!-- Login form -->
    <?php if (isset($_SESSION['user_role'])) : ?>
        <div class="well">
            <h4>Logged in as: <?php echo $_SESSION['username']; ?></h4>
            <a href="includes/logout.php" class="btn btn-primary btn-xs">Logout</a>
        </div>
    <?php else : ?>
        <form action="includes/login.php" method="post">
            <div class="well">
                <h4>Login</h4>
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Enter Username">
                </div>
                <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="Enter Password">
                </div>
                <div class="form-group">
                    <input name="login" type="submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    <?php endif; ?>
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

                        echo "<li><a href='category.php?category=$cat_id'>$cat_title</a></li>";
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