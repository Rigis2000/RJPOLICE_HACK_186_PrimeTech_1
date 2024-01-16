<?php

$conn = new mysqli("localhost", "root","","pfsnew");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT Stations.station_id, Stations.station_name, BigFeedback.feedback, BigFeedback.fd_name, BigFeedback.feedback_datetime
        FROM Stations
        JOIN BigFeedback ON Stations.station_id = BigFeedback.station_id
        ORDER BY BigFeedback.feedback_id DESC
        LIMIT 5";
$result = $conn->query($sql);

$conn->close();
?>