<?php

$conn = new mysqli("localhost", "root", "", "pfsnew");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['station_id'])) {
    $stationId = $_POST['station_id'];

    $sql = "SELECT good, neutral, bad FROM StationFeedback WHERE station_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $stationId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            echo json_encode([
                'status' => 'success',
                'feedback' => [
                    'good' => $row['good'],
                    'neutral' => $row['neutral'],
                    'bad' => $row['bad']
                ]
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No feedback found for the given station_id'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error executing the SQL query'
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'station_id parameter is missing'
    ]);
}

$conn->close();
?>
