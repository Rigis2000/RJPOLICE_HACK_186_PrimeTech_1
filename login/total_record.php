<?php
// $conn = new mysqli("localhost", "id21716174_root","Hello@123","id21716174_pfs");
$conn = new mysqli("localhost", "root","","pfsnew");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Receive data from the AJAX request
$totalGoodValue = $_POST['totalGoodValue'];
$totalBadValue = $_POST['totalBadValue'];

// Insert data into the record_table
$sql = "INSERT INTO total_record (good, bad) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

// Bind parameters and execute the statement
$stmt->bind_param("ii", $totalGoodValue, $totalBadValue);

if ($stmt->execute()) {
    $response = array('status' => 'success', 'message' => 'Record updated successfully');
} else {
    $response = array('status' => 'error', 'message' => 'Error updating record: ' . $stmt->error);
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Send JSON response back to JavaScript
header('Content-Type: application/json');
echo json_encode($response);
?>
