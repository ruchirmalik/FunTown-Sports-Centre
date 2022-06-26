<?php
session_start();

function coachlogin(){
  header("location:coachpage.php");
  exit();


}
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="coachcss/coachloginstyle.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <title>Sign in</title>
</head>

<body>
  <div class="main">
    <p class="sign" align="center">Welcome Back!</p>
    <form method="post" class="form1">
       <input class="coach" type="text" align="center" name="coachid" placeholder="Coach ID">
       <input class="pass" type="password" align="center" name="username" placeholder="Password">
       <input class="submit" type="submit" align="center" name="login" value="Log In">
       <!--<p class="forgot" align="center"><a href="#">Forgot Password?</p> -->
    </form>        
  </div>

  <?php
    include '../connect.php';
    $conn = OpenCon();

      if(isset($_POST["login"])) //returns true if variable exists and is not null
      { 
        $cid = $_POST["coachid"]; //because true, saving input in variable $user
        $sql = "SELECT * FROM Coach WHERE CID = {$cid}";
        $result = $conn->query($sql);
        
        if ($result->num_rows>0) 
        {
          
          $_SESSION["CID"] = "{$cid}"; //session variable
          coachlogin();
          /*echo "<center><table><tr><th class='border-class'>CID</th><th class='border-class'>phone</th><th class='border-class'>name</th></tr>";
          while($row = $result->fetch_assoc()) 
          { 
            echo "<tr><td class='border-class'>".$row["CID"]."</td><td class='border- class'>".$row["phone"]."</td><td class='border- class'>".$row["name"]."</td></tr>";
          }
          echo "</table></center>";*/
		}
        else
        {
          echo "<p align=\"center\" style=\"color:red\"> Invalid Coach ID. Please try again! </p>";
        }
      }
      CloseCon($conn); //move it before if closes in case of an error
  ?>   
</body>

</html>