<?php
define('DB_SERVER', 'localhost'); // or your db server
define('DB_USERNAME', 'u228319900_fsi'); // your database username
define('DB_PASSWORD', 'Mss@2025'); // your database password
define('DB_NAME', 'u228319900_fsi'); // the database name

// Attempt to connect to MySQL database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("ERROR: Could not connect. " . $conn->connect_error);
}
?>