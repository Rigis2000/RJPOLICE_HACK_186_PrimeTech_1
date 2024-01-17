<?php
session_start();

if (!isset($_GET['session_id'])) {
    header('Location: home.php');
    exit();
}

$sessionId = $_GET['session_id'];

$conn = new mysqli("localhost", "root","","pfsnew");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM users WHERE session_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $sessionId);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    header('Location: login.html');
    exit();
}

$stmt->close();
$stmt = $conn->prepare("UPDATE users SET session_id = NULL WHERE session_id = ?");
$stmt->bind_param('s', $sessionId);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="post_login.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
        <script src="https://cdn.skypack.dev/date-fns@2.25.0/dist/index.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <title>Admin Page</title>
</head>


<body>
    <div id="navigation">
        <div class="title">
            <h1>Admin</h1>
        </div>
        <div id="buttons-container">
            <a href="../index.php" class="nav-link">Home</a>
            <a href="../login/login.html" class="nav-link">Logout</a>
            <a href="../Help/help.html" class="nav-link">Help</a>
        </div>
    </div>
    <div class="MAIN-DIV">
        <div id="add-delete">
            <div class="container">
                <h1 style="text-align:center;">Add, Edit or Delete Stations</h1>
                <div class="section">
                    <h2 >Existing Stations</h2>
                    <ul id="station-list" class="ul-foredit">
                        <?php
                        $stationsQuery = "SELECT * FROM Stations";
                        $stationsResult = $conn->query($stationsQuery);
                        
                        while ($row = $stationsResult->fetch_assoc()) {
                            echo "<li id='station-{$row['station_id']}' class=\"li-foredit\">
                                    <section id='station_section'>
                                    {$row['station_id']} - <span class='station-name'>{$row['station_name']}</span><br><br>
                                    <button class=\"edit-button\" onclick=\"editStation('{$row['station_id']}', '{$row['station_name']}')\">
                                    <svg class=\"edit-svgIcon\" viewBox=\"0 0 512 512\">
                                        <path d=\"M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z\"></path>
                                    </svg>
                                    </button>
                                    <button class=\"delete-button\" onclick=\"deleteStation('{$row['station_id']}')\">
                                        <svg class=\"delete-svgIcon\" viewBox=\"0 0 448 512\">
                                            <path d=\"M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z\"></path>
                                        </svg>
                                    </button>
                                    </section>
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
                            <button class="buttons" type="button" id="add-edit-button" onclick="addEditStation()">Add/Edit Station</button>
                        </form>
                    </div>
                </div>
            </div>      
        </div>
        <div class="full_loc">
            <section class="full_analysis">
                <h1>Full Feedback Analysis</h1>
                <div class="dropdown">
                    <label for="station-full">Select Police Station:</label><br>
                    <select id="station-full" name="station"></select>
                    <button class="update_button">Update Record</button>
                </div><br>
                <div class="fullfeedbacks">
                    <section id="feedback-section" class="classFFeedback">
                        <!-- Feedback content will be dynamically added here -->
                    </section>
                </div>
                <div id="result-analysis">
    
                </div>
                <br>
                <canvas id="lineChart" width="400" height="200"></canvas>
            </section>
        </div>
        <div id="loc">
            <section class="one_analysis">
                <h1 style="text-align:center;">Bulk SMS Analysis</h1>
                <div class="dropdown">
                    <label for="station">Select Police Station:</label><br>
                    <select id="station" name="station">
                    </select>
                </div><br>
                <div class="avg-total">
                    <button class="add_delete_btn" id="avgButton">avg</button>
                    <button class="add_delete_btn" id="totalButton">total</button>
                </div>
                <div id="feedback">
                    <p>Feedback for selected station:</p>
                    <p><span id="good"></span></p>
                    <p><span id="neutral"></span></p>
                    <p><span id="bad"></span></p>
                </div>
                <canvas id="pieChart" width="400" height="400"></canvas>
                <p id="feedback-message"></p>
            </section>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#avgButton").click(function () {
                sendData("avg");
            });

            $("#totalButton").click(function () {
                sendData("total");
            });

            function sendData(action) {
                $.ajax({
                    type: "POST",
                    url: "avg_total.php", 
                    data: { action: action },
                    dataType: "json", 
                    success: function (response) {
                        console.log(response);
                        updateFeedbackContent(response, action);

                        updatePieChart(response);
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            }

            function updateFeedbackContent(response, action) {
                $("#good, #neutral, #bad").text('');
                $("#good").text(action === "avg" ? "Average Good: " + response.average_good : "Total Good: " + response.total_good);
                $("#neutral").text(action === "avg" ? "Average Neutral: " + response.average_neutral : "Total Neutral: " + response.total_neutral);
                $("#bad").text(action === "avg" ? "Average Bad: " + response.average_bad : "Total Bad: " + response.total_bad);
            }
            function updatePieChart(response) {
                var ctx = document.getElementById('pieChart').getContext('2d');
                var dataArray;

                if (response.hasOwnProperty('average_good')) {
                    dataArray = [
                        response.average_good,
                        response.average_neutral,
                        response.average_bad
                    ];
                } else {
                    dataArray = [
                        response.total_good,
                        response.total_neutral,
                        response.total_bad
                    ];
                }

                if (window.myPieChart) {
                    window.myPieChart.data.datasets[0].data = dataArray;
                    window.myPieChart.update();
                } else {
                    window.myPieChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['Good', 'Neutral', 'Bad'],
                            datasets: [{
                                data: dataArray,
                                backgroundColor: ['#BC5090', '#58508D', '#003F5C'],
                                hoverBackgroundColor: ['#BC5090', '#58508D', '#003F5C']
                            }]
                        }
                    });
                }

                var highestValueIndex = dataArray.indexOf(Math.max(...dataArray));

                var feedbackMessage = '';
                switch (highestValueIndex) {
                    case 0:
                        feedbackMessage = 'Feedback is Good';
                        break;
                    case 1:
                        feedbackMessage = 'Feedback is Neutral';
                        break;
                    case 2:
                        feedbackMessage = 'Feedback is Bad';
                        break;
                    default:
                        feedbackMessage = 'No feedback';
                        break;
                }

                $('#feedback-message').text(feedbackMessage);
            }

        });

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
            var confirmation = confirm("Are you sure you want to delete this station?");

            if (confirmation) {
                $.ajax({
                    type: "POST",
                    url: "add_delete_station.php",
                    data: {
                        action: 'delete',
                        station_id: stationId
                    },
                    success: function (response) {
                        $("#alert-message").html('<div style="color: green;">Station deleted successfully!</div>');
                        $("#station-list").html(response);
                    },
                    error: function (error) {
                        $("#alert-message").html('<div style="color: red;">Error deleting station. Please try again!</div>');
                    }
                });
            } else {
                $("#alert-message").html('<div style="color: blue;">Deletion canceled by user.</div>');
            }
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

        function toggleHiddenItems() {
            var hiddenItems = document.querySelector('.hidden_items');
            hiddenItems.style.visibility = (hiddenItems.style.visibility === 'visible') ? 'hidden' : 'visible';
        }
        function toggleButtons(section) {
            var buttons = section.querySelectorAll('.buttons');
            buttons.forEach(function (button) {
                button.style.display = (button.style.display === 'block') ? 'none' : 'block';
            });

            section.classList.toggle('active');
        }

        $(document).ready(function () {
            $.ajax({
                type: 'GET',
                url: 'stations.php',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        $('#station').append('<option value=""><--Select a station--></option>');
                        $.each(response.stations, function (key, value) {
                            $('#station').append('<option value="' + value.station_id + '">' + value.name + '</option>');
                        });

                        $('#station').change(function () {
                            var selectedStationId = $(this).val();
                            if (selectedStationId !== '') {
                                $.ajax({
                                    type: 'POST',
                                    url: 'fetch_data.php',
                                    dataType: 'json',
                                    data: { station_id: selectedStationId },
                                    success: function (feedbackResponse) {
                                        var feedbackDataArray = [];

                                        if (feedbackResponse.status === 'success') {
                                            feedbackDataArray = [
                                                feedbackResponse.feedback.good,
                                                feedbackResponse.feedback.neutral,
                                                feedbackResponse.feedback.bad
                                            ];

                                            $('#good').html('Good: ' + feedbackDataArray[0]);
                                            $('#neutral').html('Neutral: ' + feedbackDataArray[1]);
                                            $('#bad').html('Bad: ' + feedbackDataArray[2]);

                                            updatePieChart(feedbackDataArray);      
                                        } else {
                                            alert('Error: ' + feedbackResponse.message);
                                        }

                                        console.log(feedbackDataArray);
                                    },
                                    error: function (xhr, status, error) {
                                        alert('Feedback Fetching Error');
                                        console.error(error);
                                    }
                                });
                            }
                        });
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    alert('Station Fetching Error');
                    console.error(error);
                }
            });
            function updatePieChart(dataArray) {
                var ctx = document.getElementById('pieChart').getContext('2d');
                if (window.myPieChart) {
                    window.myPieChart.data.datasets[0].data = dataArray;
                    window.myPieChart.update();
                } else {
                    window.myPieChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['Good', 'Neutral', 'Bad'],
                            datasets: [{
                                data: dataArray,
                                backgroundColor: ['#BC5090', '#58508D', '#003F5C'],
                                hoverBackgroundColor: ['#BC5090', '#58508D', '#003F5C']
                            }]
                        }
                    });
                }

                var highestValueIndex = dataArray.indexOf(Math.max(...dataArray));

                var feedbackMessage = '';
                switch (highestValueIndex) {
                    case 0:
                        feedbackMessage = 'Feedback is Good';
                        break;
                    case 1:
                        feedbackMessage = 'Feedback is Neutral';
                        break;
                    case 2:
                        feedbackMessage = 'Feedback is Bad';
                        break;
                    default: feedbackMessage = 'No feedback';break;
                }

                $('#feedback-message').text(feedbackMessage);
            }
        });
        
        $(document).ready(function () {
            $.ajax({
                type: 'GET',
                url: 'stations.php',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        $('#station-full').append('<option value=""><--Select a station--></option>');
                        $('#station-full').append('<option value="all">All</option>');
                        $.each(response.stations, function (key, value) {
                            $('#station-full').append('<option value="' + value.station_id + '">' + value.name + '</option>');
                        });

                        $('#station-full').change(function () {
                            var selectedStationId = $(this).val();

                            $.ajax({
                                type: 'POST',
                                url: 'fetch_fullfeedback.php',
                                dataType: 'json',
                                data: { station_id: selectedStationId },
                                success: function (feedbackResponse) {
                                    updateFeedbackContent(feedbackResponse);
                                    fullFeedbackAnalysis(selectedStationId);
                                    createLineChart(selectedStationId)
                                },
                                error: function (xhr, status, error) {
                                    alert('Error fetching full feedback');
                                    console.error(error);
                                }
                            });
                        });
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    alert('Station Fetching Error');
                    console.error(error);
                }
            });

            function updateFeedbackContent(feedbackResponse) {
                $('.full_analysis section').empty();
                if (feedbackResponse.status === 'success' && feedbackResponse.feedbackData.length > 0) {
                    $.each(feedbackResponse.feedbackData, function (index, feedback) {
                        var feedbackHtml = '<p><b>' + feedback.fd_name + '</b></p>' +
                            '<p><b>Date and Time:</b> ' + feedback.feedback_datetime + '</p>' +
                            '<p><b>Station Name:</b> ' + feedback.station_name + '</p>'+
                            '<p><b>Feedback:</b> ' + feedback.feedback + '</p>' ;

                        $('.full_analysis section').append('<div class="feedback-entry">' + feedbackHtml + '</div>');
                    });
                } else {
                    $('.full_analysis section').html('<p>No feedback data available for the selected station.</p>');
                }
            }

            var tagTypes;

            $.ajax({
                type: 'GET',
                url: 'fetch_tag_type.php',
                dataType: 'json',
                success: function (tagResponse) {
                    if (tagResponse.status === 'success' && tagResponse.tagData.length > 0) {
                        tagTypes = {};
                        $.each(tagResponse.tagData, function (index, tag) {
                            tagTypes[tag.tag_name] = tag.tag_type;
                        });
                    } else {
                        console.log('No tag data available');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching tag data');
                }
            });

            function fullFeedbackAnalysis(selectedStationId) {

                $.ajax({
                    type: 'POST',
                    url: 'fullFeedbackAnalysis.php',
                    dataType: 'json',
                    data: { station_id: selectedStationId },
                    success: function (analysisResponse) {
                        var analysisData = [];
                        var goodTags = [];
                        var badTags = [];
                        var totalGoodValue = 0;
                        var totalBadValue = 0;
                        if (
                            analysisResponse.status === 'success' &&
                            analysisResponse.columns.length > 0 &&
                            analysisResponse.values.length > 0
                        ) {
                            for (var i = 0; i < analysisResponse.columns.length; i++) {
                                var columnName = analysisResponse.columns[i];
                                var columnValue = analysisResponse.values[i];
                                if (columnName !== 'station_id') {
                                    var columnData = { name: columnName, value: columnValue };
                                    analysisData.push(columnData);
                                    var tagType = getTagType(columnName);

                                    if (tagType === 'good') {
                                        goodTags.push({ name: columnName, value: columnValue });
                                        totalGoodValue += parseInt(columnValue);
                                    } else if (tagType === 'bad') {
                                        badTags.push({ name: columnName, value: columnValue });
                                        totalBadValue += parseInt(columnValue);
                                    }
                                }
                            }
                            analysisData.sort(function (a, b) {
                                return b.value - a.value;
                            });

                            analysisData = analysisData.filter(function (item) {
                                return parseInt(item.value) !== 0;
                            });

                            console.log(analysisData);
                            displayAnalysisResult(analysisData);

                            console.log('Good Tags:', goodTags);
                            console.log('Bad Tags:', badTags);
                            console.log('Total Good Value:', totalGoodValue);
                            console.log('Total Bad Value:', totalBadValue);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('Error in fullFeedbackAnalysis');
                        console.error(error);
                    }
                });
            }

            // Define a variable to store the reference to the chart
            var lineChart;

            function createLineChart(selectedStationId) {
                // Destroy the previous chart if it exists
                if (lineChart) {
                    lineChart.destroy();
                }
                if (selectedStationId === 'all') {
                    $.ajax({
                        type: 'POST',
                        url: 'Fetch_all_for_line.php',
                        dataType: 'json',
                        data: { station_id: selectedStationId },
                        success: function (dataResponse) {
                            if (dataResponse.status === 'success') {
                                if (dataResponse.data && dataResponse.data.length > 0) {
                                    var timestamps = dataResponse.data.map(function (row) {
                                        return new Date(row.timestamp);
                                    });

                                    var goodValues = dataResponse.data.map(function (row) {
                                        return row.good;
                                    });

                                    var badValues = dataResponse.data.map(function (row) {
                                        return row.bad;
                                    });


                                    var ctx = document.getElementById('lineChart').getContext('2d');

                                    lineChart = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: timestamps, 
                                            datasets: [
                                                {
                                                    label: 'Good Values',
                                                    data: goodValues,
                                                    borderColor: 'green',
                                                    fill: false
                                                },
                                                {
                                                    label: 'Bad Values',
                                                    data: badValues,
                                                    borderColor: 'red',
                                                    fill: false
                                                }
                                            ]
                                        },
                                        options: {
                                            scales: {
                                                x: {
                                                    type: 'time',
                                                    time: {
                                                        unit: 'hour', 
                                                        tooltipFormat: 'h:mm a', 
                                                    }
                                                },
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                                } else {
                                    console.log('No data found for the given station_id.');
                                }
                            } else {
                                console.error('Error:', dataResponse.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            alert('Error in createLineChart');
                            console.error(error);
                        }
                    });
                }else{
                    $.ajax({
                        type: 'POST',
                        url: 'Fetch_for_line_Chart.php',
                        dataType: 'json',
                        data: { station_id: selectedStationId },
                        success: function (dataResponse) {
                            if (dataResponse.status === 'success') {
                                if (dataResponse.data && dataResponse.data.length > 0) {
                                    var timestamps = dataResponse.data.map(function (row) {
                                        return new Date(row.timestamp);
                                    });

                                    var goodValues = dataResponse.data.map(function (row) {
                                        return row.good;
                                    });

                                    var badValues = dataResponse.data.map(function (row) {
                                        return row.bad;
                                    });

                                    var ctx = document.getElementById('lineChart').getContext('2d');

                                    lineChart = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: timestamps,
                                            datasets: [
                                                {
                                                    label: 'Good Values',
                                                    data: goodValues,
                                                    borderColor: 'green',
                                                    fill: false
                                                },
                                                {
                                                    label: 'Bad Values',
                                                    data: badValues,
                                                    borderColor: 'red',
                                                    fill: false
                                                }
                                            ]
                                        },
                                        options: {
                                            scales: {
                                                x: {
                                                    type: 'time',
                                                    time: {
                                                        unit: 'hour',
                                                        tooltipFormat: 'h:mm a',
                                                    }
                                                },
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                                } else {
                                    console.log('No data found for the given station_id.');
                                }
                            } else {
                                console.error('Error:', dataResponse.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            alert('Error in createLineChart');
                            console.error(error);
                        }
                    });
                }
            }






            function getTagType(tagName) {
                return tagTypes[tagName] || null;
            }

            function displayAnalysisResult(analysisData) {
                $('#result-analysis').empty();

                if (analysisData.length > 0) {
                    var resultList = $('<ul id=\'analysis-result-list\'>');
                    $.each(analysisData, function (index, item) {
                        var tagName = getTagName(item.name);
                        var selectedCount = parseInt(item.value);
                               
                        var listItem = $('<li>').text(selectedCount + ' people selected ' + tagName + ' tag');
                        resultList.append(listItem);
                    });

                    $('#result-analysis').append(resultList);
                } else {
                    $('#result-analysis').text('No data available');
                }
            }

            function getTagName(columnName) {
                var tagNames = {
                    'Professionalism': 'Professionalism',
                    'EfficientResponse': 'Efficient Response',
                    'CommunityEngagement': 'Community Engagement',
                    'ClearCommunication': 'Clear Communication',
                    'PositiveInteractions': 'Positive Interactions',
                    'EffectiveTraining': 'Effective Training',
                    'AccessToServices': 'Access To Services',
                    'CrimePrevention': 'Crime Prevention',
                    'CollaborationSuccess': 'Collaboration Success',
                    'TransparentFeedback': 'Transparent Feedback',
                    'DelayedResponse': 'Delayed Response',
                    'PoorCommunication': 'Poor Communication',
                    'UnprofessionalBehavior': 'Unprofessional Behavior',
                    'InaccessibleServices': 'Inaccessible Services',
                    'LackOfCommunityEngagement': 'Lack Of Community Engagement',
                    'TrainingNeedsImprovement': 'Training Needs Improvement',
                    'FeedbackNeglect': 'Feedback Neglect',
                    'ResourceShortage': 'Resource Shortage',
                    'TechnologyIssues': 'Technology Issues',
                    'CollaborationChallenges': 'Collaboration Challenges'
                };
                return tagNames[columnName] || columnName;
            }
        });

        var tagTypes;

        $.ajax({
            type: 'GET',
            url: 'fetch_tag_type.php',
            dataType: 'json',
            success: function (tagResponse) {
                if (tagResponse.status === 'success' && tagResponse.tagData.length > 0) {
                    tagTypes = {};
                    $.each(tagResponse.tagData, function (index, tag) {
                        tagTypes[tag.tag_name] = tag.tag_type;
                    });
                } else {
                    console.log('No tag data available');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching tag data');
            }
        });

        function getTagType(tagName) {
            return tagTypes[tagName] || null;
        }

        $(document).ready(function () {
            $('.update_button').on('click', function () {
                updateRecord();
            });

            function updateRecord() {
                var totalSumGood = 0;
                var totalSumBad = 0;
                var processedStations = 0;

                $.ajax({
                    type: 'GET',
                    url: 'stations.php',
                    dataType: 'json',
                    success: function (stationResponse) {
                        if (stationResponse.status === 'success' && stationResponse.stations.length > 0) {
                            var totalStations = stationResponse.stations.length;

                            $.each(stationResponse.stations, function (index, station) {
                                var selectedStationId = station.station_id;
                                $.ajax({
                                    type: 'POST',
                                    url: 'fullFeedbackAnalysis.php',
                                    dataType: 'json',
                                    data: { station_id: selectedStationId },
                                    success: function (analysisResponse) {
                                        var analysisData = [];
                                        var goodTags = [];
                                        var badTags = [];
                                        var totalGoodValue = 0;
                                        var totalBadValue = 0;

                                        if (
                                            analysisResponse.status === 'success' &&
                                            analysisResponse.columns.length > 0 &&
                                            analysisResponse.values.length > 0
                                        ) {
                                            for (var i = 0; i < analysisResponse.columns.length; i++) {
                                                var columnName = analysisResponse.columns[i];
                                                var columnValue = analysisResponse.values[i];
                                                if (columnName !== 'station_id') {
                                                    var columnData = { name: columnName, value: columnValue };
                                                    analysisData.push(columnData);
                                                    var tagType = getTagType(columnName);

                                                    if (tagType === 'good') {
                                                        goodTags.push({ name: columnName, value: columnValue });
                                                        totalGoodValue += parseInt(columnValue);
                                                    } else if (tagType === 'bad') {
                                                        badTags.push({ name: columnName, value: columnValue });
                                                        totalBadValue += parseInt(columnValue);
                                                    }
                                                }
                                            }
                                            analysisData.sort(function (a, b) {
                                                return b.value - a.value;
                                            });

                                            analysisData = analysisData.filter(function (item) {
                                                return parseInt(item.value) !== 0;
                                            });

                                            totalSumGood += totalGoodValue;
                                            totalSumBad += totalBadValue;
                                            $.ajax({
                                                type: 'POST',
                                                url: 'updateRecord.php',
                                                dataType: 'json',
                                                data: {
                                                    station_id: selectedStationId,
                                                    totalGoodValue: totalGoodValue,
                                                    totalBadValue: totalBadValue
                                                },
                                                success: function (updateResponse) {
                                                    console.log(updateResponse);
                                                    processedStations++;
                                                    if (processedStations === totalStations) {
                                                        sendTotalSum();
                                                        alert("Data has been updated!");
                                                    }
                                                },
                                                error: function (xhr, status, error) {
                                                    alert('Error updating record');
                                                    console.error(error);
                                                }
                                            });
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        alert('Error in fullFeedbackAnalysis');
                                        console.error(error);
                                    }
                                });
                            });
                        } else {
                            console.log('No station data available');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching station data');
                    }
                });

                function sendTotalSum() {
                    $.ajax({
                        type: 'POST',
                        url: 'total_Record.php',
                        dataType: 'json',
                        data: {
                            totalGoodValue: totalSumGood,
                            totalBadValue: totalSumBad
                        },
                        success: function (updateResponse) {
                            console.log(updateResponse);
                        },
                        error: function (xhr, status, error) {
                            alert('Error updating total sum record');
                            console.error(error);
                        }
                    });
                }
            }
        });
    </script>
</body>

</html>
