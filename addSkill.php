<!---------------------------------------------------------
 - Author:          Kelsey Helms
 - Date Created:    March 10, 2017
 - Filename:        addSkill.php
 -
 - Overview:
 - PHP file adds skill to database.
 ---------------------------------------------------------->

<!------------------------------ Connect to Database ------------------------------>
<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "helmsk-db", "XKBMwuWgFy7m9FSJ", "helmsk-db");

if ($mysqli->connect_errno) {
    print "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

/****************************** Get variables from form ******************************/
if ($query = $mysqli->prepare("insert into skill (name,proficiency) values (?,?)")) {
    if ($query->bind_param("ss", $_POST['skillName'], $_POST['skillProficiency'])) {
        if ($query->execute()) {    //add to database
            print "<p>Added " . $query->affected_rows . " rows to skills.</p>";    //print they were added
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