<?php

$conn = new mysqli("localhost", "root", "", "pfsnew");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT tag_name, tag_type FROM FeedbackTags";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $tagData = $result->fetch_all(MYSQLI_ASSOC);

    $conn->close();

    echo json_encode(['status' => 'success', 'tagData' => $tagData]);
} else {

    $conn->close();

    echo json_encode(['status' => 'error', 'message' => 'No tags found']);
}
?>
