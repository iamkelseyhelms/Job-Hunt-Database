<!---------------------------------------------------------
 - Author:          Kelsey Helms
 - Date Created:    March 10, 2017
 - Filename:        update.php
 -
 - Overview:
 - PHP file updates and deletes selected jobs from database.
 ---------------------------------------------------------->

<!------------------------------ Connect to Database ------------------------------>
<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "helmsk-db", "XKBMwuWgFy7m9FSJ", "helmsk-db");

if ($mysqli->connect_errno) {
    print "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

/****************************** Update values ******************************/
if (isset($_POST['updateButton'])) {
    $stmt = "update job set 
				title = ?, 
				companyID = ?,
				description = ?,
				pay = ?,
				rating = ?
				where id = ?";    //update values

    if ($query = $mysqli->prepare($stmt)) {
        if ($query->bind_param("ssssss", $_POST['title'], $_POST['compName'], $_POST['description'], $_POST['pay'], $_POST['rating'], $_POST['jobID'])) {
            if ($query->execute()) {    //update in database
                print "<p>Updated " . $query->affected_rows . " rows in job.</p>";    //print they were updated
                print "<p><a href='index.php'>Back to form</a><p>";    //make sure there's a way to get back to form
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
}

/****************************** Delete values ******************************/
if (isset($_POST['deleteButton'])) {
    $stmt = "delete from job 
				where id = ?";    //delete values

    if ($query = $mysqli->prepare($stmt)) {
        if ($query->bind_param("s", $_POST['jobID'])) {
            if ($query->execute()) {    //delete from database
                print "<p>Deleted " . $query->affected_rows . " rows from job.</p>";    //print they were deleted
                print "<p><a href='index.php'>Back to form</a><p>";    //make sure there's a way to get back to form
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
}
?>