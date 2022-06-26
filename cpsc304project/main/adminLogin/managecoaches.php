<?php
session_start();
include '../connect.php';
$conn = OpenCon();
$aid = $_SESSION["aid"];
$phone = null;
$name = null;

if (isset($_POST["addCoach"])) //returns true if variable exists and is not null
{
    $CID = $_POST["CID"];
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $ActName = $_POST["ActName"];

    $db = $GLOBALS['conn'];
    $db->query('BEGIN;');
    $db->query("INSERT INTO Coach (CID, name, phone) VALUES ({$CID}, '{$name}', '{$phone}');");
    $db->query("INSERT INTO Offers (CoachID, ActName) VALUES ({$CID}, '{$ActName}');");
    $result = $db->query('COMMIT;');

    if ($result) {
        $coachAdded = true;
    }

    $_GET = true;

}

if (isset($_POST["deletecoach"])) //returns true if variable exists and is not null
{
    $sql = "DELETE FROM `Coach` WHERE '{$_POST['CID']}' = CID";
    $result = $GLOBALS['conn']->query($sql);

    if ($result) {
        $coachDeleted = true;
    }

    $_GET = true;

}

echo "<div class = \"details\">";
function goback()
{
    header("location:adminPage.php");
    exit();
}

if (isset($_POST['goback'])){
    goback();
}
echo "<form method=post>
<input class=\"submit\" type=\"submit\" name=\"goback\" value=\"Go back\"/>
</form>
<br><br>";
if (isset($_GET)) //returns true if variable exists and is not null
{
    $sql = "SELECT * FROM coach
INNER JOIN offers ON coach.CID = offers.CoachID;";
    $result = $GLOBALS['conn']->query($sql);

    if ($result->num_rows > 0) {
        
        echo "<h3 align=\"center\">Coaches</h3>";
        echo "<table border=\"1\" width=\"100%\" align=\"center\" style=\"text-align:center\"><tr>
                <th>Coach ID</th>
                <th>Name</th>
                <th>Phone</th> 
                <th>Activity</th>
                <th>Delete</th>   
            </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td class='border-class'>" . $row["CID"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["phone"] . "</td>
                    <td>" . $row["ActName"] . "</td>
                    <td>
                        <form method='post'>
                            <input type='hidden' name='CID' value='" . $row["CID"] . "'/>
                            <input class='submit' type='submit' name='deletecoach' value='Delete'/>
                        </form>
                    </td>
                </tr>";
        }
        echo "</table>";
    }
}

if (isset($coachAdded)) {
    ?>
    <p>Coach Added</p>
    <?php
}

if (isset($coachDeleted)) {
    ?>
    <p>Coach Deleted</p>
    <?php
}


if (isset($_POST["addnewcoachform"])) //returns true if variable exists and is not null
{
    ?>
    <form id="addnewcoachform" method="post">
        <br><br>

        <label for="CID">Coach ID:</label>
        <input type="text" id="CID" name="CID"><br><br>
        <label for="Name">Name:</label>
        <input type="text" id="name" name="name"><br><br>
        <label for="Phone">Phone:</label>
        <input type="text" id="phone" name="phone"><br><br>
        <label for="ActName">Activity:</label>
        <input type="text" id="ActName" name="ActName">

        <br><br>
        <input class="submit" type="submit" name="addCoach" value="Add"/>
    </form>

    <?php

}
?>

<!DOCTYPE html>
<html>

<head>

    <link rel="stylesheet" href="admincss/adminProfile.css">
    <title>
        Manage Coaches
    </title>
</head>

<br>
<form method="post">
    <input class="submit" type="submit" name="addnewcoachform" value="New Coach"/>
</form>

</html>
