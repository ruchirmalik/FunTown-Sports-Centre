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


if (isset($_POST["createapp"])) //returns true if variable exists and is not null
{
    $appDate = $_POST["appDate"];
    $appTime = $_POST["appTime"];
    $snumber = $_POST["SNumber"];

    $sql = "INSERT INTO `Appointment_Happens_In_slots` (ApptTime)
    VALUES ('{$appTime}')";
    $result = $GLOBALS['conn']->query($sql);

    if ($result) {
        $appointmentAdded = true;
    }

    $_GET = true;

}

if (isset($_POST["deleteapp"])) //returns true if variable exists and is not null
{
    $sql = "DELETE FROM `appointment_happens_in_slots` WHERE '{$_POST['time']}' = ApptTime";
    $result = $GLOBALS['conn']->query($sql);

    if ($result) {
        $appointmentDeleted = true;
    }

    $_GET = true;

}
echo "<div class = \"details\">";
echo "<form method=post>
<input class=\"submit\" type=\"submit\" name=\"goback\" value=\"Go back\"/>
</form>
<br><br>";
if (isset($_GET)) //returns true if variable exists and is not null
{
    $sqlslot = "SELECT * FROM `appointment_happens_in_slots`";
    $result = $GLOBALS['conn']->query($sqlslot);

    if ($result->num_rows > 0) {
        
        echo "<h3 align=\"center\">Available Appointment Time Slots</h3>";
        echo "<table border=\"1\" width=\"100%\" align=\"center\" style=\"text-align:center\"><tr>
           
                <th>Time</th>
                <th>Delete</th>           
            </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td class='border-class'>" . $row["ApptTime"] . "</td>
                    <td>
                        <form method='post'>
                            <input type='hidden' name='time' value='" . $row["ApptTime"] . "'/>
                            <input class='submit' type='submit' name='deleteapp' value='Delete'/>
                        </form>
                    </td>
                </tr>";
        }
        echo "</table>";
    }
}


if (isset($appointmentAdded)) {
    ?>
    <p>Appointment Added</p>
    <?php
}

if (isset($appointmentDeleted)) {
    ?>
        <p>Appointment Deleted</p>
    <?php
}


if (isset($_POST["createappform"])) //returns true if variable exists and is not null
{
    ?>
    <form id="createAppForm" method="post">
        <br><br>


        <label for="appTime">Time:</label>
        <input type="text" id="appTime" name="appTime"><br><br>


        <br><br>
        <input class="submit" type="submit" name="createapp" value="Create"/>
    </form>
    <br><br>

    <?php

}


{
    $sqlslot = "SELECT * FROM `appointment_happens_in`";
    $result = $GLOBALS['conn']->query($sqlslot);

    if ($result->num_rows > 0) {
        
        echo "<h3 align=\"center\">Available Appointment Time Slots</h3>";
        echo "<table border=\"1\" width=\"100%\" align=\"center\" style=\"text-align:center\"><tr>
                <th>Customer Email</th>
                <th>Date</th>
                <th>Time</th>
                <th>Studio</th>
                <th>Coach ID</th>         
            </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td class='border-class'>" . $row["CustEmail"] . "</td>
                    <td>" . $row["ApptDate"] . "</td>
                    <td>" . $row["ApptTime"] . "</td>
                    <td>" . $row["SNumber"] . "</td>
                    <td>"  . $row["CoachID"] . "</td>
                    
                    </td>
                </tr>";
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
        Manage Appointments
    </title>
</head>
<body>

<br>
<form method="post">
    <input class="submit" type="submit" name="createappform" value="Create new appointments"/>
</form>
</body>
</html>
