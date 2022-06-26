<!DOCTYPE html>
<html>

<head>

    <link rel="stylesheet" href="admincss/adminProfile.css">
    <title>
        Manage Members
    </title>
</head>
<body>
<div class="details">



<?php
session_start();
include '../connect.php';
$conn = OpenCon();
$aid = $_SESSION["aid"];
$phone = null;
$name = null;
$mid;

if (isset($_POST["addmembership"])) //returns true if variable exists and is not null
{
    $email = $_POST["email"];
    $mid = $_POST["mid"];
    $startofdate = $_POST["startofdate"];
    $endofdate = $_POST["endofdate"];
    $level = $_POST["level"];

    $db = $GLOBALS['conn'];
    $result =  $db->query("INSERT INTO Membership (ID, start_date, end_date, Level, email) VALUES ('{$mid}','{$startofdate}', '{$endofdate}', '{$level}', '{$email}');");

    if ($result) {
        $memberAdded = true;
    }
    else{
        echo "Try again";
    }

}


if (isset($_POST["deletemember"])) //returns true if variable exists and is not null
{
    $id = $_POST["id"];

    $db = $GLOBALS['conn'];
    $result = $db->query("DELETE FROM Membership WHERE ID = {$id};");

    if ($result) {
        $memberDeleted = true;
    }

}

?>

<form method="post">
<input class="submit" type="submit" name="goback" value="Go back"/>
</form>
<br><br>
<?php
function goback()
{
    header("location:adminPage.php");
    exit();
}

if (isset($_POST['goback'])){
    goback();
}

$sqlp1 = " FROM (SELECT COUNT(*) as count, Level FROM Membership GROUP BY Level ORDER BY count DESC) x;";

echo "<form method=\"post\"><h3>Statistics</h3>";
    echo "<input type=\"radio\" name=\"radiostat\"  value=\"MAX\"";
    if (isset($_POST['radiostat']) && $_POST['radiostat'] == "MAX") {
        echo " checked";
    }
    echo "/> Maximum members in a level&emsp;&emsp;";
      echo "<input type=\"radio\" name=\"radiostat\"  value=\"SUM\"";
      if (isset($_POST['radiostat']) && $_POST['radiostat'] == "SUM") {
        echo " checked";
    }
    echo "/> Total members without membership &emsp;&emsp;";
      echo "<input type=\"radio\" name=\"radiostat\"  value=\"MIN\"";
      if (isset($_POST['radiostat']) && $_POST['radiostat'] == "MIN") {
        echo " checked";
    }
    echo "/> Minimum members in a level &emsp;&emsp;<br><br>";
    echo "<input class='submit' type='submit' name='viewagg' value='Submit'/>";


    if (isset($_POST['viewagg']) and (!empty($_POST['radiostat']))){
        
        $sqlp1a =$GLOBALS['sqlp1'];
        //$sqlmem =($_POST['radiostat']!='SUM') ? ", membership.Level ": " ";
        $sqlp2 = "SELECT {$_POST['radiostat']}(x.count) as {$_POST['radiostat']} " . $sqlp1a;

        //$GLOBALS['sqlfinal'] = $sqlp2;
        $result = $GLOBALS['conn']->query($sqlp2);
        
if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {

    echo "<br><br><b>Result :</b> " . $row[$_POST['radiostat']];
    /* if ($_POST['radiostat']!="SUM"){
        echo "<br><br><b>{$_POST['radiostat']} membership level: <b>" .  $row['membership.Level'];
    } */

}

    }



$sql = "SELECT * FROM Membership;";

$result = $GLOBALS['conn']->query($sql);

if ($result->num_rows > 0) {
    echo "<h3 align=\"center\">Members</h3>";
    echo "<table border=\"1\" width=\"100%\" align=\"center\" style=\"text-align:center\"><tr>
            <th>Level</th>
            <th>Email</th>
            <th>Delete</th>      
        </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td class='border-class'>" . $row["Level"] . "</td>
                <td>{$row["email"]}</td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='id' value='" . $row["ID"] . "'/>
                        <input class='submit' type='submit' name='deletemember' value='Delete'/>
                    </form>
                </td>
            </tr>";
    }
    echo "</table>";
}
?>

<br>
<form method="post">
    <input class="submit" type="submit" name="addmemberform" value="Add New Membership"/>
</form>

<?php

if (isset($memberAdded)) {
    ?>
    <p>New Member Added</p>
    <?php
}

if (isset($memberDeleted)) {
    ?>
    <p>Member Deleted</p>
    <?php
}


if (isset($_POST["addmemberform"])) //returns true if variable exists and is not null
{
    ?>
    <form id="addmemberform" method="post">
        <br><br>

        <label for="email">Email:</label>
        <?php
        echo "<select name=\"email\" id=\"email\">";
    
        $sqlbranches = "SELECT email FROM customer where email NOT IN (SELECT email FROM membership)";
    
        $resultmlevel = $GLOBALS['conn']->query($sqlbranches);
        if ($resultmlevel->num_rows > 0) {
            while ($row = $resultmlevel->fetch_assoc()) {
     
                echo "<option value= \"{$row["email"]}\" }";
                echo ">" . $row["email"];
                echo "</option>";
            }
        }
        echo "</select><br><br>";
        ?>
        <label for="mid">Membership ID:</label>
        <input type="text" id="mid" name="mid"><br><br>
        <label for="startofdate">Start of Date:</label>
        <input type="text" id="startofdate" name="startofdate"><br><br>
        <label for="endofdate">End of Date:</label>
        <input type="text" id="endofdate" name="endofdate">
        <label for="level">Level:</label>
        <select name="level" id="level">
            <option value="Silver">Silver</option>
            <option value="Gold">Gold</option>
            <option value="Platinum">Platinum</option>
            <option value="Bronze">Bronze</option>
            <option value="Diamond">Diamond</option>
        </select>

        <br><br>
        <input class="submit" type="submit" name="addmembership" value="Create"/>
    </form>

    <?php
}

    echo "<form method=\"post\">";

$sqlselectcoach = "coach c";
//SELECT * FROM coach c WHERE NOT EXISTS ( SELECT * from activity a WHERE NOT EXISTS ( SELECT o.CoachID FROM offers o WHERE c.CID=o.CoachID AND a.name LIKE o.ActName))";
$sqlselectcust = "customer c JOIN customer_phone d ON c.phone=d.phone"; 
//"SELECT * FROM activity a WHERE NOT EXISTS ( SELECT * from coach c WHERE NOT EXISTS ( SELECT o.CoachID FROM offers o WHERE c.CID=o.CoachID AND a.name LIKE o.ActName))";
echo "<br><br>";

echo "<b>View:</b><br><br>";
echo "<input type=\"radio\" name=\"coachallact\" id=cname value=\"{$sqlselectcoach}\"";
if (isset($_POST['coachallact']) && $_POST['coachallact'] == $sqlselectcoach) {
    echo " checked";
}
echo "/> Coaches who offer all activities:&emsp;&emsp;";

echo "<input type=\"radio\" name=\"coachallact\" id=cname value=\"{$sqlselectcust}\"";
if (isset($_POST['coachallact']) && $_POST['coachallact'] == $sqlselectcust) {
    echo " checked";
}
echo "/> Customers who access all activities: <br><br>";


/* for ($i = 0; $i < count($allact); $i++) {
    echo "<input type=\"checkbox\" name=\"offers[]\" id=\"{$allact[$i]}\" value=\"{$allact[$i]}\"";
    if (isset($_POST['cols']) and in_array("{$allact[$i]}", $_POST['cols'])) {
        echo " checked";
    }
    echo "/> {$allact[$i]} &emsp;&emsp;";
} */

echo "<input class=\"submit\" type=\"submit\" name=\"viewselectedact\" value=\"Show results\" /><br><br>";


if (isset($_POST['viewselectedact'])) {
    $sqlselecttable = $_POST['coachallact'];
    $selectacttable = ($_POST['coachallact']=="coach c") ? "offers" : "accesses";
    $selectcol = ($_POST['coachallact']=="coach c") ? "CID":"email";
    $selectcol2 = ($_POST['coachallact']=="coach c") ? "CoachID":"CustEmail";
    $sqlselect = "SELECT * FROM {$sqlselecttable} WHERE NOT EXISTS ( SELECT * from activity a WHERE NOT EXISTS ( SELECT o.{$selectcol2} FROM {$selectacttable} o WHERE c.{$selectcol}=o.{$selectcol2} AND a.name LIKE o.ActName))";


    $result = $GLOBALS['conn']->query($sqlselect);

    if ($_POST['coachallact'] == $sqlselectcoach) {
        if ($result->num_rows > 0) {
            echo "<table border=\"1\" width=\"100%\" id=\"appoint\" align=\"center\" style=\"text-align:center\"><tr><th>Coach ID</th><th>Coach Name</th><th>Phone</th></tr>";

            while ($row = $result->fetch_assoc()) {


                echo "<tr>
            <td>" . $row["CID"] . "</td>
            <td>" . $row["name"] . "</td>
            <td>" . $row["phone"] . "</td>
            </tr>";
            }
            echo "</table>";
        } else {
            echo "<center><b>No coaches offer all activities</b></center>";
        }
    } else if ($_POST['coachallact'] == $sqlselectcust) {
        if ($result->num_rows > 0) {
            echo "<table border=\"1\" width=\"100%\" id=\"appoint\" align=\"center\" style=\"text-align:center\"><tr><th>Customer Name</th><th>Customer Email</th><th>Customer Phone</th></tr>";

            while ($row = $result->fetch_assoc()) {


                echo "<tr>
            <td>" . $row["Name"] . "</td>
            <td>" . $row["email"] . "</td>
            <td>" . $row["phone"] . "</td>
            </tr>";
            }
            echo "</table>";
        } else {
            echo "<center><b>No activities are offered by all</b></center>";
        }
    }
}



?>

</form>



</div>
</body>
</html>
