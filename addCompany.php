<!---------------------------------------------------------
 - Author:          Kelsey Helms
 - Date Created:    March 10, 2017
 - Filename:        addCompany.php
 -
 - Overview:
 - PHP file adds company to database.
 ---------------------------------------------------------->

<!------------------------------ Connect to Database ------------------------------>
<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "helmsk-db", "XKBMwuWgFy7m9FSJ", "helmsk-db");

if ($mysqli->connect_errno) {
    print "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

/****************************** Get variables from form ******************************/
if ($query = $mysqli->prepare("insert into company (name, commuteTime, rating) values (?,?,?)")) {
    $optionalVals = array('compCommuteTime');
    foreach ($optionalVals as $val) {    //if optional variables are not filled in, post null
        if (empty($_POST[$val])) {
            $_POST[$val] = null;
        }
    }

    if ($query->bind_param("sis", $_POST['compName'], $_POST['compCommuteTime'], $_POST['compRating'])) {    //add to database
        if ($query->execute()) {
            print "<p>Added " . $query->affected_rows . " rows to companies.</p>";    //print they were added
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