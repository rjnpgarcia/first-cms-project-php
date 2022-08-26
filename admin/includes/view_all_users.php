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
            <th colspan="4">Options</th>
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
            echo "<td><a href='admin_users.php?change_to_admin=$user_id'>Admin</a></td>";
            echo "<td><a href='admin_users.php?change_to_sub=$user_id'>Subscriber</a></td>";
            echo "<td><a href='admin_users.php?source=edit_user&u_id=$user_id'>Edit</a></td>";
            echo "<td><a href='admin_users.php?delete=$user_id'>Delete</a></td>";
            echo "</tr>";
        }

        //  CHANGE USER ROLE QUERY (Admin / Subscriber)
        // ADMIN
        if (isset($_GET['change_to_admin'])) {
            $user_id_admin = $_GET['change_to_admin'];
            $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $user_id_admin";
            mysqli_query($connection, $query);
            header('Location: admin_users.php');
        }

        // SUBSCRIBER
        if (isset($_GET['change_to_sub'])) {
            $user_id_sub = $_GET['change_to_sub'];
            $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $user_id_sub";
            mysqli_query($connection, $query);
            header('Location: admin_users.php');
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