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
        function goback()
        {
            header("location:adminPage.php");
            exit();
        }

        if (isset($_POST['goback'])) {
            goback();
        }
        echo "<form method=post>
<input class=\"submit\" type=\"submit\" name=\"goback\" value=\"Go back\"/>
</form>
<br><br>";

        if (isset($_POST["addmember"])) //returns true if variable exists and is not null
        {
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $DOB = $_POST["DOB"];
            $name = $_POST["name"];
            $age = $_POST["age"];

            $db = $GLOBALS['conn'];
            $db->query('BEGIN;');
            $db->query("INSERT INTO Customer_Phone (Phone, Name) VALUES ('{$phone}', '{$name}');");
            $db->query("INSERT INTO Customer_Age (DOB, Age) VALUES ('{$DOB}', '{$age}');");
            $db->query("INSERT INTO Customer (email, phone, DOB) VALUES ('{$email}', '{$phone}', '{$DOB}');");
            $result = $db->query('COMMIT;');

            if ($result) {
                $memberAdded = true;
            }

            $_GET = true;
        }


        if (isset($_POST["deletemember"])) //returns true if variable exists and is not null
        {
            $sql = "DELETE FROM `Customer` WHERE '{$_POST["email"]}' = email;";
            $result = $GLOBALS['conn']->query($sql);

            if ($result) {
                $memberDeleted = true;
            }

            $_GET = true;
        }

        if (isset($_POST["viewmember"])) //returns true if variable exists and is not null
        {
            $sql = "SELECT email, Customer_Phone.Name, DOB, EmergencyContact.Phone as ephone FROM Customer LEFT OUTER JOIN EmergencyContact ON Customer.email = EmergencyContact.CustEmail
INNER JOIN Customer_Phone ON Customer.phone = Customer_Phone.Phone
WHERE email = '{$_POST['email']}'";
            $result = $GLOBALS['conn']->query($sql);

            echo "<h2>Member Details</h2>";
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $phone = isset($row['ephone']) ? $row['ephone'] : "N/A";

                echo "<p>Name: " . $row['Name'] . "</p>";
                echo "<p>DOB: " . $row['DOB'] . "</p>";
                echo "<p>Emergency Contact: " . $phone . "</p>";
            }
        }


        echo "<form method=\"post\"><h3>Statistics</h3>";
        echo "<input type=\"radio\" name=\"radiostat\"  value=\"AVG\"";
        if (isset($_POST['radiostat']) && $_POST['radiostat'] == "AVG") {
            echo " checked";
        }
        echo "/> Average age of members&emsp;&emsp;";
        echo "<input type=\"radio\" name=\"radiostat\"  value=\"MIN\"";
        if (isset($_POST['radiostat']) && $_POST['radiostat'] == "MIN") {
            echo " checked";
        }
        echo "/> Youngest member &emsp;&emsp;";
        echo "<input type=\"radio\" name=\"radiostat\"  value=\"MAX\"";
        if (isset($_POST['radiostat']) && $_POST['radiostat'] == "MAX") {
            echo " checked";
        }
        echo "/> Oldest member &emsp;&emsp;<br><br>";
        echo "<input class='submit' type='submit' name='viewagg' value='Submit'/>";

        if (isset($_POST['viewagg']) and (!empty($_POST['radiostat']))) {

            $sqlp2 = "SELECT round({$_POST['radiostat']}(Age),0) as {$_POST['radiostat']} FROM Customer INNER JOIN Customer_Age ON Customer.DOB = Customer_Age.DOB";

            //$GLOBALS['sqlfinal'] = $sqlp2;
            $result = $GLOBALS['conn']->query($sqlp2);
 
            if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {

                echo "<br><br><b>Age : </b> " . $row[$_POST['radiostat']];
            }
        }

        // if ($_SERVER['REQUEST_METHOD'] === 'GET') //returns true if variable exists and is not null
        {
            $sql = "SELECT COUNT(*) as sum FROM Customer";
            $result = $GLOBALS['conn']->query($sql);
            if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {

                echo "<br><br><b>Total members : </b> " . $row['sum'];
            }
        }

        $sql = "SELECT Name, email, customer.Phone, Customer.DOB, Age
FROM customer INNER JOIN customer_phone
ON customer.phone = customer_phone.Phone
INNER JOIN customer_age
ON customer.DOB = customer_age.DOB;";
        $result = $GLOBALS['conn']->query($sql);

        if ($result->num_rows > 0) {
            echo "<h3 align=\"center\">Members</h3>";
            echo "<table border=\"1\" width=\"100%\" align=\"center\" style=\"text-align:center\"><tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Date of Birth</th>
            <th>Age</th>   
            <th>Delete</th>      
            <th>Details</th>
        </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td class='border-class'>" . $row["Name"] . "</td>
                <td>" . $row["email"] . "</td>
                <td>" . $row["Phone"] . "</td>
                <td>" . $row["DOB"] . "</td>
                <td>" . $row["Age"] . "</td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='email' value='" . $row["email"] . "'/>
                        <input class='submit' type='submit' name='deletemember' value='Delete'/>
                    </form>
                </td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='email' value='" . $row["email"] . "'/>
                        <input class='submit' type='submit' name='viewmember' value='Details'/>
                    </form>
                </td>
            </tr>";
            }
            echo "</table>";
        }

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

                <label for="Name">Name:</label>
                <input type="text" id="name" name="name"><br><br>
                <label for="email">Email:</label>
                <input type="text" id="email" name="email"><br><br>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone"><br><br>
                <label for="DOB">Date of Birth:</label>
                <input type="text" id="DOB" name="DOB"><br><br>
                <label for="Age">Age:</label>
                <input type="text" id="age" name="age">

                <br><br>
                <input class="submit" type="submit" name="addmember" value="Create" />
            </form>

        <?php

        }

        ?>


        <br>
        <form method="post">
            <input class="submit" type="submit" name="addmemberform" value="Add New Member" />
        </form>

    </div>
</body>

</html>