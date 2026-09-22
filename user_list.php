<?php
    //Connect to Database
    $hostname = "localhost";
    $username = "ecpi_user";
    $password = "Password1";
    $dbname = "sdc310_wk3gp";
    $conn = mysqli_connect($hostname, $username, $password, $dbname);

    //Establish variables to support add/edit/delete
    $userNo = -1;
    $firstName = "";
    $lastName = "";
    $email = "";
    $favNum = 0;

    //Variables to determine the type of operation
    $add = false;
    $edit = false;
    $update = false;
    $delete = false;

    if (isset($_POST['user_no'])) {
        $userNo = $_POST['user_no'];
        $add = isset($_POST['add']);
        $update = isset($_POST['update']);
        $edit = isset($_POST['edit']);
        $delete = isset($_POST['delete']);
    }

    if ($add) {
        //Need to add a new user
        $firstName = $_POST['fname'];
        $lastName = $_POST['lname'];
        $email = $_POST['email'];
        $favNum = $_POST['fav_num'];

        $addQuery = "INSERT INTO
            userinfo (FirstName, LastName, EMail, FavoriteNum)
            VALUES ('$firstName', '$lastName', '$email', '$favNum')";
        mysqli_query($conn, $addQuery);

        //Clear the fields
        $userNo = -1;
        $firstName = "";
        $lastName = "";
        $email = "";
        $favNum = 0;
    }
    else if ($edit) {
        //Get the user information
        $selQuery = "SELECT * FROM userinfo WHERE UserNo = $userNo";
        $result = mysqli_query($conn, $selQuery);
        $userInfo = mysqli_fetch_assoc($result);

        $firstName = $userInfo['FirstName'];
        $lastName = $userInfo['LastName'];
        $email = $userInfo['EMail'];
        $favNum = $userInfo['FavoriteNum'];
    }
    else if ($update) {
        //Updated values submitted
        $firstName = $_POST['fname'];
        $lastName = $_POST['lname'];
        $email = $_POST['email'];
        $favNum = $_POST['fav_num'];

        $updQuery = "UPDATE userinfo SET
            FirstName = '$firstName', LastName = '$lastName',
            EMail = '$email', FavoriteNum = $favNum
            WHERE UserNo = $userNo";
        mysqli_query($conn, $updQuery);

        //Clear the fields
        $userNo = -1;
        $firstName = "";
        $lastName = "";
        $email = "";
        $favNum = 0;
    }
    else if ($delete) {
        //Need to delete the selected user
        $delQuery = "DELETE FROM userinfo WHERE UserNo = $userNo";
        mysqli_query($conn, $delQuery);
        $userNo = -1;
    }

    //Query for all users
    $query = "SELECT * FROM userinfo";
    $result = mysqli_query($conn, $query);
?>

<style>
    table {
        border-spacing: 5px;
    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td {
        padding: 15px;
        text-align: center;
    }
    th {
        background-color: lightskyblue;
    }
    tr:nth-child(even) {
        background-color: whitesmoke;
    }
    tr:nth-child(odd) {
        background-color: lightgray;
    }
</style>

<html>
    <head>
        <title>Week3 GP1 - Randall Lowe</title>
    </head>

    <body>
        <h2>Current User:</h2>
        <table>
            <tr style="font-size:large;">
                <th>User #</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>E-Mail</th>
                <th>Favorite Number</th>
                <th></th>
                <th></th>
            </tr>

            <?php while($row = mysqli_fetch_array($result)):;?>
            <tr>
                <td><?php echo $row["UserNo"];?></td>
                <td><?php echo $row["FirstName"];?></td>
                <td><?php echo $row["LastName"];?></td>
                <td><?php echo $row["EMail"];?></td>
                <td><?php echo $row["FavoriteNum"];?></td>
                <td>
                    <form method="POST">
                        <input type="submit" value="Edit" name="edit">
                        <input type="hidden"
                            value="<?php echo $row["UserNo"]; ?>"
                            name="user_no">
                    </form>
                </td>
                <td>
                    <form method="POST">
                        <input type="submit" value="Delete" name="delete">
                        <input type="hidden"
                            value="<?php echo $row["UserNo"]; ?>"
                            name="user_no">
                    </form>
                </td>
            </tr>
            <?php endwhile;?>
        </table>
        <form method="POST">
            <input type="hidden" value="<?php echo $userNo; ?>" name="user_no">
            <h3>Enter your first name: <input type="text" name="fname"
                value="<?php echo $firstName; ?>"></h3>
            <h3>Enter your last name: <input type="text" name="lname"
                value="<?php echo $lastName; ?>"></h3>
            <h3>Enter your email address: <input type="text" name="email"
                value="<?php echo $email; ?>"></h3>
            <h3>Enter your favorite number: <input type="text" name="fav_num"
                value="<?php echo $favNum; ?>"></h3>
            <?php if (!$edit): ?>
                <input type="submit" value="Add User" name="add">
            <?php else: ?>
                <input type="submit" value="Update User" name="update">
            <?php endif; ?>
        </form>
    </body>
</html>