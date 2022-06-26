<?php
session_start();
include '../connect.php';
$conn = OpenCon();
$email = $_SESSION["email"];
$branch;
$phone;
$name;
$dob;
$age;
$emergencyconname;
$emergencyconphone;
function canceledit()
{
    header("location:memberpage.php");
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
    echo "<div class = \"details\">";
    echo "<h2 >Edit Member Details: <br></h2>";
    echo "<form method=\"post\" >";
    echo "<b>Name:</b>&emsp;<input type=\"text\" name=\"name\" id=\"name\" value=\"" . $name . "\"><br><br>";
    echo "<b>Email:</b>&emsp;<input type=\"text\" name=\"email\" id=\"email\" value={$email}><br><br>";
    echo "<b>Phone:</b>&emsp;<input type=\"text\" name=\"phone\" id=\"phone\" value={$phone}><br><br>";
    
    echo "<b>Emergency contact name:</b>&emsp;<input type=\"text\" name=\"ename\" id=\"name\" value={$emergencyconname}><br><br>";
    echo "<b>Emergency contact phone:</b>&emsp;<input type=\"text\" name=\"ephone\" id=\"phone\" value={$emergencyconphone}><br><br>";
    echo "<b>Visiting branch:</b>&emsp;";
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
    echo "</select><br><br>";
    echo "<input class=\"submit\" type=\"submit\" name=\"save\" value=\"Save changes\" />&emsp;&emsp;
    <input class=\"submit\" type=\"submit\" name=\"cancel\" value=\"Cancel\" />
    </form><br>";

    if (isset($_POST['cancel'])) {
        canceledit();
    }
    if (isset($_POST['save'])) {
        
        saveDetails($_POST['name'],$_POST['email'],$_POST['phone'],$_POST['newbranch'],$_POST['ename'],$_POST['ephone']);
    }


    function saveDetails($name, $email, $phone, $branch, $ename, $ephone)
    {

                $sqlcustphone = "UPDATE customer_phone SET Phone='{$phone}' WHERE phone='{$GLOBALS['phone']}'";
                $sqlcustname = "UPDATE customer_phone SET Name='{$name}' WHERE phone='{$phone}'";
                //$sqlcustage = "UPDATE customer_age SET DOB='{$dob}' AND Age='{$name}' WHERE DOB='{$dob}'";
                $sqlcust = "UPDATE customer SET email='{$email}' WHERE email='{$GLOBALS['email']}'";
                $sqlcustbranch = "UPDATE attends SET SCAddress='{$branch}' WHERE CustEmail='{$GLOBALS['email']}'";
                $sqlecon = "UPDATE emergencycontact SET Name='{$ename}', Phone = '{$ephone}' WHERE CustEmail='{$GLOBALS['email']}'";
                $_SESSION['email']=$email;
              
                
               if ($GLOBALS['conn']->query($sqlcustphone) === TRUE AND $GLOBALS['conn']->query($sqlcustname) === TRUE AND $GLOBALS['conn']->query($sqlcust) === TRUE AND $GLOBALS['conn']->query($sqlcustbranch)  AND $GLOBALS['conn']->query($sqlecon)) {
                    

                    canceledit();
                } else {
                    echo "Error updating record: " . $GLOBALS['conn']->error;
                }
                //query("SET foreign_key_checks = 1");

        
    }




    ?>



</body>

</html>