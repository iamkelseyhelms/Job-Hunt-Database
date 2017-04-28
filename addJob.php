<!---------------------------------------------------------
 - Author:          Kelsey Helms
 - Date Created:    March 10, 2017
 - Filename:        addJob.php
 -
 - Overview:
 - PHP file adds job to database.
 ---------------------------------------------------------->

<!------------------------------ Connect to Database ------------------------------>
<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "helmsk-db", "XKBMwuWgFy7m9FSJ", "helmsk-db");

if ($mysqli->connect_errno) {
    print "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

/****************************** Get variables from form ******************************/
if ($query = $mysqli->prepare("insert into job (title,companyID,description,pay,rating) values (?,?,?,?,?)")) {
    $optionalVals = array('jobPay');
    foreach ($optionalVals as $val) {    //if optional variables are not filled in, post null
        if (empty($_POST[$val])) {
            $_POST[$val] = null;
        }
    }

    if ($query->bind_param("sisss", $_POST['jobTitle'], $_POST['jobCompany'], $_POST['jobDescription'], $_POST['jobPay'], $_POST['jobRating'])) {
        if ($query->execute()) {    //add to database
            $jobID = $query->insert_id;    //get id to add job_skills
            print "<p>Added " . $query->affected_rows . " rows to jobs.</p>";    //print they were added
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

/****************************** Add to Job_Skills ******************************/
if (isset($_POST["jobSkills"])) {
    $skills = $_POST["jobSkills"];
    $rowCount = 0;
    foreach ($skills as $s) {
        if ($query = $mysqli->prepare("insert into job_skill (jobID,skillID) values (?,?)")) {
            if ($query->bind_param("ii", $jobID, $s)) {
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
    print "<p>Added " . $rowCount . " rows to job_skill.</p>";    //print they were added
    $query->close();
} else {
    $skills = null;
    echo "no skill supplied";
}
print "<p><a href='index.php'>Back to form</a><p>";    //make sure there's a way to get back to form
?>