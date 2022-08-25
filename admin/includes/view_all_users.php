<!-- ADMIN ALL POSTS TABLE -->
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
            <th colspan="3">Options</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM users";
        $select_users = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_users)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];


            echo "<tr>";
            echo "<td>$user_id</td>";
            echo "<td>$username</td>";
            echo "<td>$user_firstname</td>";
            echo "<td>$user_lastname</td>";
            echo "<td>$user_email</td>";
            echo "<td>$user_role</td>";
            echo "<td><a href='admin_users.php?approve=$user_id'>Approve</a></td>";
            echo "<td><a href='admin_users.php?unapprove=$user_id'>Unapprove</a></td>";
            echo "<td><a href='admin_users.php?delete=$user_id'>Delete</a></td>";
            echo "</tr>";
        }

        //  STATUS QUERY (Approve / Unapprove)
        // APPROVE
        if (isset($_GET['approve'])) {
            $comment_id_approve = $_GET['approve'];
            $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $comment_id_approve";
            mysqli_query($connection, $query);
            header('Location: admin_comments.php');
        }

        // UNAPPROVE
        if (isset($_GET['unapprove'])) {
            $comment_id_unapprove = $_GET['unapprove'];
            $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $comment_id_unapprove";
            mysqli_query($connection, $query);
            header('Location: admin_comments.php');
        }


        //  DELETE USER QUERY
        if (isset($_GET['delete'])) {
            $user_id_delete = $_GET['delete'];
            $query = "DELETE FROM users WHERE user_id = $user_id_delete";
            mysqli_query($connection, $query);
            header('Location: admin_users.php');
        }

        ?>


    </tbody>
</table>