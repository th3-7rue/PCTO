<?php
$servername = "localhost";
$username = "stage02_user";
$password = "?88oyS4x7";
$dbname = "stage02_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
