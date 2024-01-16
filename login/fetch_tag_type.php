<?php
// Include your database connection code here


// $conn = new mysqli("localhost", "id21716174_root","Hello@123","id21716174_pfs");
$conn = new mysqli("localhost", "root", "", "pfsnew");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the query
$query = "SELECT tag_name, tag_type FROM FeedbackTags";

$result = $conn->query($query);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch the results into an associative array
    $tagData = $result->fetch_all(MYSQLI_ASSOC);

    // Close the database connection
    $conn->close();

    // Send the JSON response
    echo json_encode(['status' => 'success', 'tagData' => $tagData]);
} else {
    // No results found
    // Close the database connection
    $conn->close();

    echo json_encode(['status' => 'error', 'message' => 'No tags found']);
}
?>
