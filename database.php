<?php

// Database connection variables
$hostName = "localhost"; // Hostname of the database server
$dbUser = "root";        // Database username
$dbpassword = "";        // Database password (empty in this case)
$dbName = "login_register"; // Name of the database

// Create a connection to the MySQL database
$conn = mysqli_connect($hostName, $dbUser, $dbpassword, $dbName);

// Check if the connection was successful
if(!$conn){
    // If the connection fails, display an error message and terminate the script
    die("Something went wrong");
}

?>
