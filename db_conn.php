<?php
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "rekod-pekerja";

$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
