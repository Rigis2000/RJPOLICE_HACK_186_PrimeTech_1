<?php
$conn = new mysqli("localhost", "root", "", "pfsnew");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stationId = $_POST['station_id'];

$sql = "SELECT good, bad, timestamp FROM record_table WHERE station_id = ? ORDER BY timestamp DESC LIMIT 4";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $stationId);
$stmt->execute();
$stmt->bind_result($good, $bad, $timestamp);

$response = array();

while ($stmt->fetch()) {
    $rowData = array(
        'good' => $good,
        'bad' => $bad,
        'timestamp' => $timestamp
    );
    $response['data'][] = $rowData;
}

$stmt->close();

if (isset($response['data']) && !empty($response['data'])) {
    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
    $response['message'] = 'No data found for the given station_id.';
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
