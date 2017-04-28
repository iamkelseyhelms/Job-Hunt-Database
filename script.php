<!---------------------------------------------------------
 - Author:          Kelsey Helms
 - Date Created:    March 10, 2017
 - Filename:        script.php
 -
 - Overview:
 - PHP file provides functions that are reused for different
 - tables.
 ---------------------------------------------------------->

<!------------------------------ Connect to Database ------------------------------>
<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "helmsk-db", "XKBMwuWgFy7m9FSJ", "helmsk-db");

if ($mysqli->connect_errno) {
    print "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}


/****************************** Get database values for dropdown ******************************/
function selectName($tbl)
{
    global $mysqli;

    if ($stmt = $mysqli->prepare("SELECT id, name FROM `$tbl`")) {    //get name from database
        if ($stmt->bind_result($id, $name)) {
            if ($stmt->execute()) {
                while ($stmt->fetch()) {    //fetch each option
                    echo '<option value=" ' . $id . ' "> ' . $name . '</option>\n';    //print out
                }
            } else {
                echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;    //debug the execution issue
            }
        } else {
            echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;    //debug the binding issue
        }
        $stmt->close();
    } else {
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;    //debug the preparation issue
    }
}


/****************************** Build database table for modify tab ******************************/
function buildJobTable()
{
    global $mysqli;
    $arr = array();

    if ($query = $mysqli->prepare("select id,name from company")) {    //get available companies
        if ($query->bind_result($id, $name)) {
            if ($query->execute()) {
                while ($query->fetch()) {    //fetch each option
                    $arr[$id] = $name;    //print out
                }
            } else {
                echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;    //debug the execution issue
            }
        } else {
            echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;    //debug the binding issue
        }
        $query->close();
    } else {
        echo "Prepare failed: " . $mysqli->errno . " " . $mysqli->error;    //debug the preparation issue
    }

    $stmt = "select j.id, j.companyID, c.name, j.title, j.description, j.pay, j.rating 
				from job j
				inner join company c
				on j.companyID = c.id";  //build table

    if ($query = $mysqli->prepare($stmt)) {
        if (!$query->execute()) {
            print "Execute failed: " . $query->errno . " " . $query->error;    //debug the execution issue
        }

        if (!$query->bind_result($id, $compID, $empName, $title, $description, $pay, $rating)) {
            print "Bind failed: " . $query->errno . " " . $query->error;    //debug the binding issue
        }

        while ($query->fetch()) {
            print  "<br>
						<form method='post' action='update.php'>    
							<table class='table'>
								<tr>
								<td><select name='compName'>";    //post on update
            foreach ($arr as $key => $val) {
                if ($key == $compID) {
                    print "<option value='$compID' selected='selected'>$val</option>";    //print company name in dropdown
                } else {
                    print "<option value='$key'>$val</option>";
                }
            }

            print "</select></td>
									<td><input type='text' name='title' value='$title'></td>
									<td><input type='text' name='description' value='$description'></td>
									<td><input type='number' name='pay' value='$pay'></td>
									<td><input type='number' name='rating' value='$rating' min='1' max='10'></td>
									<td><input type='submit' name='updateButton' value='Update'></td>
									<td><input type='submit' name='deleteButton' value='Delete'></td>
									<td><input type='hidden' name='jobID' value='$id'></td>
								</tr>
							</table>
						</form>
						<br>";    //print other variables with values entered
        }

        $query->close();
    } else {
        print "Prepare failed: " . $mysqli->errno . " " . $mysqli->error;    //debug the preparation issue
    }
}
?>