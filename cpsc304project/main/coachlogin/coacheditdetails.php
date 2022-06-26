<?php
session_start();
include '../connect.php';
$conn = OpenCon();
$cid = $_SESSION["CID"];
$phone;
$name;

function canceledit()
{
    header("location:coachpage.php");
    exit();
}

function getCoachDetails($cid)
{
    $sql = "SELECT * FROM `Coach` WHERE CID LIKE '{$cid}'";
    $result = $GLOBALS['conn']->query($sql);
    if ($result->num_rows > 0) 
    {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $GLOBALS['phone'] =  $row["phone"];
            $GLOBALS['name'] = $row["name"];
        }
    }
        /*$sqlphone = "SELECT * FROM `customer_phone` WHERE phone LIKE '{$GLOBALS['phone']}'";
        $resultphone = $GLOBALS['conn']->query($sqlphone);
        if ($resultphone->num_rows > 0) {
            while ($row = $resultphone->fetch_assoc()) {
                $GLOBALS['name'] =  $row["Name"];
            }
        }
        $sqlage = "SELECT * FROM `customer_age` WHERE DOB = '{$GLOBALS['dob']}'";
        $resultage = $GLOBALS['conn']->query($sqlage);
        if ($resultage->num_rows > 0) {
            while ($row = $resultage->fetch_assoc()) {
                $GLOBALS['age'] =  $row["Age"];
            }
        }

        $sqlmembership = "SELECT * FROM `member_owns` WHERE Memail = '{$GLOBALS['email']}'";
        $resultmid = $GLOBALS['conn']->query($sqlmembership);
        if ($resultmid->num_rows > 0) {
            while ($row = $resultmid->fetch_assoc()) {
                $GLOBALS['mid'] =  $row["MID"];
            }
        }

        $sqlmlevel = "SELECT * FROM `membership` WHERE ID = '{$GLOBALS['mid']}'";
        $resultmlevel = $GLOBALS['conn']->query($sqlmlevel);
        if ($resultmlevel->num_rows > 0) {
            while ($row = $resultmlevel->fetch_assoc()) {
                $GLOBALS['mlevel'] =  $row["Level"];
                $GLOBALS['mstart'] =  $row["start_date"];
                $GLOBALS['mend'] =  $row["end_date"];
            }
        }

        $sqlbranch = "SELECT * FROM `attends` WHERE CustEmail = '{$GLOBALS['email']}'";
        $resultmlevel = $GLOBALS['conn']->query($sqlbranch);
        if ($resultmlevel->num_rows > 0) {
            while ($row = $resultmlevel->fetch_assoc()) {
                $GLOBALS['branch'] =  $row["SCAddress"];
            }
        }*/
        //CloseCon($GLOBALS['conn']);
    
}


?>

<!DOCTYPE html>

<html>

<head>

    <link rel="stylesheet" href="coachcss/coachpagestyle.css">
    <title>
        Coach Profile
    </title>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<body>
    <?php
    getCoachDetails($cid);
    echo "<div class = \"details\">";
    echo "<h2 >Edit Coach Details: <br></h2>";
    echo "<form method=\"post\" >";
    echo "Name:&emsp;<input class=\"sub\" type=\"text\" name=\"name\" id=\"name\" value=\"{$GLOBALS['name']}\"><br><br>";
    //echo "Email:&emsp;<input type=\"text\" name=\"email\" id=\"email\" value={$email}><br><br>";
    echo "Phone:&emsp;<input class=\"sub\" type=\"text\" name=\"phone\" id=\"phone\" value={$phone}><br><br>";
    //echo "DOB:&emsp;<input type=\"text\" name=\"dob\" id=\"dob\" value={$dob}><br><br>";
    //echo "Age:&emsp;<input type=\"text\" name=\"age\" id=\"age\" value={$age}><br><br>";
    /*echo "Visiting branch:&emsp;";

    echo "<select name=\"newbranch\" id=\"newbranch\">";

    $sqlbranches = "SELECT * FROM sport_center_branch";

    $resultmlevel = $GLOBALS['conn']->query($sqlbranches);
    if ($resultmlevel->num_rows > 0) {
        while ($row = $resultmlevel->fetch_assoc()) {
 
            echo "<option value= \"{$row["address"]}\" }";

            if ($row["address"] == $GLOBALS['branch']) {
                echo " selected";
            }
            echo ">" . $row["address"];
            echo "</option>";
        }
    }

    echo "</select><br><br>";*/

    echo "<input class=\"submit\" type=\"submit\" name=\"save\" value=\"Save changes\" />&emsp;&emsp;
    <input class=\"submit\" type=\"submit\" name=\"cancel\" value=\"Cancel\" />
    </form><br>";

    if (isset($_POST['cancel'])) {
        canceledit();
    }
    if (isset($_POST['save'])) {
        
        saveDetails($_POST['name'],$_POST['phone']);

    }


    function saveDetails($name,$phone)
    {

                $sqlcoachphone = "UPDATE coach SET phone='{$phone}' WHERE phone='{$GLOBALS['phone']}'";
                $sqlcoachname = "UPDATE coach SET name='{$name}' WHERE phone='{$phone}'";
                //$sqlcustage = "UPDATE customer_age SET DOB='{$dob}' AND Age='{$name}' WHERE DOB='{$dob}'";
                //$sqlcust = "UPDATE customer SET email='{$email}' WHERE email='{$GLOBALS['email']}'";
                //$sqlcustbranch = "UPDATE attends SET SCAddress='{$branch}' WHERE CustEmail='{$GLOBALS['email']}'";
                //$_SESSION['email']=$email;
              
                
               if ($GLOBALS['conn']->query($sqlcoachphone) === TRUE AND $GLOBALS['conn']->query($sqlcoachname) === TRUE) //AND $GLOBALS['conn']->query($sqlcust) === TRUE AND $GLOBALS['conn']->query($sqlcustbranch)) 
                {
                    canceledit();
                } else {
                    echo "Error updating record: " . $GLOBALS['conn']->error;
                }
                //query("SET foreign_key_checks = 1");

        
    }




    ?>



</body>

</html>