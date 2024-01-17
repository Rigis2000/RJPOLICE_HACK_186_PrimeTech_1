<?php


$conn = new mysqli("localhost", "root","","pfsnew");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$response = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stationID = filter_input(INPUT_POST, 'stationID', FILTER_VALIDATE_INT);
    $feedback = filter_input(INPUT_POST, 'feedback', FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $selectedTags = isset($_POST['selectedTags']) ? $_POST['selectedTags'] : array();

    if (empty($name)) {
        if ($stationID === false || $stationID <= 0) {
            $response = array("status" => "error", "message" => "Invalid station ID");
        } elseif (empty($feedback)) {
            $response = array("status" => "error", "message" => "Feedback cannot be empty");
        } else {
            $stmt = $conn->prepare("INSERT INTO BigFeedback (station_id, feedback) VALUES (?,?)");
            $stmt->bind_param("is", $stationID, $feedback);
            
            if ($stmt === false) {
                $response = array("status" => "error", "message" => "Error preparing statement");
            } else {
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $feedbackID = $stmt->insert_id;
                    if (!empty($selectedTags)) {
                        foreach ($selectedTags as $tagValue) {
                            $columnName = $tagValue;
                            $updateStmt = $conn->prepare("UPDATE BigFeedback SET `$columnName` = `$columnName` + 1 WHERE feedback_id = ?");
                            $updateStmt->bind_param("i", $feedbackID);
                            $updateStmt->execute();
                            $updateStmt->close();
                        }
                    }

                    $response = array("status" => "success", "message" => "Feedback is submitted");
                } else {
                    $response = array("status" => "error", "message" => "Error updating feedback");
                }

                $stmt->close();
            }
        }
    } else {
        if ($stationID === false || $stationID <= 0) {
            $response = array("status" => "error", "message" => "Invalid station ID");
        } elseif (empty($feedback)) {
            $response = array("status" => "error", "message" => "Feedback cannot be empty");
        } else {
            $stmt = $conn->prepare("INSERT INTO BigFeedback (station_id, feedback, fd_name) VALUES (?,?,?)");
            $stmt->bind_param("iss", $stationID, $feedback, $name);
            if ($stmt === false) {
                $response = array("status" => "error", "message" => "Error preparing statement");
            }else {
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $feedbackID = $stmt->insert_id;
                    if (!empty($selectedTags)) {
                        foreach ($selectedTags as $tagValue) {
                            $columnName = $tagValue;
                            $updateStmt = $conn->prepare("UPDATE BigFeedback SET `$columnName` = `$columnName` + 1 WHERE feedback_id = ?");
                            $updateStmt->bind_param("i", $feedbackID);
                            $updateStmt->execute();
                            $updateStmt->close();
                        }
                    }

                    $response = array("status" => "success", "message" => "Feedback is submitted");
                } else {
                    $response = array("status" => "error", "message" => "Error updating feedback");
                }
    
                $stmt->close();
            }
        }
    }
} else {
    $response = array("status" => "error", "message" => "Invalid request method");
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
