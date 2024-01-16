<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["station_id"])) {
    $selectedStationId = $_POST["station_id"];

    $conn = new mysqli("localhost", "root","","pfsnew");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($selectedStationId === 'all') {
        $query = "SELECT
                    s.station_id,
                    s.station_name,
                    bf.feedback,
                    bf.feedback_datetime,
                    bf.fd_name
                FROM
                    Stations s
                JOIN
                    BigFeedback bf ON s.station_id = bf.station_id";
    } else {
        $query = "SELECT
                    s.station_id,
                    s.station_name,
                    bf.feedback,
                    bf.feedback_datetime,
                    bf.fd_name
                FROM
                    Stations s
                JOIN
                    BigFeedback bf ON s.station_id = bf.station_id
                WHERE
                    s.station_id = ?";
    }

    $stmt = $conn->prepare($query);

    if ($selectedStationId !== 'all') {
        $stmt->bind_param("i", $selectedStationId);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $feedbackData = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $conn->close();

    echo json_encode(['status' => 'success', 'feedbackData' => $feedbackData]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
