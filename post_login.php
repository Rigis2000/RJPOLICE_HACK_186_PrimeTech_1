<?php
session_start();

if (!isset($_GET['session_id'])) {
    header('Location: home.php');
    exit();
}

$sessionId = $_GET['session_id'];

$connection = new mysqli("localhost", "root", "" ,"id21716174_pfs");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$query = "SELECT * FROM users WHERE session_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param('s', $sessionId);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    header('Location: login.html');
    exit();
}

$stmt->close();
$stmt = $connection->prepare("UPDATE users SET session_id = NULL WHERE session_id = ?");
$stmt->bind_param('s', $sessionId);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #FF9933;
        }
        
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        
        h1, h2 {
            color: #333;
        }
        .section {
            margin-bottom: 30px;
        }
        
        ul {
            list-style-type: none;
            padding: 0;
        }
        
        li {
            margin-bottom: 10px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            padding: 8px;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        
        button {
            padding: 10px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
        }
        
        button:hover {
            background-color: white;
            color: #4CAF50;
            border: 2px solid #4CAF50;
        }
        
        #alert-message {
            margin-bottom: 20px;
        }
    </style>
    <title>Admin Page</title>
</head>


<body>
    <div class="container">
        <div class="section">
            <h1>Admin</h1>
            <h2>Existing Stations</h2>
            <ul id="station-list">
                <?php
                $stationsQuery = "SELECT * FROM Stations";
                $stationsResult = $connection->query($stationsQuery);
                
                while ($row = $stationsResult->fetch_assoc()) {
                    echo "<li id='station-{$row['station_id']}'>
                            {$row['station_id']} - <span class='station-name'>{$row['station_name']}</span> 
                            <button onclick=\"editStation('{$row['station_id']}', '{$row['station_name']}')\">Edit</button>
                            <button onclick=\"deleteStation('{$row['station_id']}')\">Delete</button>
                        </li>";
                }
                ?>

            </ul>
        </div>

        <div class="section">
            <h2>Add/Edit Station</h2>
            <div id="alert-message"></div>
            <form id="add-station-form" onsubmit="return false;">
                <label for="station_name">Station Name:</label>
                <input type="text" id="station_name" name="station_name" required>
                <input type="hidden" id="station_id" name="station_id" value="">
                <button type="button" id="add-edit-button" onclick="addEditStation()">Add/Edit Station</button>
            </form>
        </div>
    </div>

    <script>
        function addEditStation() {
            var stationId = $("#station_id").val();
            var stationName = $("input[name='station_name']").val();
            var action = stationId ? 'edit' : 'add';

            $.ajax({
                type: "POST",
                url: "add_delete_station.php",
                data: {
                    action: action,
                    station_id: stationId,
                    station_name: stationName
                },
                success: function(response) {
                    if (action === 'add') {
                        $("#alert-message").html('<div style="color: green;">Station added successfully!</div>');
                    } else if (action === 'edit') {
                        $("#alert-message").html('<div style="color: green;">Station updated successfully!</div>');
                    }

                    $("input[name='station_name']").val('');
                    $("#station_id").val('');
                    $("#station-list").html(response);
                },
                error: function(error) {
                    $("#alert-message").html('<div style="color: red;">Error processing station. Please try again!</div>');
                }
            });
        }

        function deleteStation(stationId) {
            $.ajax({
                type: "POST",
                url: "add_delete_station.php",
                data: {
                    action: 'delete',
                    station_id: stationId
                },
                success: function(response) {
                    $("#alert-message").html('<div style="color: green;">Station deleted successfully!</div>');
                    $("#station-list").html(response);

                },
                error: function(error) {
                    $("#alert-message").html('<div style="color: red;">Error 12deleting station. Please try again!</div>');
                }
            });
        }

        function editStation(stationId, stationName) {
            $("input[name='station_name']").val(stationName);
            $("#station_id").val(stationId);
        }

        $(document).ready(function() {
        $("#station_name").keyup(function(event) {
            if (event.which === 13) {
                $("#add-edit-button").click();
            }
            });
        });

    </script>
</body>

</html>
