<?php
$host = "localhost";
$user = "root";
$pass = "YOUR_PASSWORD";
$dbname = "thrift";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
