<?php
$connection = new mysqli("localhost", "root", "" ,"id21716174_pfs");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            $newStationName = $_POST['station_name'];

            $insertQuery = "INSERT INTO Stations (station_name) VALUES (?)";
            $stmt = $connection->prepare($insertQuery);
            $stmt->bind_param('s', $newStationName);
            $stmt->execute();

            $stmt->close();
        } elseif ($_POST['action'] === 'delete') {
            $stationId = $_POST['station_id'];

            $deleteQuery = "DELETE FROM Stations WHERE station_id = ?";
            $stmt = $connection->prepare($deleteQuery);
            $stmt->bind_param('i', $stationId);
            $stmt->execute();

            $stmt->close();
        } elseif ($_POST['action'] === 'edit') {
            $stationId = $_POST['station_id'];
            $newStationName = $_POST['station_name'];

            $updateQuery = "UPDATE Stations SET station_name = ? WHERE station_id = ?";
            $stmt = $connection->prepare($updateQuery);
            $stmt->bind_param('si', $newStationName, $stationId);
            $stmt->execute();

            $stmt->close();
        }
    }

    $stationsQuery = "SELECT * FROM Stations";
    $stationsResult = $connection->query($stationsQuery);

    while ($row = $stationsResult->fetch_assoc()) {
        echo "<li id='station-{$row['station_id']}'>
                {$row['station_id']} - <span class='station-name'>{$row['station_name']}</span> 
                <button onclick=\"editStation('{$row['station_id']}', '{$row['station_name']}')\">Edit</button>
                <button onclick=\"deleteStation('{$row['station_id']}')\">Delete</button>
              </li>";
    }

    $connection->close();
    exit();
}
?>
