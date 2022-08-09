<div class="col-md-4">
    <!-- For Search Engine -->
    <?php
    if (isset($_POST['submit'])) {
        $search = $_POST['search'];
        $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
        $searchQuery = mysqli_query($connection, $query);

        if (!$searchQuery) {
            die("Search Query Failed" . mysqli_error($connection));
        }
        // TO TEST IF SEARCH IS WORKING
        // $count = mysqli_num_rows($searchQuery);
        // if ($count == 0) {
        //     echo "NO RESULT";
        // } else {
        //     echo "FOUND RESULT";
        // }
    }

    ?>

    <!-- Blog Search Well -->
    <form action="" method="post">
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
    </form> <!-- Search bar -->
    <!-- /.input-group -->
</div>

<!-- Blog Categories Well -->
<div class="well">
    <h4>Blog Categories</h4>
    <div class="row">
        <div class="col-lg-6">
            <ul class="list-unstyled">
                <li><a href="#">Category Name</a>
                </li>
                <li><a href="#">Category Name</a>
                </li>
                <li><a href="#">Category Name</a>
                </li>
                <li><a href="#">Category Name</a>
                </li>
            </ul>
        </div>
        <!-- /.col-lg-6 -->
        <div class="col-lg-6">
            <ul class="list-unstyled">
                <li><a href="#">Category Name</a>
                </li>
                <li><a href="#">Category Name</a>
                </li>
                <li><a href="#">Category Name</a>
                </li>
                <li><a href="#">Category Name</a>
                </li>
            </ul>
        </div>
        <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->
</div>

<!-- Side Widget Well -->
<div class="well">
    <h4>Side Widget Well</h4>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
</div>

</div>