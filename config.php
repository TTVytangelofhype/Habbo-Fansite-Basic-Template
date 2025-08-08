<?php
// config.php - Database configuration and connection

// --- IMPORTANT: Replace these with your actual database credentials! ---
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'database username goes here');
define('DB_PASSWORD', 'database password goes here');
define('DB_NAME', 'database nane goes here');

// Attempt to connect to MySQL database
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

// Start the session for user authentication
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>