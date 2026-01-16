<?php
/**
 * Database Connection & Compatibility Layer
 * * This script initializes the database configuration and provides a 
 * shim (wrapper) to support legacy mysql_* functions using the modern mysqli extension.
 */

// 1. Security & Configuration Headers
// ---------------------------------------------------------
header('X-Frame-Options: SAMEORIGIN'); // Prevent Clickjacking
// header("Set-Cookie: $sessname=$sess_ID; httpOnly"); // Uncomment if session handling is needed
error_reporting(0); // Production setting: Turn off error display (Use error logging instead)

// 2. Includes
// ---------------------------------------------------------
include_once "functions.php";
// define("DIR_PATH", "http://localhost/fsinewwebsite"); // Define constants if required

// 3. MySQL Compatibility Shim (For PHP 7+)
// ---------------------------------------------------------
// The mysql_* extension was removed in PHP 7.0. This block re-defines those functions
// using mysqli, allowing legacy code to run without rewriting every query.
if (!function_exists('mysql_connect')) {

    /**
     * Establishes a connection to the database (Shim).
     * Mimics mysql_connect by caching connections in a global array.
     */
    function mysql_connect($server, $username, $password, $new_link = false, $client_flags = 0) {
        // Create a unique key for this connection signature
        $key = md5($server . $username . $password);

        // Initialize global connection storage if needed
        if (!isset($GLOBALS['mysql_cons'])) {
            $GLOBALS['mysql_cons'] = [];
        }

        // Return existing connection if strictly required (unless new_link is requested)
        if (!$new_link && isset($GLOBALS['mysql_cons'][$key])) {
            return $GLOBALS['mysql_cons'][$key];
        }

        // Attempt to create a new MySQLi connection
        // Note: 'new mysqli' automatically attempts to connect.
        $con = @new mysqli($server, $username, $password);

        // Check for connection failures
        if ($con->connect_error) {
            return false;
        }

        // Store the successful connection
        $GLOBALS['mysql_cons'][$key] = $con;

        // Set the default connection if one doesn't exist
        if (!isset($GLOBALS['mysql_cons']['default'])) {
            $GLOBALS['mysql_cons']['default'] = $con;
        }

        return $con;
    }

    /**
     * Selects a MySQL database.
     */
    function mysql_select_db($dbname, $con = null) {
        $con = $con ?? $GLOBALS['mysql_cons']['default'];
        return $con->select_db($dbname);
    }

    /**
     * Sends a query to the currently active database.
     */
    function mysql_query($query, $con = null) {
        $con = $con ?? $GLOBALS['mysql_cons']['default'];
        return $con->query($query);
    }

    /**
     * Escapes special characters in a string for use in an SQL statement.
     */
    function mysql_real_escape_string($val, $con = null) {
        $con = $con ?? $GLOBALS['mysql_cons']['default'];
        return $con->escape_string($val);
    }

    /**
     * Get the ID generated in the last query.
     */
    function mysql_insert_id($con = null) {
        $con = $con ?? $GLOBALS['mysql_cons']['default'];
        return $con->insert_id;
    }

    /**
     * Returns the text of the error message from previous operation.
     */
    function mysql_error($con = null) {
        $con = $con ?? $GLOBALS['mysql_cons']['default'];
        return $con->error;
    }

    /**
     * Fetch a result row as an associative array.
     */
    function mysql_fetch_assoc($result) {
        return $result ? $result->fetch_assoc() : null;
    }

    /**
     * Fetch a result row as an associative array, a numeric array, or both.
     */
    function mysql_fetch_array($result) {
        return $result ? $result->fetch_array() : null;
    }
 
    /**
     * Get number of rows in result.
     */
    function mysql_num_rows($result) {
        return $result ? $result->num_rows : 0;
    }

    /**
     * Move internal result pointer.
     */
    function mysql_data_seek($result, $offset) {        
        return $result ? $result->data_seek($offset) : false;
    }
}

// 4. Application Initialization
// ---------------------------------------------------------

// Initialize Database Configuration
// Ensure these credentials are correct for your local environment.
// It is best practice to move credentials to a separate, non-public config file.
$config = new config("localhost", "root", "", "fsiWebsiteDb");
//$config = new config("fsinicDB","fsi","D3%zy#awQ","fsi");
// Initialize Helper Classes
// /$config = new config("localhost","root","","fsi");
// // $config = new config("localhost","root","Fs!@2)@3WeBDb","db_main");
// $config = new config("localhost","root","","fsiWebsiteDb");
// // $config = new Config();
// // $config->connect('localhost', 'root', '', 'fsiWebsiteDb');
// $common = new common();
// $catalog = new catalog();
$common = new common();
$catalog = new catalog();

?>


