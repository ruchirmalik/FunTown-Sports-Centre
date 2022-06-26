<?php
session_start();
include '../connect.php';
$conn = OpenCon();
$name;
$phone;
$activity=[];
$cid = $_SESSION["CID"];




function editdetails()
{
  header("location:coacheditdetails.php");
  exit();
}

function logout()
{   
    session_destroy();
    header("location: ../index.php");
    exit();
}

/*function goback()
{
    header("location:index.php");
    exit();
}*/

function getCoachDetails($cid)
{
    $sql = "SELECT * from Coach WHERE CID = {$cid}";
    $result = $GLOBALS['conn']->query($sql);
    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $GLOBALS['name'] = $row['name'];
            $GLOBALS['phone'] = $row['phone'];
        }
    }

    $sqlactivity = "SELECT ActName from Offers WHERE CoachID = {$cid}";
    $resultactivity = $GLOBALS['conn']->query($sqlactivity);

    if($resultactivity->num_rows > 0)
    {
        while($row = $resultactivity->fetch_assoc())
        {
            array_push($GLOBALS['activity'], $row['ActName']);
        }
    }
}
?>


<!DOCTYPE html>
<html>
      
<head>

<link rel="stylesheet" href="coachcss/coachpagestyle.css">
    <title>Coach Profile</title>

</head>
<body>
<div class="details">


<?php

getCoachDetails($cid);

echo "<h1>Personal Details</h1><br>";
echo "<p><b>Name:</b> {$GLOBALS['name']} </p>";
echo "<p><b>Phone:</b> {$GLOBALS['phone']} </p>";
echo "<p><b>Your Unique Coach ID:</b> {$cid} </p>";
echo "<p><b>Activities offered by you:</b>";

if(count($activity) == 1)
echo " {$activity[0]}";
else{
for($i=0; $i<=count($activity)-1; $i++)
      {
          echo " {$activity[$i]}, ";
      }
echo "</p>";
    }
?>
<form method="post">
    <input class="submit" type="submit" name="editdetails" value="Edit Details" />
</form><br>

<?php
  if (isset($_POST['editdetails'])) {
    editdetails();
  }

?>
<br><br>
<form method="post">
     <br> <br>  <p align=center> <input class="submit" type="submit" name="logout" value="Log Out"></p>

</form> 
<?php
 if (isset($_POST['logout'])) {
    logout();
 }
?>
</div>

</body>
</html>