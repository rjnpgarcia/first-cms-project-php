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
                </div>
            </div>
            <!-- /.row -->

            <!-- /.row -->

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <!-- Post Count -->
                                    <div class='huge'><?php echo $post_count = userPostCount($_SESSION['username']); ?></div>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="admin_posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <!-- Comment Count -->
                                    <div class='huge'><?php echo $comment_count = userCommentCounts($_SESSION['username']); ?></div>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="admin_comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <!-- Category Count -->
                                    <div class='huge'><?php echo $category_count = userCategoryCount($_SESSION['user_id']); ?></div>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="admin_categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Dashboard Column Graph -->
            <?php
            // for Published Post Count
            $published_count = checkUserPostStatus($_SESSION['username'], 'published');
            // for Draft Post Count
            $draft_count = checkUserPostStatus($_SESSION['username'], 'draft');
            // for Approved Comment Count
            $approved_count = checkUserCommentsStatus($_SESSION['username'], 'approved');
            // for Unapproved Comment Count
            $unapproved_count = checkUserCommentsStatus($_SESSION['username'], 'unapproved');
            ?>
            <div class="row">
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['bar']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count'],
                            <?php
                            //  For Graph Elements
                            $element_title = ['All Posts', 'Published Post', 'Draft Post', 'All Comments', 'Approved', 'Unapproved', 'Categories'];
                            $element_count = [$post_count, $published_count, $draft_count, $comment_count, $approved_count, $unapproved_count, $category_count];
                            for ($i = 0; $i < 7; $i++) {
                                echo "['$element_title[$i]', $element_count[$i]],";
                            }

                            ?>
                        ]);

                        var options = {
                            chart: {
                                title: 'Title',
                                subtitle: 'Subtitle',
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>
                <div id="columnchart_material" style="width: auto; height: 500px;"></div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <!-- footer codes -->
    <?php include "includes/admin_footer.php"; ?>