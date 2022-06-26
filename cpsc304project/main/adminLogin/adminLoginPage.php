<?php
session_start();
function adminLogin(){
  header("location:adminPage.php");
  exit();
}

?>
<html>

<head>
  <link rel="stylesheet" href="admincss/adminStyle.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <title>Sign in</title>
</head>

<body>
  <div class="main">
    <p class="sign" align="center">Sign in</p>
    <form class="form1" method="post">
      <input class="un " type="text" align="center" name="text">
      <input class="pass" type="password" align="center">
      <input class="submit" type="submit" name="submit" id="submit" value="Sign in"/>

      <p class="forgot" align="center"><a href="#">Forgot Password?</p></a></p></form>
    
      <?php
    include '../connect.php';
  $conn = OpenCon();
      
        if(isset($_POST['submit'])) {
          $like = $_POST["text"];
          $sql = "SELECT * FROM `admin` WHERE AID LIKE '{$like}'";
      $result = $conn->query($sql);
            if ($result->num_rows) {
              $_SESSION["aid"] = "{$like}";
              adminLogin();
     
      } else {
      echo "<p align = \"center\" style=\"color:red;\">Invalid login credentials</p><br>";
  }
  CloseCon($conn);
        }
    ?>
            
                
    </div>
     
</body>

</html>