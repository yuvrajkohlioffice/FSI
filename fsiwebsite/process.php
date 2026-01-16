<?php
include_once "includes/classes.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Begin the session
session_start();

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

// To avoid case conflicts, make the input uppercase and check against the session value
// If it's correct, echo '1' as a string
if ($_POST) {
	// CAPTCHA Secret: 6LembUErAAAAAHuj2dzXLqbesGGJurGbQ3Rk0ARG
    // Example of generating a unique ID (optional)
    $complaintID = time(); // or use auto-increment in DB
    
    $name      = $_POST['incidentName'];
    $address   = $_POST['incidentAddress'];
    $email     = $_POST['incidentEmail'];
    $phone     = $_POST['incidentMobile'];
    $complaint = $_POST['incidentComplaint'];
    $captcha =  $_POST['captcha'];
    $today     = date("Y-m-d");

    $query = "INSERT INTO `feedback` (
        `complaintID`, `applicantName`, `applicantAddress`, `applicantMobile`, `applicantEmail`, `complaintDetails`, `crdate`
        ) VALUES (
            '$complaintID',
            '$name',
            '$address',
            '$phone',
            '$email',
            '$complaint',
            '$today'
        )";

    $rs = mysql_query($query);

    if($rs)
	{
        $_SESSION['message'] = 'Feedback Submit successfully!';
        header("Location: enquiry");    
	}
	else
	{
        $_SESSION['message'] = 'Error inserting data: ' . $con->error;
        header("Location: enquiry");
        exit();
	}

} else {
    echo 'false';
}

?>
