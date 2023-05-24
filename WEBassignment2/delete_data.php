<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to the MySQL database
$servername = "localhost";
$username = "INSERT_NAME";
$password = "INSERT_PASSWORD";
$dbname = "jedalen";
$conn = mysqli_connect($servername, $username, $password, $dbname);


$query = "DELETE FROM eatandmeet";
mysqli_query($conn, $query);
$query = "DELETE FROM  menus";
mysqli_query($conn, $query);
$query = "DELETE FROM  prifuk";
mysqli_query($conn, $query);
$query = "DELETE FROM  cantina";
mysqli_query($conn, $query);
?>