<?php

$connection = new mysqli("localhost", "root", "" ,"id21716174_pfs");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM BigFeedback";
$result = $conn->query($sql);

$conn->close();
?>
