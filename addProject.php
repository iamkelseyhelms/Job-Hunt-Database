<!---------------------------------------------------------
 - Author:          Kelsey Helms
 - Date Created:    March 10, 2017
 - Filename:        addProject.php
 -
 - Overview:
 - PHP file adds project to database.
 ---------------------------------------------------------->

<!------------------------------ Connect to Database ------------------------------>
<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "helmsk-db", "XKBMwuWgFy7m9FSJ", "helmsk-db");

if ($mysqli->connect_errno) {
    print "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

/****************************** Get variables from form ******************************/
if ($query = $mysqli->prepare("insert into project (name,description,state) values (?,?,?)")) {
    if ($query->bind_param("sss", $_POST['projName'], $_POST['projDescription'], $_POST['projState'])) {
        if ($query->execute()) {    //add to database
            $projID = $query->insert_id;    //get id to use in project_skills
            print "<p>Added " . $query->affected_rows . " rows to projects.</p>";    //print they were added
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

/****************************** Add to Project_Skills ******************************/
if (isset($_POST["projSkills"])) {
    $skills = $_POST["projSkills"];
    $rowCount = 0;
    foreach ($skills as $s) {
        if ($query = $mysqli->prepare("insert into project_skill (projectID,skillID) values (?,?)")) {
            if ($query->bind_param("ii",$projID,$s)) {
                if ($query->execute()) {    //add to database
                    $rowCount += $query->affected_rows;
                } else {
                    print "Execute failed: " . $mysqli->errno . " " . $mysqli->error;    //debug the execution issue
                }
            } else {
                print "Bind failed: " . $mysqli->errno . " " . $mysqli->error;    //debug the binding issue
            }
        } else {
            print "Prepare failed: " . $mysqli->errno . " " . $mysqli->error;    //debug the preparation issue
        }
    }
    print "<p>Added " . $rowCount . " rows to project_skill.</p>";    //print they were added
    $query->close();
} else {
    $skills = null;
    echo "no skill supplied";
}
print "<p><a href='index.php'>Back to form</a><p>";    //make sure there's a way to get back to form
?>