<?php
// Database connection
$servername = "103.196.152.154"; // Replace with your database server
$username = "root";        // Replace with your database username
$password = "exsithal@2025";            // Replace with your database password
$dbname = "exsithal";      // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
