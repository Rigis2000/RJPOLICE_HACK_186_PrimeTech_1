<?php

$connection = new mysqli("localhost", "root", "" ,"id21716174_pfs");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback = filter_input(INPUT_POST, 'feedback', FILTER_SANITIZE_STRING);

    $stationID = filter_input(INPUT_POST, 'stationID', FILTER_VALIDATE_INT);
    
    if ($stationID === false || $stationID <= 0) {
        $response = array("status" => "error", "message" => "Invalid station ID");
    } elseif (!in_array($feedback, ['good', 'neutral', 'bad'])) {
        $response = array("status" => "error", "message" => "Invalid feedback value");
    } else {
        $stmt = $conn->prepare("UPDATE StationFeedback SET $feedback = $feedback + 1 WHERE station_id = ?");
        
        if ($stmt === false) {
            $response = array("status" => "error", "message" => "Error preparing statement");
        } else {
            $stmt->bind_param("i", $stationID);
            
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response = array("status" => "success", "message" => "Feedback is submitted");
            } else {
                $response = array("status" => "error", "message" => "Error updating feedback");
            }

            $stmt->close();
        }
    }
} else {
    $response = array("status" => "error", "message" => "Invalid request method");
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
