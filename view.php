<!---------------------------------------------------------
 - Author:          Kelsey Helms
 - Date Created:    March 10, 2017
 - Filename:        view.php
 -
 - Overview:
 - PHP file views selected tables.
 ---------------------------------------------------------->

<!------------------------------ Connect to Database ------------------------------>
<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "helmsk-db", "XKBMwuWgFy7m9FSJ", "helmsk-db");

if ($mysqli->connect_errno) {
    print "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

print "<style>table, th, td {border: 1px solid black;} </style>";

foreach ($_POST['tbl'] as $t) {
    if (isset($t)) {
        /****************************** View Companies ******************************/
        if ($t == 'company') {    //if company is chosen
            $stmt = "select name,commuteTime,rating from company";    //build the table

            if ($query = $mysqli->prepare($stmt)) {
                if ($query->execute()) {
                    if ($query->bind_result($cname, $commuteTime, $rating)) {
                        print " 
									<table>
										<caption><strong>Companies</strong></caption>
										<tr>
											<th>Name</th>
											<th>Commute Time</th>
											<th>Rating</th>
										</tr>";    //print the headers
                        while ($query->fetch()) {
                            print " <tr>
											<td>{$cname}</td>
											<td>{$commuteTime}</td>
											<td>{$rating}</td>
										</tr>";    //print the variable values
                        }
                        print "</table>";
                        print "<p><a href='index.php'>Back to form</a><p>";    //make sure there's a way to get back to form
                    } else {
                        print "Bind failed: " . $query->errno . " " . $query->error;    //debug the binding issue
                    }
                } else {
                    print "Execute failed: " . $query->errno . " " . $query->error;    //debug the execution issue
                }
                $query->close();
            } else {
                print "Prepare failed: " . $mysqli->errno . " " . $mysqli->error;    //debug the preparation issue
            }
        }
        /****************************** View Jobs ******************************/
        else if ($t == 'job') {    //if job is chosen
            $stmt = "select c.name,j.title,j.description,j.pay,j.rating
						  from company c 
						  inner join job j
						  on c.id=j.companyID";    //build the table

            if ($query = $mysqli->prepare($stmt)) {
                if ($query->execute()) {
                    if ($query->bind_result($comp, $title, $jdescription, $pay, $rating)) {
                        print " 
									<table>
										<caption><strong>Jobs</strong></caption>
										<tr>
											<th>Company</th>
											<th>Title</th>
											<th>Description</th>
											<th>Pay</th>
											<th>Rating</th>
										</tr>";    //print the headers
                        while ($query->fetch()) {
                            print " <tr>
											<td>{$comp}</td>
											<td>{$title}</td>
											<td>{$jdescription}</td>
											<td>{$pay}</td>
											<td>{$rating}</td>
										</tr>";    //print the variable values
                        }
                        print "</table>";
                        print "<p><a href='index.php'>Back to form</a><p>";    //make sure there's a way to get back to form
                    } else {
                        print "Bind failed: " . $query->errno . " " . $query->error;    //debug the binding issue
                    }
                } else {
                    print "Execute failed: " . $query->errno . " " . $query->error;    //debug the execution issue
                }
                $query->close();
            } else {
                print "Prepare failed: " . $mysqli->errno . " " . $mysqli->error;    //debug the preparation issue
            }
        }
        /****************************** View Skills ******************************/
        else if ($t == 'skill') {    //if skill is chosen
            $stmt = "select name, proficiency from skill";    //build the table

            if ($query = $mysqli->prepare($stmt)) {
                if ($query->execute()) {
                    if ($query->bind_result($sname, $proficiency)) {
                        print " 
									<table>
										<caption><strong>Skills</strong></caption>
										<tr>
											<th>Name</th>
											<th>Proficiency</th>
										</tr>";    //print the headers
                        while ($query->fetch()) {
                            print " <tr>
											<td>{$sname}</td>
											<td>{$proficiency}</td>
										</tr>";    //print the variable values
                        }
                        print "</table>";
                        print "<p><a href='index.php'>Back to form</a><p>";    //make sure there's a way to get back to form
                    } else {
                        print "Bind failed: " . $query->errno . " " . $query->error;    //debug the binding issue
                    }
                } else {
                    print "Execute failed: " . $query->errno . " " . $query->error;    //debug the execution issue
                }
                $query->close();
            } else {
                print "Prepare failed: " . $mysqli->errno . " " . $mysqli->error;    //debug the preparation issue
            }
        }
        /****************************** View Projects ******************************/
        else if ($t == 'project') {    //if project is chosen
            $stmt = "select name,description,state from project";    //build the table

            if ($query = $mysqli->prepare($stmt)) {
                if ($query->execute()) {
                    if ($query->bind_result($pname, $description, $state)) {
                        print " 
									<table>
										<caption><strong>Projects</strong></caption>
										<tr>
										    <th>Name</th>
											<th>Description</th>
											<th>Status</th>
										</tr>";    //print the headers
                        while ($query->fetch()) {
                            print " <tr>
                                            <td>{$pname}</td>
											<td>{$description}</td>
											<td>{$state}</td>
										</tr>";    //print the variable values

                        }
                        print "</table>";
                        print "<p><a href='index.php'>Back to form</a><p>";    //make sure there's a way to get back to form
                    } else {
                        print "Bind failed: " . $query->errno . " " . $query->error;    //debug the binding issue
                    }
                } else {
                    print "Execute failed: " . $query->errno . " " . $query->error;    //debug the execution issue
                }
                $query->close();
            } else {
                print "Prepare failed: " . $mysqli->errno . " " . $mysqli->error;    //debug the preparation issue
            }
        }
        /****************************** View Employees ******************************/
        else if ($t == 'employee') {    //if employee is chosen
            $stmt = "select e.fname,e.lname,c.name,e.email,e.source
						  from company c 
						  inner join employee e
						  on c.id=e.companyID";    //build the table

            if ($query = $mysqli->prepare($stmt)) {
                if ($query->execute()) {
                    if ($query->bind_result($fname, $lname, $ecomp, $email, $source)) {
                        print " 
									<table>
										<caption><strong>Employees</strong></caption>
										<tr>
											<th>First Name</th>
											<th>Last Name</th>
											<th>Company</th>
											<th>Email</th>
											<th>Source</th>
										</tr>";    //print the headers
                        while ($query->fetch()) {
                            print " <tr>
											<td>{$fname}</td>
											<td>{$lname}</td>
											<td>{$ecomp}</td>
											<td>{$email}</td>
											<td>{$source}</td>
										</tr>";    //print the variable values
                        }
                        print "</table>";
                        print "<p><a href='index.php'>Back to form</a><p>";    //make sure there's a way to get back to form
                    } else {
                        print "Bind failed: " . $query->errno . " " . $query->error;    //debug the binding issue
                    }
                } else {
                    print "Execute failed: " . $query->errno . " " . $query->error;    //debug the execution issue
                }
                $query->close();
            } else {
                print "Prepare failed: " . $mysqli->errno . " " . $mysqli->error;    //debug the preparation issue
            }
        }
        /****************************** View Job_Skills ******************************/
        else if ($t == 'jobSkill') {    //if job_skill is chosen
            $stmt = "select c.name,j.title,j.description,j.pay,j.rating,s.name,s.proficiency
						  from job j 
						  inner join job_skill js 
						  on j.id=js.jobID
						  inner join skill s
						  on js.skillID=s.id
						  inner join company c
                          on j.companyID=c.id
						  order by j.title";    //build the table

            if ($query = $mysqli->prepare($stmt)) {
                if ($query->execute()) {
                    if ($query->bind_result($cname, $jname, $desc, $pay, $rating, $sname, $prof)) {
                        print " 
									<table>
										<caption><strong>Jobs & Skills</strong></caption>
										<tr>
											<th>Company</th>
											<th>Title</th>
											<th>Description</th>
											<th>Pay</th>
											<th>Rating</th>
											<th>Skill</th>
											<th>Proficiency</th>
										</tr>";    //print the headers
                        while ($query->fetch()) {
                            print " <tr>
                                            <td>{$cname}</td>
											<td>{$jname}</td>
											<td>{$desc}</td>
											<td>{$pay}</td>
											<td>{$rating}</td>
											<td>{$sname}</td>
											<td>{$prof}</td>
										</tr>";    //print the variable values
                        }
                        print "</table>";
                        print "<p><a href='index.php'>Back to form</a><p>";    //make sure there's a way to get back to form
                    } else {
                        print "Bind failed: " . $query->errno . " " . $query->error;    //debug the binding issue
                    }
                } else {
                    print "Execute failed: " . $query->errno . " " . $query->error;    //debug the execution issue
                }
                $query->close();
            } else {
                print "Prepare failed: " . $mysqli->errno . " " . $mysqli->error;    //debug the preparation issue
            }
        }
        /****************************** View Project_Skills ******************************/
        else if ($t == 'projectSkill') {    //if project_skill is chosen
            $stmt = "select p.name,p.description,p.state,s.name,s.proficiency
						 from skill s 
						 inner join project_skill ps
						 on s.id=ps.skillID
						 inner join project p 
						 on ps.projectID=p.id
						 order by p.name";    //build the table

            if ($query = $mysqli->prepare($stmt)) {
                if ($query->execute()) {
                    if ($query->bind_result($pname, $description, $state, $sname, $proficiency)) {
                        print " 
									<table>
										<caption><strong>Projects & Skills</strong></caption>
										<tr>
											<th>Project</th>
											<th>Description</th>
											<th>Status</th>
											<th>Skill</th>
											<th>Proficiency</th>
										</tr>";    //print the headers
                        while ($query->fetch()) {
                            print " <tr>
											<td>{$pname}</td>
											<td>{$description}</td>
											<td>{$state}</td>
											<td>{$sname}</td>
											<td>$proficiency</td>
										</tr>";    //print the variable values
                        }
                        print "</table>";
                        print "<p><a href='index.php'>Back to form</a><p>";    //make sure there's a way to get back to form
                    } else {
                        print "Bind failed: " . $query->errno . " " . $query->error;    //debug the binding issue
                    }
                } else {
                    print "Execute failed: " . $query->errno . " " . $query->error;    //debug the execution issue
                }
                $query->close();
            } else {
                print "Prepare failed: " . $mysqli->errno . " " . $mysqli->error;    //debug the preparation issue
            }
        }
    }
}
?>