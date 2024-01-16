<?php

$conn = new mysqli("localhost", "root", "", "pfsnew");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT tag_id, tag_name FROM FeedbackTags";
$result = $conn->query($query);

if ($result) {
    $tags = array();
    while ($row = $result->fetch_assoc()) {
        $tags[] = array("tag_id" => $row["tag_id"], "tag_name" => $row["tag_name"]);
    }

    $response = array("status" => "success", "tags" => $tags);
} else {
    $response = array("status" => "error", "message" => "Error fetching tags");
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
