<?php
session_start();
include '../connect.php';
$conn = OpenCon();
$email = $_SESSION["email"];

function goback()
{
    header("location:memberpage.php");
    exit();
}

function reload()
{
    header("location:coachview.php");
    exit();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>
        Member Profile
    </title>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<body>

    <?php

    echo "<div class = \"details\">";
    echo "<form method=\"post\"><input class=\"submit\" type=\"submit\" name=\"goback\" value=\"Go back to profile\" /></form>";
    echo "<center><h2>Coaches and Activities<br></h2><hr></center><br>";
    echo "<center><form method=\"post\">";

    if (isset($_POST['goback'])) {
        goback();
    }
    ?>

    <table class=act id=act style="width:100%; border: 1px">
        <tr style="border: 1px solid black">
            <th style="border-bottom: 1px solid lightgrey"><b>Activities accessed<br><br></b></th>
            <th style="border-bottom: 1px solid lightgrey"><b>Other activities<br><br></b></th>
        </tr>
        <tr>
            <td width=50% align="center"><br>
                <div class="tablediv">
                    <?php
                    $accessed = [];

                    $sql = "SELECT * FROM accesses WHERE CustEmail LIKE '{$email}'";
                    $result = $GLOBALS['conn']->query($sql);
                    $actname = $_GET['act'];
                    !empty($actname) ? $del = "DELETE FROM accesses WHERE CustEmail LIKE '{$email}' AND ActName LIKE '${actname}'" : $del;
                    if ($GLOBALS['conn']->query($del)) {
                        array_diff($accessed, $actname);
                        //JS to reload table
                        echo "<script>
        $(\"#act\").load(\"coachview.php #act\")</script>";
                    }

                    if ($result->num_rows > 0) {

                        echo "<table width=\"100%\" align=\"center\" style=\"text-align:center\">";

                        while ($row = $result->fetch_assoc()) {
                            array_push($accessed, $row["ActName"]);
                            echo "<tr>
        <td ><br>" . $row["ActName"] . "<br><br></td>
        <td><br><a href=\"coachview.php?act=" . $row["ActName"] . "\"><i class=\"fa fa-remove\" style=\"color:red\"></i></a><br><br></td>
        </tr><tr><td><hr></td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "No activities accessed yet";
                    }
                    ?>


                </div>
            </td>
            <td width=50% align="center"><br>
                <div class="tablediv">
                    <?php
                    $allact = [];
                    $sql = "SELECT * FROM activity";
                    $result = $GLOBALS['conn']->query($sql);
                    $actnameadd = $_GET['actnameadd'];

                    !empty($actnameadd) ? $add = "INSERT INTO accesses(ActName, CustEmail) VALUES('{$actnameadd}', '{$email}')" : $add;
                    if ($GLOBALS['conn']->query($add)) {
                        echo "<script>
        $(\"#act\").load(\"coachview.php #act\")</script>";
                    }

                    if ($result->num_rows > 0) {

                        echo "<table width=\"100%\" align=\"center\" style=\"text-align:center\">";

                        while ($row = $result->fetch_assoc()) {
                            array_push($allact, $row["name"]);
                            if (!in_array($row["name"], $accessed)) {
                                echo "<tr>
            <td><br>" . $row["name"] . "<br><br></td>
            <td><br><a href=\"coachview.php?actnameadd=" . $row["name"] . "\"><i class=\"fa fa-plus\" style=\"color:green\"></i></a><br><br></td>
            </tr><tr><td><hr></td></tr>";
                            }
                        }
                        echo "</table>";
                        if (count($accessed) == count($allact)) {
                            echo "No more activities to add";
                        }
                    }
                    ?>


                </div>
            </td>
        </tr>
    </table><br>
    <hr><br>
    <h3> Coach-Activity Details</h3>
    </center>
    <br>


    <table width=100% ">
        <tr>
            <td>

            
    <?php
    $sqlcoach = "SELECT activity.name as name, activity.capacity as cap, coach.CID as cid, coach.name as cname FROM offers JOIN activity ON offers.ActName LIKE activity.name JOIN coach ON offers.CoachID=coach.CID";
    //column checkboxes

    echo "<b> Select ordering column:&emsp;</b>";

    echo "<input type=\"radio\" name=\"cols\" id=name value=\"name\"";
    if (isset($_POST['cols']) && $_POST['cols'] == "name") {
        echo " checked";
    }
    echo "/> Activity Name &emsp;&emsp;";
    echo (isset($_POST['cols']) && $_POST['cols'] == "name");
    echo "<input type=\"radio\" name=\"cols\" id=cap value=\"cap\"";
    if (isset($_POST['cols']) && $_POST['cols'] == "cap") {
        echo " checked";
    }
    echo "/> Capacity &emsp;&emsp;";
    echo "<input type=\"radio\" name=\"cols\" id=cid value=\"cid\"";
    if (isset($_POST['cols']) && $_POST['cols'] == "cid") {
        echo " checked";
    }
    echo "/> Coach ID &emsp;&emsp;";
    echo "<input type=\"radio\" name=\"cols\" id=cname value=\"cname\"";
    if (isset($_POST['cols']) && $_POST['cols'] == "cname") {
        echo " checked";
    }
    echo "/> Coach &emsp;&emsp;";

    //order
    echo "<br><br><b> Select order:&emsp;</b>";

    echo "<input type=\"radio\" name=\"order\" id=asc value=\"ASC\"";
    if (isset($_POST['order']) && $_POST['order'] == "ASC") {
        echo " checked";
    }
    echo "/> Ascending &emsp;&emsp;";
    echo "<input type=\"radio\" name=\"order\" id=desc value=\"DESC\"";
    if (isset($_POST['order']) && $_POST['order'] == "DESC") {
        echo " checked";
    }
    echo "/> Descending &emsp;&emsp;";

    echo "<br><br>";




    ?>
    </td>
    <td align=center">
        <?php
        echo "<input class=\"submit\" type=\"submit\" name=\"filtercoach\" value=\"Show results\" />";
        $sqlordercol = $_POST['cols'];
        $sqlorder = $_POST['order'];
        $sqlca;


        ?>
        </td>
        </tr>
    </table>
    <?php {
        if (isset($_POST['filtercoach'])) {

            //((!empty($GLOBALS['sqlorder'])) ? " " . $GLOBALS['sqlorder']:" "))
            $GLOBALS['sqlca'] = $GLOBALS['sqlcoach'] . " ";
            if ((!empty($GLOBALS['sqlordercol']))) {

                $GLOBALS['sqlca'] = $GLOBALS['sqlca'] . " ORDER BY " . $GLOBALS['sqlordercol'];
                if ((!empty($GLOBALS['sqlorder']))) {
                    $GLOBALS['sqlca'] = $GLOBALS['sqlca'] . " " . $GLOBALS['sqlorder'];
                }
            }


            $result = $GLOBALS['conn']->query($sqlca);

            if ($result->num_rows > 0) {
                echo "<table border=\"1\" width=\"100%\" id=\"appoint\" align=\"center\" style=\"text-align:center\"><tr><th>Activity Name</th><th>Capacity</th><th>Coach ID</th><th>Coach Name</th></tr>";

                while ($row = $result->fetch_assoc()) {


                    echo "<tr>
            <td>" . $row["name"] . "</td>
            <td>" . $row["cap"] . "</td>
            <td>" . $row["cid"] . "</td>
            <td>" . $row["cname"] . "</td>
            </tr>";
                }




                echo "</table>";
            } else {
                echo "<center><b>No activities offered</b></center>";
            }
        }
    }
    ?>

    <br><br>

    <?php
    //conditional coach checkbox


    $sqlselectcoach = "SELECT * FROM coach c WHERE NOT EXISTS ( SELECT * from activity a WHERE NOT EXISTS ( SELECT o.CoachID FROM offers o WHERE c.CID=o.CoachID AND a.name LIKE o.ActName))";
    $sqlselectact = "SELECT * FROM activity a WHERE NOT EXISTS ( SELECT * from coach c WHERE NOT EXISTS ( SELECT o.CoachID FROM offers o WHERE c.CID=o.CoachID AND a.name LIKE o.ActName))";
    echo "<br><br>";

    echo "<b>Select one:</b><br><br>";
    echo "<input type=\"radio\" name=\"coachallact\" id=cname value=\"{$sqlselectcoach}\"";
    if (isset($_POST['coachallact']) && $_POST['coachallact'] == $sqlselectcoach) {
        echo " checked";
    }
    echo "/> Select coaches who offer all activities:<br><br>";

    echo "<input type=\"radio\" name=\"coachallact\" id=cname value=\"{$sqlselectact}\"";
    if (isset($_POST['coachallact']) && $_POST['coachallact'] == $sqlselectact) {
        echo " checked";
    }
    echo "/> Select activities offered by all coaches: <br><br>";


    /* for ($i = 0; $i < count($allact); $i++) {
        echo "<input type=\"checkbox\" name=\"offers[]\" id=\"{$allact[$i]}\" value=\"{$allact[$i]}\"";
        if (isset($_POST['cols']) and in_array("{$allact[$i]}", $_POST['cols'])) {
            echo " checked";
        }
        echo "/> {$allact[$i]} &emsp;&emsp;";
    } */

    echo "<input class=\"submit\" type=\"submit\" name=\"viewselectedact\" value=\"Show results\" /><br><br>";


    if (isset($_POST['viewselectedact'])) {
        $sqlselect = $_POST['coachallact'];

        $result = $GLOBALS['conn']->query($sqlselect);

        if ($_POST['coachallact'] == $sqlselectcoach) {
            if ($result->num_rows > 0) {
                echo "<table border=\"1\" width=\"100%\" id=\"appoint\" align=\"center\" style=\"text-align:center\"><tr><th>Coach ID</th><th>Coach Name</th></tr>";

                while ($row = $result->fetch_assoc()) {


                    echo "<tr>
                <td>" . $row["CID"] . "</td>
                <td>" . $row["name"] . "</td>
                </tr>";
                }
                echo "</table>";
            } else {
                echo "<center><b>No coaches offer all activities</b></center>";
            }
        } else if ($_POST['coachallact'] == $sqlselectact) {
            if ($result->num_rows > 0) {
                echo "<table border=\"1\" width=\"100%\" id=\"appoint\" align=\"center\" style=\"text-align:center\"><tr><th>Activity Name</th><th>Capacity</th></tr>";

                while ($row = $result->fetch_assoc()) {


                    echo "<tr>
                <td>" . $row["name"] . "</td>
                <td>" . $row["capacity"] . "</td>
                </tr>";
                }
                echo "</table>";
            } else {
                echo "<center><b>No activities are offered by all</b></center>";
            }
        }
    }

    ?>
</body>

</html>