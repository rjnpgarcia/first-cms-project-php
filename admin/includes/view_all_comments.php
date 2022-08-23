<!-- ADMIN ALL POSTS TABLE -->
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In response to</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM comments";
        $select_comments = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_comments)) {
            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_content = $row['comment_content'];
            $comment_email = $row['comment_email'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];


            echo "<tr>";
            echo "<td>$comment_id</td>";
            echo "<td>$comment_author</td>";
            echo "<td>$comment_content</td>";
            echo "<td>$comment_email</td>";
            echo "<td>$comment_status</td>";

            //  Query for "In Response to"
            $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
            $select_post_id = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_post_id)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];

                echo "<td><a href='../post.php?p_id=$post_id' target='_blank'>$post_title</a></td>";
            }

            echo "<td>$comment_date</td>";
            echo "<td><a href='admin_comments.php?approve=$comment_id'>Approve</a></td>";
            echo "<td><a href='admin_comments.php?unapprove=$comment_id'>Unapprove</a></td>";
            echo "<td><a href='admin_comments.php?delete=$comment_id'>Delete</a></td>";
            echo "</tr>";
        }

        //  STATUS QUERY (Approve / Unapprove)
        // APPROVE
        if (isset($_GET['approve'])) {
            $comment_id_approve = $_GET['approve'];
            $query = "UPDATE comments SET comment_status = 'approve' WHERE comment_id = $comment_id_approve";
            mysqli_query($connection, $query);
            header('Location: admin_comments.php');
        }

        // UNAPPROVE
        if (isset($_GET['unapprove'])) {
            $comment_id_unapprove = $_GET['unapprove'];
            $query = "UPDATE comments SET comment_status = 'unapprove' WHERE comment_id = $comment_id_unapprove";
            mysqli_query($connection, $query);
            header('Location: admin_comments.php');
        }


        //  DELETE COMMENT QUERY
        deleteComment();

        ?>


    </tbody>
</table>