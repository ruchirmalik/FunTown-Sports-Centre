<?php
session_start();
include '../connect.php';
$conn = OpenCon();
$email = $_SESSION["email"];

function cancelapp()
{
  header("location:memberpage.php");
  exit();
}

?>

<!DOCTYPE html>

<html>

<head>

  <link rel="stylesheet" href="membercss/profile.css">
  <title>
    Member Profile
  </title>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<body>
  <?php

  echo "<div class = \"details\">";
  echo "<center><h2 >Book an appointment <br></h2></center>";
  echo "<br><br><center><form method=\"post\">
  <input type=\"radio\" name=\"radio\" id=\"mon\" value=\"2021-06-21\"";
  if (isset($_POST['radio']) && $_POST['radio'] == "2021-06-21") {
    echo " checked/>";
  }
  echo "<label for=\"radio\">Mon (06-21)</label> &emsp;&emsp;";
  echo "<input type=\"radio\" name=\"radio\" id=\"tue\" value=\"2021-06-22\"";
  if (isset($_POST['radio']) && $_POST['radio'] == "2021-06-22") {
    echo " checked/>";
  }
  echo "<label for=\"radio\">Tue (06-22)</label> &emsp;&emsp;";
  echo "<input type=\"radio\" name=\"radio\" id=\"wed\" value=\"2021-06-23\"";
  if (isset($_POST['radio']) && $_POST['radio'] == "2021-06-23") {
    echo " checked/>";
  }
  echo "<label for=\"radio\">Wed (06-23)</label> &emsp;&emsp;";
  echo "<input type=\"radio\" name=\"radio\" id=\"thur\" value=\"2021-06-24\"";
  if (isset($_POST['radio']) && $_POST['radio'] == "2021-06-24") {
    echo " checked/>";
  };
  echo "<label for=\"radio\">Thur (06-24)</label> &emsp;&emsp;";
  echo "<input type=\"radio\" name=\"radio\" id=\"fri\" value=\"2021-06-25\"";
  if (isset($_POST['radio']) && $_POST['radio'] == "2021-06-25") {
    echo " checked/>";
  }
  echo "<label for=\"radio\">Fri (06-25)</label> &emsp;&emsp;";
  echo "<input type=\"radio\" name=\"radio\" id=\"sat\" value=\"2021-06-26\"";
  if (isset($_POST['radio']) && $_POST['radio'] == "2021-06-26") {
    echo " checked/>";
  }
  echo "<label for=\"radio\">Sat (06-26)</label> &emsp;&emsp;";
  echo "<input type=\"radio\" name=\"radio\" id=\"sun\" value=\"2021-06-27\"";
  if (isset($_POST['radio']) && $_POST['radio'] == "2021-06-27") {
    echo " checked/>";
  }
  echo "<label for=\"radio\">Sun (06-27)</label> &emsp;&emsp;<br><br><br>";

  echo "<input class=\"submit\" type=\"submit\" name=\"viewslots\" value=\"View available slots\" />&emsp;
      <input class=\"submit\" type=\"submit\" name=\"cancel\" value=\"Cancel\" /><br><br></center>";



  if (isset($_POST['cancel'])) {
    cancelapp();
  }

  $sqlgetslots = "SELECT * from appointment_happens_in_slots";


  if (isset($_POST['viewslots'])) {
    
    if (!empty($_POST['radio'])) {
      echo "<br><br><center>";
      $resultmlevel = $GLOBALS['conn']->query($GLOBALS['sqlgetslots']);
      if ($resultmlevel->num_rows > 0) {
        while ($row = $resultmlevel->fetch_assoc()) {

          echo "<input type=\"radio\" name=\"radiotime\"  value=\"{$row['ApptTime']}\" />" . substr($row['ApptTime'], 0, 5) . "&emsp;&emsp;";

        }
      }
      
/*       
      echo "<input type=\"radio\" name=\"radiotime\"  value=\"09:30:00\" /> 9:30 AM &emsp;&emsp;";
      echo "<input type=\"radio\" name=\"radiotime\"  value=\"10:00:00\" /> 10:00 AM &emsp;&emsp;";
      echo "<input type=\"radio\" name=\"radiotime\"  value=\"10:30:00\" /> 10:30 AM &emsp;&emsp;";
      echo "<input type=\"radio\" name=\"radiotime\"  value=\"11:00:00\" /> 11:00 AM &emsp;&emsp;";
      echo "<input type=\"radio\" name=\"radiotime\"  value=\"11:30:00\" /> 11:30 AM &emsp;&emsp;";
      echo "<input type=\"radio\" name=\"radiotime\"  value=\"12:00:00\" /> 12:00 PM &emsp;&emsp;";
      echo "<input type=\"radio\" name=\"radiotime\"  value=\"12:30:00\" /> 12:30 PM &emsp;&emsp;";
      echo "<input type=\"radio\" name=\"radiotime\"  value=\"13:00:00\" /> 1:00 PM &emsp;&emsp;";
      echo "<input type=\"radio\" name=\"radiotime\"  value=\"13:30:00\" /> 1:30 PM &emsp;&emsp;";
      echo "<input type=\"radio\" name=\"radiotime\"  value=\"14:00:00\" /> 2:00 PM &emsp;&emsp;";
      echo "<input type=\"radio\" name=\"radiotime\"  value=\"14:30:00\" /> 2:30 PM &emsp;&emsp;";
      echo "<input type=\"radio\" name=\"radiotime\"  value=\"15:00:00\" /> 3:00 PM &emsp;&emsp;";
      echo "<input type=\"radio\" name=\"radiotime\"  value=\"15:30:00\" /> 3:30 PM &emsp;&emsp;";
      echo "<input type=\"radio\" name=\"radiotime\"  value=\"16:00:00\" /> 4:00 PM &emsp;&emsp;"; */
      echo "<br><br>";

      echo "Select a studio:&emsp;";

      echo "<select name=\"studio\">";

      $sqlstudio = "SELECT * FROM studio";

      $resultmlevel = $GLOBALS['conn']->query($sqlstudio);
      if ($resultmlevel->num_rows > 0) {
        while ($row = $resultmlevel->fetch_assoc()) {

          echo "<option value= \"{$row["Number"]}\" >" . $row["Number"];
          echo "</option>";
        }
      }
      echo "</select>&emsp;&emsp;&emsp;";

      echo "Select a coach:&emsp;";

      echo "<select name=\"coach\">";
      echo "<option value= 0 > NONE";
      $sqlcoach = "SELECT * FROM coach";
      $resultmlevel = $GLOBALS['conn']->query($sqlcoach);
      if ($resultmlevel->num_rows > 0) {
        while ($row = $resultmlevel->fetch_assoc()) {

          echo "<option value= \"{$row["CID"]}\" >" . $row["name"];
          echo "</option>";
        }
      }
      echo "</select><br><br>";
      echo "<input class=\"submit\" type=\"submit\" name=\"bookfinal\" value=\"Confirm\" /><br><br>";
      echo "</form>";
    } else {
      echo "<center><p style=\"color:red\">Please select a date.</p></center>";
    }
  }

  if (isset($_POST['bookfinal'])) {
    if (!empty($_POST['radiotime'])) {

      $date = $_POST['radio'];
      $time = $_POST['radiotime'];
      $studio = $_POST['studio'];
      $coach = $_POST['coach'];

      $sqlbookapp;

      if ($coach == 0) {
        $sqlbookapp = "INSERT INTO appointment_happens_in(CustEmail, ApptDate, ApptTime, SNumber) VALUES(
          '{$email}','{$date}','{$time}',{$studio}); ";
      } else {
        $sqlbookapp = "INSERT INTO appointment_happens_in(CustEmail, ApptDate, ApptTime, SNumber, CoachID) VALUES(
          '{$email}','{$date}','{$time}',{$studio}, {$coach}); ";
      }
      if ($GLOBALS['conn']->query($sqlbookapp) === TRUE) {
        echo "<center><p style=\"color:blue\">Your appointment has been booked for {$date} at ${time}.</p><br><br>
        <input class=\"submit\" type=\"submit\" name=\"goback\" value=\"Go back\" />&emsp;</center>";
      } else {
        echo "Error updating record: " . $GLOBALS['conn']->error;
      }
    } else {
      echo "<center><p style=\"color:red\">Please select a time slot.</p></center>";
    }
  }

  if (isset($_POST['goback'])) {
    cancelapp();
  }

  ?>



</body>

</html>