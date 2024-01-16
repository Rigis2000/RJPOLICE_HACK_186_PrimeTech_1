<?php

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if 'action' is set in the POST data
    if (isset($_POST['action'])) {
        // $conn = new mysqli("localhost", "id21716174_root","Hello@123","id21716174_pfs");
        $conn = new mysqli("localhost", "root","","pfsnew");

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Perform the corresponding query based on the 'action'
        if ($_POST['action'] === 'avg') {
            $query = "SELECT
                        AVG(good) AS average_good,
                        AVG(neutral) AS average_neutral,
                        AVG(bad) AS average_bad
                    FROM
                        StationFeedback";

            $result = $conn->query($query);

            if ($result) {
                $data = $result->fetch_assoc();
                echo json_encode($data);
            } else {
                echo json_encode(['error' => 'Query failed']);
            }
        } elseif ($_POST['action'] === 'total') {
            $query = "SELECT
                        SUM(good) AS total_good,
                        SUM(neutral) AS total_neutral,
                        SUM(bad) AS total_bad
                    FROM
                        StationFeedback";

            $result = $conn->query($query);

            if ($result) {
                $data = $result->fetch_assoc();
                echo json_encode($data);
            } else {
                echo json_encode(['error' => 'Query failed']);
            }
        } else {
            echo json_encode(['error' => 'Invalid action']);
        }

        // Close the database connection
        $conn->close();
    } else {
        echo json_encode(['error' => 'Action not set']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
