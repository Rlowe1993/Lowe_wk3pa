<?php
    //Connect to Database
    $hostname = "localhost";
    $username = "ecpi_user";
    $password = "Password1";
    $dbname = "sdc310_wk3pa";
    $conn = mysqli_connect($hostname, $username, $password, $dbname);

    //Establish variables to support add/edit/delete
    $personNo = -1;
    $name = "";
    $dob = "";
    $favColor = "";
    $favPlace = "";
    $nickname = "";

    //Variables to determine the type of operation
    $add = false;
    $edit = false;
    $update = false;
    $delete = false;

    if (isset($_POST['person_no'])) {
        $personNo = $_POST['person_no'];
        $add = isset($_POST['add']);
        $update = isset($_POST['update']);
        $edit = isset($_POST['edit']);
        $delete = isset($_POST['delete']);
    }

    if ($add) {
        //Need to add a new person
        $name = $_POST['name'];
        $dob = $_POST['dob'];
        $favColor = $_POST['fav_color'];
        $favPlace = $_POST['fav_place'];
        $nickname = $_POST['nickname'];

        $addQuery = "INSERT INTO
            personalinfo (Name, DOB, FavoriteColor, FavoritePlace, Nickname)
            VALUES ('$name', '$dob', '$favColor', '$favPlace', '$nickname')";
        mysqli_query($conn, $addQuery);

        //Clear the fields
        $personNo = -1;
        $name = "";
        $dob = "";
        $favColor = "";
        $favPlace = "";
        $nickname = "";
    }
    else if ($edit) {
        //Get the person information
        $selQuery = "SELECT * FROM personalinfo WHERE PersonNo = $personNo";
        $result = mysqli_query($conn, $selQuery);
        $personInfo = mysqli_fetch_assoc($result);

        $name = $personInfo['Name'];
        $dob = $personInfo['DOB'];
        $favColor = $personInfo['FavoriteColor'];
        $favPlace = $personInfo['FavoritePlace'];
        $nickname = $personInfo['Nickname'];
    }
    else if ($update) {
        //Updated values submitted
        $name = $_POST['name'];
        $dob = $_POST['dob'];
        $favColor = $_POST['fav_color'];
        $favPlace = $_POST['fav_place'];
        $nickname = $_POST['nickname'];

        $updQuery = "UPDATE personalinfo SET
            Name = '$name', DOB = '$dob',
            FavoriteColor = '$favColor', FavoritePlace = '$favPlace',
            Nickname = '$nickname'
            WHERE PersonNo = $personNo";
        mysqli_query($conn, $updQuery);

        //Clear the fields
        $personNo = -1;
        $name = "";
        $dob = "";
        $favColor = "";
        $favPlace = "";
        $nickname = "";
    }
    else if ($delete) {
        //Need to delete the selected person
        $delQuery = "DELETE FROM personalinfo WHERE PersonNo = $personNo";
        mysqli_query($conn, $delQuery);
        $personNo = -1;
    }

    //Query for all people
    $query = "SELECT * FROM personalinfo";
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
        <title>Randall Lowe Wk 3 Performance Assessment</title>
    </head>

    <body>
        <h2>Randall Lowe Wk 3 Performance Assessment</h2>
        <h2>Current Personal Information:</h2>
        <table>
            <tr style="font-size:large;">
                <th>Person #</th>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Favorite Color</th>
                <th>Favorite Place To Visit</th>
                <th>Nickname</th>
                <th></th>
                <th></th>
            </tr>

            <?php while($row = mysqli_fetch_array($result)):;?>
            <tr>
                <td><?php echo $row["PersonNo"];?></td>
                <td><?php echo $row["Name"];?></td>
                <td><?php echo $row["DOB"];?></td>
                <td><?php echo $row["FavoriteColor"];?></td>
                <td><?php echo $row["FavoritePlace"];?></td>
                <td><?php echo $row["Nickname"];?></td>
                <td>
                    <form method="POST">
                        <input type="submit" value="Edit" name="edit">
                        <input type="hidden"
                            value="<?php echo $row["PersonNo"]; ?>"
                            name="person_no">
                    </form>
                </td>
                <td>
                    <form method="POST">
                        <input type="submit" value="Delete" name="delete">
                        <input type="hidden"
                            value="<?php echo $row["PersonNo"]; ?>"
                            name="person_no">
                    </form>
                </td>
            </tr>
            <?php endwhile;?>
        </table>
        <form method="POST">
            <input type="hidden" value="<?php echo $personNo; ?>" name="person_no">
            <h3>Enter your name: <input type="text" name="name"
                value="<?php echo $name; ?>"></h3>
            <h3>Enter your date of birth: <input type="date" name="dob"
                value="<?php echo $dob; ?>"></h3>
            <h3>Enter your favorite color: <input type="text" name="fav_color"
                value="<?php echo $favColor; ?>"></h3>
            <h3>Enter your favorite place to visit: <input type="text" name="fav_place"
                value="<?php echo $favPlace; ?>"></h3>
            <h3>Enter your nickname: <input type="text" name="nickname"
                value="<?php echo $nickname; ?>"></h3>
            <?php if (!$edit): ?>
                <input type="submit" value="Add" name="add">
            <?php else: ?>
                <input type="submit" value="Update" name="update">
            <?php endif; ?>
        </form>
    </body>
</html>
