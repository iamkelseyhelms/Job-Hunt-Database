<!---------------------------------------------------------
 - Author:          Kelsey Helms
 - Date Created:    March 10, 2017
 - Filename:        addEmployee.php
 -
 - Overview:
 - PHP file adds employee to database.
 ---------------------------------------------------------->

<!------------------------------ Connect to Database ------------------------------>
<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "helmsk-db", "XKBMwuWgFy7m9FSJ", "helmsk-db");

if ($mysqli->connect_errno) {
    print "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

/****************************** Get variables from form ******************************/
if ($query = $mysqli->prepare("insert into employee (fname,lname,companyID,email,source) values (?,?,?,?,?)")) {
    $optionalVals = array('empEmail', 'empSource');
    foreach ($optionalVals as $val) {    //if optional variables are not filled in, post null
        if (empty($_POST[$val])) {
            $_POST[$val] = null;
        }
    }

    if ($query->bind_param("ssiss", $_POST['empFname'], $_POST['empLname'], $_POST['empCompany'], $_POST['empEmail'], $_POST['empSource'])) {
        if ($query->execute()) {    //add to database
            print "<p>Added " . $query->affected_rows . " rows to employees.</p>";    //print they were added
        } else {
            print "Execute failed: " . $query->errno . " " . $query->error;    //debug the execution issue
        }
    } else {
        print "Bind failed: " . $query->errno . " " . $query->error;    //debug the binding issue
    }
    $query->close();
} else {
    print "Prepare failed: " . $mysqli->errno . " " . $mysqli->error;    //debug the preparation issue
}
print "<p><a href='index.php'>Back to form</a><p>";    //make sure there's a way to get back to form
?>