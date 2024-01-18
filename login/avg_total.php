<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $conn = new mysqli("localhost", "root","","pfsnew");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

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

        $conn->close();
    } else {
        echo json_encode(['error' => 'Action not set']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
