<?php
// $conn = new mysqli("localhost", "id21716174_root","Hello@123","id21716174_pfs");
$conn = new mysqli("localhost", "root", "", "pfsnew");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the station_id from the AJAX request
$stationId = $_POST['station_id'];

// Prepare and execute the SQL query
$sql = "SELECT good, bad, timestamp FROM total_record";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($good, $bad, $timestamp);

// Prepare the response array
$response = array();

// Check if data was fetched successfully
while ($stmt->fetch()) {
    $rowData = array(
        'good' => $good,
        'bad' => $bad,
        'timestamp' => $timestamp
    );
    $response['data'][] = $rowData;
}

$stmt->close();

// Check if any rows were found
if (isset($response['data']) && !empty($response['data'])) {
    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
    $response['message'] = 'No data found for the given station_id.';
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$conn->close();
?>
