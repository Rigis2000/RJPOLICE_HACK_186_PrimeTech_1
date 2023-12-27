<?php

$servername = "localhost";
$username = "id21716174_root";
$password = "Hello@123";
$database = "id21716174_pfs";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback = $_POST["feedback"];

    $createQuery = "UPDATE feedback SET $feedback = $feedback + 1 WHERE id = 1;";
    $result = $conn->query($createQuery);

    if ($result) {
        $response = array("status" => "success", "message" => "Feedback is submitted");
    } else {
        $response = array("status" => "error", "message" => "Error updating feedback");
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

$conn->close();
?>
