<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "project";  // change this to your actual database name

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>