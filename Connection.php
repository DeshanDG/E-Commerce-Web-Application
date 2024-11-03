<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "HotelDB";

// Create connection
$conn = mysqli_connect($servername, $username, $password , $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "<script>console.log('Connected successfully!');</script>";
?>



