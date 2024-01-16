<?php
// Include your database connection code here

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["station_id"])) {
    // Get the selected station ID from the POST data
    $selectedStationId = $_POST["station_id"];

    // $conn = new mysqli("localhost", "id21716174_root","Hello@123","id21716174_pfs");
    $conn = new mysqli("localhost", "root","","pfsnew");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the query
    if ($selectedStationId === 'all') {
        // Query when "all" is selected
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
        // Query when a specific station is selected
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

    // Fetch the results into an associative array
    $feedbackData = $result->fetch_all(MYSQLI_ASSOC);

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();

    // Send the JSON response
    echo json_encode(['status' => 'success', 'feedbackData' => $feedbackData]);
} else {
    // Invalid request, send an error response
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
