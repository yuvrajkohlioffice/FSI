<?php
// 1. Include your existing configuration
include_once "includes/classes.php";

// Enable error reporting for debugging (Disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// --- HELPER FUNCTION: GET REAL IP ADDRESS ---
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// 2. Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ==================================================================
    // STEP 1: GOOGLE RECAPTCHA VERIFICATION
    // ==================================================================
    
    // YOUR SECRET KEY (From your code snippet)
    // If you are using Google's "Test Keys" (starting with 6LeIx...), swap this out!
    $recaptchaSecret = '6LembUErAAAAAHuj2dzXLqbesGGJurGbQ3Rk0ARG'; 
    
    $captchaResponse = $_POST['g-recaptcha-response'] ?? '';

    if (empty($captchaResponse)) {
        $_SESSION['message'] = 'Please check the "I am not a robot" box.';
        header("Location: enquiry");
        exit();
    }

    // Verify with Google
    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$captchaResponse}&remoteip=" . $_SERVER['REMOTE_ADDR'];
    
    // Get response
    $responseJSON = file_get_contents($verifyUrl);
    $responseData = json_decode($responseJSON, true);

    // Check if valid
    if (empty($responseData['success']) || $responseData['success'] !== true) {
        $_SESSION['message'] = 'Robot verification failed. Please try again.';
        header("Location: enquiry");
        exit();
    }

    // ==================================================================
    // STEP 2: DATA CAPTURE & SANITIZATION
    // ==================================================================

    $complaintID = time(); 

    // Prevent SQL Injection with mysql_real_escape_string
    $name      = mysql_real_escape_string($_POST['incidentName']);
    $address   = mysql_real_escape_string($_POST['incidentAddress']);
    $email     = mysql_real_escape_string($_POST['incidentEmail']);
    $phone     = mysql_real_escape_string($_POST['incidentMobile']);
    $complaint = mysql_real_escape_string($_POST['incidentComplaint']);

    // --- DATE FIXES ---
    $dateOnly  = date("Y-m-d");         // For 'crdate'
    $dateTime  = date("Y-m-d H:i:s");   // For 'registeredOn'

    // --- IP & BROWSER FIXES ---
    $ipAddress = getUserIP();
    // Convert IPv6 localhost to IPv4 for readability (Optional)
    if ($ipAddress == '::1') {
        $ipAddress = '127.0.0.1';
    }

    // Cut browser string to 79 chars to fit DB (limit 80)
    $browser   = substr($_SERVER['HTTP_USER_AGENT'], 0, 79); 

    // ==================================================================
    // STEP 3: DATABASE INSERTION
    // ==================================================================

    $query = "INSERT INTO `feedback` (
        `complaintID`, 
        `applicantName`, 
        `applicantAddress`, 
        `applicantMobile`, 
        `applicantEmail`, 
        `complaintDetails`, 
        `crdate`,
        `ipaddress`,  
        `browser`,
        `registeredOn`
    ) VALUES (
        '$complaintID',
        '$name',
        '$address',
        '$phone',
        '$email',
        '$complaint',
        '$dateOnly',
        '$ipAddress', 
        '$browser',
        '$dateTime'
    )";

    // Execute Query
    $rs = mysql_query($query);

    if ($rs) {
        $_SESSION['message'] = 'Feedback Submitted Successfully!';
        header("Location: enquiry");
        exit();
    } else {
        // Log error and redirect
        $error = mysql_error();
        $_SESSION['message'] = 'Database Error: ' . $error;
        header("Location: enquiry");
        exit();
    }

} else {
    // If user tries to open process.php directly
    header("Location: enquiry");
    exit();
}
?>