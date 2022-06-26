<?php
session_start();
include '../connect.php';
$conn = OpenCon();
$aid = $_SESSION["aid"];
$phone = null;
$name = null;


function goback()
{
    header("location:adminPage.php");
    exit();
}

if (isset($_POST['goback'])){
    goback();
}
if (isset($_GET)) //returns true if variable exists and is not null
{
    $sql = "SELECT * FROM `membership_level`";
    $result = $GLOBALS['conn']->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class = \"details\">";
        echo "<form method=post>
<input class=\"submit\" type=\"submit\" name=\"goback\" value=\"Go back\"/>
</form>
<br><br>";
        echo "<h3 align=\"center\">Membership Plans</h3>";
        echo "<table border=\"1\" width=\"100%\" align=\"center\" style=\"text-align:center\"><tr><th>Level</th><th>Fee</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td class='border-class'>" . $row["Level"] . "</td><td>" . $row["Fee"] . "</td></tr>";
        }
        echo "</table>";
    }
}
?>

<!DOCTYPE html>

<html>
<head>

    <link rel="stylesheet" href="admincss/adminProfile.css">
    <title>
        Manage Plans
    </title>
</head>

<br>

</html>
