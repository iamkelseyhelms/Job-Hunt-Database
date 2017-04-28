<!---------------------------------------------------------
 - Author:          Kelsey Helms
 - Date Created:    March 10, 2017
 - Filename:        index.php
 -
 - Overview:
 - HTML file provides forms for user to interact with
 - database.
 ---------------------------------------------------------->

<!------------------------------ Connect to Database ------------------------------>
<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "helmsk-db", "XKBMwuWgFy7m9FSJ", "helmsk-db");

if ($mysqli->connect_errno) {
    print "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>

<!------------------------------ Page HTML ------------------------------>
<!DOCTYPE html PUBLIC>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Hunting</title>
    <?php include 'script.php'; ?>

    <!------------------------------ bootstrap for HTML from w3schools.com ------------------------------>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</head>
<body style="padding-top: 150px;">
<div class="container">

    <!------------------------------ Set up tab menu ------------------------------>
    <nav class="navbar-fixed-top" style="background-color: white;">
        <h1 class="text-center">Job Hunting</h1>
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#insertTab">Insert</a></li>
            <li><a data-toggle="tab" href="#modifyTab">Modify</a></li>
            <li><a data-toggle="tab" href="#searchTab">Search</a></li>
            <li><a data-toggle="tab" href="#viewTab">View</a></li>
        </ul>
    </nav>

    <div class="tab-content">

        <!------------------------------ INSERT tab ------------------------------>
        <div id="insertTab" class="tab-pane fade in active">

            <!------------------------------ Add Company ------------------------------>
            <div class="container" style="padding-bottom: 30px;">
                <h2>Add Company</h2>
                <form method="post" action="addCompany.php">
                    <div class="form-group">
                        <label for="compName">Name:</label>
                        <input type="text" class="form-control" name="compName" id="compName" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="compCommuteTime">Commute Time:</label>
                        <input type="number" class="form-control" name="compCommuteTime" id="compCommuteTime"
                               placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="compRating">Rating:</label>
                        <input type="range" name="compRating" id="compRating" value="5" min="1" max="10"
                               oninput="compRatingValue.value = compRating.value" required>
                        <output name="ratingValue" id="compRatingValue">5</output>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-default" id="addCompanyButton">
                    </div>
                </form>
            </div>

            <!------------------------------ Add Job ------------------------------>
            <div class="container" style="padding-bottom: 30px;">
                <h2>Add Job</h2>
                <form method="post" action="addJob.php">
                    <div class="form-group">
                        <label for="jobTitle">Title:</label>
                        <input type="text" class="form-control" name="jobTitle" id="jobTitle" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="jobCompany">Company:</label><br>
                        <select class="form-control" name="jobCompany" id="jobCompany" required>
                            <option value="">Select One</option>
                            <?php $tbl = "company";
                            selectName($tbl); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jobDescription">Description:</label>
                        <textarea class="form-control" name="jobDescription" id="jobDescription" placeholder=""
                                  required></textarea>
                    </div>
                    <div class="for-group">
                        <label for="jobSkill">Skills:</label>
                        <select class="form-control" name="jobSkills[]" id="jobSkill" multiple>
                            <?php $tbl = "skill";
                            selectName($tbl); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jobPay">Pay:</label>
                        <input type="number" class="form-control" name="jobPay" id="jobPay" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="jobRating">Rating:</label>
                        <input type="range" name="jobRating" id="jobRating" value="5" min="1" max="10"
                               oninput="jobRatingValue.value = jobRating.value" required>
                        <output name="ratingValue" id="jobRatingValue">5</output>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-default" id="addJobButton">
                    </div>
                </form>
            </div>

            <!------------------------------ Add Skill ------------------------------>
            <div class="container" style="padding-bottom: 30px;">
                <h2>Add Skill</h2>
                <form method="post" action="addSkill.php">
                    <div class="form-group">
                        <label for="skillName">Name:</label>
                        <input type="text" class="form-control" name="skillName" id="skillName" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>Proficiency:</label><br>
                        <input type="radio" name="skillProficiency" value="poor" required> Poor<br>
                        <input type="radio" name="skillProficiency" value="acceptable"> Acceptable<br>
                        <input type="radio" name="skillProficiency" value="good"> Good<br>
                        <input type="radio" name="skillProficiency" value="excellent"> Excellent
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-default" id="addSkillButton">
                    </div>
                </form>
            </div>

            <!------------------------------ Add Project ------------------------------>
            <div class="container" style="padding-bottom: 30px;">
                <h2>Add Project</h2>
                <form method="post" action="addProject.php">
                    <div class="form-group">
                        <label for="projName">Name:</label>
                        <input type="text" class="form-control" name="projName" id="projName" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="projDescription">Description:</label>
                        <textarea class="form-control" name="projDescription" id="projDescription" placeholder=""
                                  required></textarea>
                    </div>
                    <div class="for-group">
                        <label for="projSkill">Skills:</label>
                        <select class="form-control" name="projSkills[]" id="projSkill" multiple>
                            <?php $tbl = "skill";
                            selectName($tbl); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status:</label><br>
                        <input type="radio" name="projState" value="planned" required> Planned<br>
                        <input type="radio" name="projState" value="in progress"> In Progress<br>
                        <input type="radio" name="projState" value="completed"> Completed
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-default" id="addProjectButton">
                    </div>
                </form>
            </div>

            <!------------------------------ Add Employee ------------------------------>
            <div class="container" style="padding-bottom: 30px;">
                <h2>Add Employee</h2>
                <form method="post" action="addEmployee.php">
                    <div class="form-group">
                        <label for="empFname">First Name:</label>
                        <input type="text" class="form-control" name="empFname" id="empFname" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="empLname">Last Name:</label>
                        <input type="text" class="form-control" name="empLname" id="empLname" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="empCompany">Company:</label><br>
                        <select class="form-control" name="empCompany" id="empCompany" required>
                            <option value="">Select One</option>
                            <?php $tbl = "company"; selectName($tbl); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="empEmail">Email:</label>
                        <input type="email" class="form-control" name="empEmail" id="empEmail" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Source:</label><br>
                        <input type="radio" name="empSource" value="friend"> Friend<br>
                        <input type="radio" name="empSource" value="networking"> Networking<br>
                        <input type="radio" name="empSource" value="interview"> Interview<br>
                        <input type="radio" name="empSource" value="linkedin"> LinkedIn
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-default" id="addEmployeeButton">
                    </div>
                </form>
            </div>
        </div>


        <!------------------------------ MODIFY tab ------------------------------>
        <div id="modifyTab" class="tab-pane fade">
            <div class="container">
                <h2>Jobs</h2>
                <div class="form-group"><label style="padding-left:10px;">Company</label>
                    <label style="padding-left:50px;">Title</label>
                    <label style="padding-left:210px;">Description</label>
                    <label style="padding-left:157px;">Pay</label>
                    <label style="padding-left:210px;">Rating</label><br>
                    <?php buildJobTable(); ?>
                </div>
            </div>
        </div>


        <!------------------------------ SEARCH tab ------------------------------>
        <div id="searchTab" class="tab-pane fade">
            <div class="container">
                <h2>Find Jobs</h2>
                <form method="post" action="search.php">
                    <div class="form-group">
                        <label for="searchTitle">Title:</label>
                        <input type="text" class="form-control" name="searchTitle" id="searchTitle" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="searchCompany">Company:</label><br>
                        <select class="form-control" name="searchCompany" id="searchCompany">
                            <option value="">Select One</option>
                            <?php $tbl = "company"; selectName($tbl); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="searchPay">Pay:</label>
                        <select class="form-control" name="relPay">
                            <option value="=">equal to</option>
                            <option value=">">greater than</option>
                            <option value="<">less than</option>
                        </select>
                        <input type="number" class="form-control" name="searchPay" id="searchPay" value="" min="0">
                    </div>
                    <div class="form-group">
                        <label for="searchRating">Rating:</label>
                        <select class="form-control" name="relRating">
                            <option value="=">equal to</option>
                            <option value=">">greater than</option>
                            <option value="<">less than</option>
                        </select>
                        <input type="number" class="form-control" name="searchRating" id="searchRating" value="" min="1"
                               max="10">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-default" id="searchButton">
                    </div>
                </form>
            </div>
        </div>


        <!------------------------------ VIEW tab ------------------------------>
        <div id="viewTab" class="tab-pane fade">
            <div class="container">
                <form method="post" action="view.php">
                    <h2>View Tables</h2>
                    <div class="form-group">
                        <input type="checkbox" name="tbl[]" value="company">
                        <label style="padding-right: 200px;"> Companies</label>
                        <input type="checkbox" name="tbl[]" value="job">
                        <label style="padding-right: 200px;"> Jobs</label>
                        <input type="checkbox" name="tbl[]" value="skill">
                        <label style="padding-right: 200px;"> Skills</label>
                        <input type="checkbox" name="tbl[]" value="project">
                        <label> Projects</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="tbl[]" value="employee">
                        <label style="padding-right: 202px;"> Employees</label>
                        <input type="checkbox" name="tbl[]" value="jobSkill">
                        <label style="padding-right: 148px;"> Jobs & Skills</label>
                        <input type="checkbox" name="tbl[]" value="projectSkill">
                        <label> Projects & Skills</label>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-default" id="viewButton">
                    </div>
                </form>
            </div>
        </div>


    </div>
</div>
</body>
</html>