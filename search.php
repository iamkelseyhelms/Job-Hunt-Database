<!---------------------------------------------------------
 - Author:          Kelsey Helms
 - Date Created:    March 10, 2017
 - Filename:        search.php
 -
 - Overview:
 - PHP file searchs database for entered requirements.
 ---------------------------------------------------------->

<!------------------------------ Connect to Database ------------------------------>
<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "helmsk-db", "XKBMwuWgFy7m9FSJ", "helmsk-db");

if ($mysqli->connect_errno) {
    print "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

/****************************** Search for requirements ******************************/
$stmt = "select c.name,j.title,j.description,j.pay,j.rating
			from company c
			inner join job j
			on c.id=j.companyID ";    //build table

$postCounter = 0;
if (!empty($_POST["searchCompany"])) {    //if searched for company
    $stmt .= "where j.companyID = {$_POST['searchCompany']} ";    //search for company like keyword
    $postCounter++;    //increase variables searched
}

if (!empty($_POST["searchTitle"])) {    //if searched for title
    if ($postCounter > 0) {    //if already searching a variable
        $stmt .= "and j.title like '%{$_POST['searchTitle']}%' ";    //add search for title like keyword
    } else {    //if not already searching a variable
        $stmt .= "where j.title like '%{$_POST['searchTitle']}%' ";    //search for title like keyword
    }
    $postCounter++;    //increase variables searched
}

if (!empty($_POST["searchPay"])) {    //if searched for pay
    if ($postCounter > 0) {    //if already searching a variable
        $stmt .= "and j.pay {$_POST['relPay']} {$_POST['searchPay']} ";    //add search for pay in greater, less than, equal
    } else {    //if not already searching a variable
        $stmt .= "where j.pay {$_POST['relPay']} {$_POST['searchPay']} ";    //search for pay in greater, less than, equal
    }
    $postCounter++;    //increase variables searched
}
if (!empty($_POST["searchRating"])) {    //if searched for rating
    if ($postCounter > 0) {    //if already searching a variable
        $stmt .= "and j.rating {$_POST['relRating']} {$_POST['searchRating']} ";    //add search for rating in greater, less than, equal
    } else {    //if not already searching a variable
        $stmt .= "where j.rating {$_POST['relRating']} {$_POST['searchRating']} ";    //search for rating in greater, less than, equal
    }
    $postCounter++;    //increase variables searched
}

//print $stmt;
if ($query = $mysqli->prepare($stmt)) {
    if ($query->execute()) {
        if ($query->bind_result($cname, $title, $desc, $pay, $rating)) {
            print "<style>table, th, td {border: 1px solid black;} </style>";
            print "<table style='border:1px solid black;'>
						<tr>
							<th>Company</th>
							<th>Title</th>
							<th>Description</th>
							<th>Pay</th>
							<th>Rating</th>
						</tr>";    //print the headers

            while ($query->fetch()) {
                print " <tr>
								<td>{$cname}</td>
								<td>{$title}</td>
								<td>{$desc}</td>
								<td>{$pay}</td>
								<td>{$rating}</td>
							</tr>";    //print the variable values

            }

            print "</table>";
            print "<p><a href='index.php'>Back to form</a><p>";    //make sure there's a way to get back to form
            $query->close();

        } else {
            print "Bind failed: " . $query->errno . " " . $query->error;    //debug the binding issue
        }
    } else {
        print "Execute failed: " . $query->errno . " " . $query->error;    //debug the execution issue
    }
} else {
    print "Prepare failed: " . $mysqli->errno . " " . $mysqli->error;    //debug the preparation issue
}
?>