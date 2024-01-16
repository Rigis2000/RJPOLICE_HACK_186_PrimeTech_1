<?php
$conn = new mysqli("localhost", "root","","pfsnew");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$selectedStationId = $_POST['station_id'];
$totalGoodValue = $_POST['totalGoodValue'];
$totalBadValue = $_POST['totalBadValue'];

$sql = "INSERT INTO record_table (station_id, good, bad) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

$stmt->bind_param("iii", $selectedStationId, $totalGoodValue, $totalBadValue);

if ($stmt->execute()) {
    $response = array('status' => 'success', 'message' => 'Record updated successfully');
} else {
    $response = array('status' => 'error', 'message' => 'Error updating record: ' . $stmt->error);
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
