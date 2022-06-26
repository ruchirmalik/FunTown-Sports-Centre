<?php
session_start();
include '../connect.php';
$conn = OpenCon();
$email = $_SESSION["email"];
$branch;
$emergencyconname;
$emergencyconphone;
$allbranchesadd;
$allbranchesname;
$phone;
$name;
$dob;
$age;
$mid;
$mlevel;
$mstart;
$mend;

function reload()
{
  header("location:memberpage.php");
  exit();
}
function logout(){
  session_destroy();
  header("location:../index.php");
  exit();
}
function editdetails()
{
  header("location:editdetails.php");
  exit();
}

function getCustomerDetails($email)
{

  $sql = "SELECT Customer_phone.Name as Name, Customer.email, customer.phone as phonenum, Customer.DOB as dob, Customer_age.Age as age, membership.ID as MID, Level, start_date, end_date, SCAddress, emergencycontact.Name as eName, emergencycontact.Phone as ePhone FROM customer JOIN customer_phone ON customer.phone = customer_phone.Phone JOIN customer_age ON customer.DOB = customer_age.DOB JOIN membership ON customer.email = membership.email JOIN attends ON customer.email = attends.CustEmail JOIN emergencycontact ON emergencycontact.CustEmail = customer.email WHERE customer.email LIKE '{$email}'";

  $result = $GLOBALS['conn']->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      $GLOBALS['phone'] =  $row["phonenum"];
      $GLOBALS['dob'] = $row["dob"];
      $GLOBALS['name'] =  $row["Name"];
      $GLOBALS['age'] =  $row["age"];
      $GLOBALS['mid'] =  $row["MID"];
      $GLOBALS['mlevel'] =  $row["Level"];
      $GLOBALS['mstart'] =  $row["start_date"];
      $GLOBALS['mend'] =  $row["end_date"];
      $GLOBALS['branch'] =  $row["SCAddress"];
      $GLOBALS['emergencyconname'] = $row["eName"];
      $GLOBALS['emergencyconphone'] = $row["ePhone"];
    }
    
    //CloseCon($GLOBALS['conn']);
  }
}


?>

<!DOCTYPE html>

<html>
<script>
  //JS to preserve scroll position
        document.addEventListener("DOMContentLoaded", function(event) { 
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script>

<head>

  <link rel="stylesheet" href="membercss/profile.css">
  <title>
    Member Profile
  </title>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<body>
  <?php
  getCustomerDetails($email);
  echo "<div class = \"details\"><h2 > Name: " . $name . "<br></h2>";
  echo "<h3 ><b> Member Details: </b><br></h3>";
  echo "<b> Email:  </b>{$email}<br><br>
  <b> Phone: </b>{$phone}<br><br>
  <b>  DOB: </b> {$dob}<br><br>
  <b>   Age: </b> {$age}<br><br>
  <b>   Visting branch: </b> {$branch}<br><br>
  <b>   Emergency contact name: </b> {$emergencyconname}<br><br>
  <b>   Emergency contact phone: </b> {$emergencyconphone}<br><br>";

  ?>
  <form method="post">
    <input class="submit" type="submit" name="editdetails" value="Edit Details" />
  </form><br>

  <?php

  if (isset($_POST['editdetails'])) {
    editdetails();
  }


  echo "<h3>Membership Details: </h3>";
  echo "<b>Membership ID:</b> {$mid}<br>
  <b>Membership Level:</b> {$mlevel}<br>
  <b>     Membership Start Date:</b> {$mstart}<br>
  <b>     Membership End Date:</b> {$mend}<br>";
  ?>
  <form method="post">
    <br><br><input class= "submit" type="submit" name="viewplans" value="View all plans" />
  </form><br>

  <?php

  if (isset($_POST["viewplans"])) //returns true if variable exists and is not null
  {
    $sql = "SELECT * FROM `membership_level`";
    $result = $GLOBALS['conn']->query($sql);

    if ($result->num_rows > 0) {
      echo "<h3 align=\"center\">Membership Plans</h3>";
      echo "<table border=\"1\" width=\"100%\" align=\"center\" style=\"text-align:center\"><tr><th>Level</th><th>Fee</th></tr>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td class='border-class'>" . $row["Level"] . "</td><td>" . $row["Fee"] . "</td></tr>";
      }
      echo "</table>";
    }
  }

  ?>
  <form method="post">
    <br><br>


    <center><a style="text-decoration:none" class="submit" name="bookapp" href="bookapp.php">Book an appointment</a>&emsp;&emsp;&emsp;
      <a style="text-decoration:none" class="submit" name="viewcoach" href="coachview.php">View Coaches</a>&emsp;&emsp;&emsp;
      <?php //<input class="submit" type="submit" name="viewact" value="View activities" />&emsp;&emsp;&emsp;
      ?>
    </center>

  </form><br>

  <?php

  echo "<h3 align=\"center\">All appointments</h3>";
  echo "<center><form method=\"post\"><input type=\"radio\" name=\"radio\" value=\"withoutcid\"";
  if (isset($_POST['radio']) && $_POST['radio'] == "withoutcid") {
    echo " checked/>";
  }
  echo "<label for=\"radio\">Without coach only</label> &emsp;&emsp;";
  echo "<input type=\"radio\" name=\"radio\" value=\"withcid\"";
  if (isset($_POST['radio']) && $_POST['radio'] == "withcid") {
    echo " checked/>";
  }
  echo "<label for=\"radio\">With coach only</label> &emsp;&emsp;";
  echo "<input type=\"radio\" name=\"radio\" id=\"allapp\" value=\"allapp\"";
  if (isset($_POST['radio']) && $_POST['radio'] == "allapp") {
    echo " checked/>";
  }
  echo "<label for=\"radio\">All</label> &emsp;&emsp;<br><br>";
  echo "<b>Select Columns: &emsp;</b>";

  //checkboxes for columns
  /*  echo "<input type=\"checkbox\" name=\"cols[]\" value=\"CustEmail\"";
  if (isset($_POST['cols']) and in_array("CustEmail",$_POST['cols'])) {
    echo " checked";
  }
  echo "/> Email &emsp;&emsp;"; */
  /* echo "<input type=\"checkbox\" name=\"cols[]\" value=\"ApptDate\"";
  if (isset($_POST['cols']) and in_array("ApptDate",$_POST['cols'])) {
    echo " checked";
  }
  echo "/> Date &emsp;&emsp;";
  echo "<input type=\"checkbox\" name=\"cols[]\" value=\"ApptTime\"";
  if (isset($_POST['cols']) and in_array("ApptTime",$_POST['cols'])) {
    echo " checked";
  }
  echo "/> Time &emsp;&emsp;"; */
  echo "<input type=\"checkbox\" name=\"cols[]\" value=\"SNumber\"";
  if (isset($_POST['cols']) and in_array("SNumber", $_POST['cols'])) {
    echo " checked";
  }
  echo "/> Studio &emsp;&emsp;";
  echo "<input type=\"checkbox\" name=\"cols[]\" value=\"CoachID\"";
  if (isset($_POST['cols']) and in_array("CoachID", $_POST['cols'])) {
    echo " checked";
  }
  echo "/> Coach ID &emsp;&emsp;";
  echo "<input class=\"submit\" type=\"submit\" name=\"filterapp\" value=\"Filter\" /><br><br></form></center>";


$sqlval = $_POST["radio"];
$checkcols = $_POST["cols"];
$sqlfirstpart = "SELECT CustEmail, ApptDate, ApptTime";
$sqlsecpart;
for ($i = 0; $i < count($_POST['cols']); $i++) {
  $sqlsecpart = $sqlsecpart . ", " . $_POST['cols'][$i];
}
$sqllastpart = $sqlfirstpart . $sqlsecpart . " FROM appointment_happens_in WHERE CustEmail LIKE '{$email}'";
$sql = $sqllastpart;


  if (isset($_POST['filterapp']) or isset($_POST['cancel'])) {


    for ($i = 0; $i < count($_POST['cols']); $i++) {
      $GLOBALS['sqlsecpart'] = $GLOBALS['sqlsecpart'] . ", " . $_POST['cols'][$i];
    }

   


    if ($GLOBALS['sqlval'] == "withoutcid") {
      $GLOBALS['sql'] = $GLOBALS['sqllastpart'] . " AND CoachID IS NULL";
      
    } else if ($GLOBALS['sqlval'] == "withcid") {
      $GLOBALS['sql'] = $GLOBALS['sqllastpart'] . " AND CoachID IS NOT NULL;";
    
    } else {
      $GLOBALS['sql'] = $GLOBALS['sqllastpart'];

    }
  }

  executeTableQuery($sql, $checkcols);
  $email = $_GET['email']; // get id through query string
  $date = $_GET['date'];
  $time = $_GET['time'];

  $del = "DELETE FROM appointment_happens_in WHERE CustEmail LIKE '{$email}' AND ApptDate = '{$date}' AND ApptTime = '{$time}'";
  if ($GLOBALS['conn']->query($del)){
    reload();
    echo "<script>
        $(\"#appoint\").load(\"memberpage.php #appoint\")</script>";
  } 

  function executeTableQuery($sql, $cols)
  {

    $result = $GLOBALS['conn']->query($sql);

    if ($result->num_rows > 0) {
      echo "<table border=\"1\" width=\"100%\" id=\"appoint\" align=\"center\" style=\"text-align:center\"><tr><th>Date</th><th>Time</th>";
      if (in_array("SNumber", $cols)) {
        echo "<th>Studio</th>";
      }
      if (in_array("CoachID", $cols)) {
        echo "<th>Coach ID</th>";
      }
      echo "<th>Cancellation</th></tr>";

      while ($row = $result->fetch_assoc()) {


        echo "<tr>
        <td>" . $row["ApptDate"] . "</td>
        <td>" . $row["ApptTime"] . "</td>";
        if (in_array("SNumber", $cols)) {
          echo "<td>" . $row["SNumber"] . "</td>";
        }
        if (in_array("CoachID", $cols)) {
          
          echo "<td>" . $row["CoachID"] . "</td>";
        }
        echo "<td><a href=\"memberpage.php?email=" . $row["CustEmail"] . "&date=" . $row["ApptDate"] . "&time=" . $row["ApptTime"] . "\">Cancel appointment</a></td></tr>";
      }
      



      echo "</table>";
    } else {
      echo "<center><b>No appointments</b></center>";
    }
  }
  

  ?>
  <form method="post">
    <br><br><input class="submit" type="submit" name="logout" value="Log out" />
  </form>

  <?php
  if (isset($_POST['logout'])){
    logout();
  }
  ?>



</body>

</html>