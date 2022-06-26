<?php
session_start();
include '../connect.php';
$conn = OpenCon();
$aid = $_SESSION["aid"];
$phone = null;
$name = null;

function logout()
{
    session_destroy();
    header("location:../index.php");
    exit();
}

if (isset($_POST['logout'])) {
    logout();
}

function getAdminDetails($aid)
{
    $sql = "SELECT * FROM `admin` WHERE aid LIKE '{$aid}'";
    $result = $GLOBALS['conn']->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $GLOBALS['phone'] = $row["phone"];
            $GLOBALS['name'] = $row["name"];

        }
    }
}
?>

<!DOCTYPE html>

<html>


<head>
    <link rel="stylesheet" href="admincss/adminProfile.css">
    <title>
        Admin Profile
    </title>
</head>

<div class="details">
<?php
getAdminDetails($aid);
echo "<h2> Hello " . $name . "<br></h2>";
echo "<h3 ><b> Admin Details: </b><br></h3>";
echo "AID: 
$aid
<br><br>
          Phone: 
$phone
<br><br>";
?>

<button class = "submit" onclick="location.href='manageplans.php'" class="button">Plans</button>
<button class = "submit" onclick="location.href='managemembers.php'" class="button">Manage Members</button>
<button class = "submit" onclick="location.href='managecoaches.php'" class="button">Manage Coaches</button>
<button class = "submit" onclick="location.href='manageappointments.php'" class="button">Manage Appointments</button>
<button class = "submit" onclick="location.href='managemembership.php'" class="button">Manage Memberships</button>


<br><br>
<form method="post">
    <br> <br>  <p align=center> <input class="submit" type="submit" name="logout" value="Log Out"></p>


</form>
</div>
</body>

</html>