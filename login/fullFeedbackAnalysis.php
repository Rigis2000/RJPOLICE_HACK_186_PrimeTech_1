<?php
// Include your database connection code here

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["station_id"])) {
    // Get the selected station ID from the POST data
    $selectedStationId = $_POST["station_id"];

    // $conn = new mysqli("localhost", "id21716174_root","Hello@123","id21716174_pfs");
    $conn = new mysqli("localhost", "root", "", "pfsnew");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the query
    if ($selectedStationId === 'all') {
        // Query when "all" is selected
        $query = "SELECT
                    SUM(Professionalism) AS Professionalism,
                    SUM(EfficientResponse) AS EfficientResponse,
                    SUM(CommunityEngagement) AS CommunityEngagement,
                    SUM(ClearCommunication) AS ClearCommunication,
                    SUM(PositiveInteractions) AS PositiveInteractions,
                    SUM(EffectiveTraining) AS EffectiveTraining,
                    SUM(AccessToServices) AS AccessToServices,
                    SUM(CrimePrevention) AS CrimePrevention,
                    SUM(CollaborationSuccess) AS CollaborationSuccess,
                    SUM(TransparentFeedback) AS TransparentFeedback,
                    SUM(DelayedResponse) AS DelayedResponse,
                    SUM(PoorCommunication) AS PoorCommunication,
                    SUM(UnprofessionalBehavior) AS UnprofessionalBehavior,
                    SUM(InaccessibleServices) AS InaccessibleServices,
                    SUM(LackOfCommunityEngagement) AS LackOfCommunityEngagement,
                    SUM(TrainingNeedsImprovement) AS TrainingNeedsImprovement,
                    SUM(FeedbackNeglect) AS FeedbackNeglect,
                    SUM(ResourceShortage) AS ResourceShortage,
                    SUM(TechnologyIssues) AS TechnologyIssues,
                    SUM(CollaborationChallenges) AS CollaborationChallenges
                FROM
                    BigFeedback";
    } else {
        // Query when a specific station is selected
        $query = "SELECT
                    station_id,
                    SUM(Professionalism) AS Professionalism,
                    SUM(EfficientResponse) AS EfficientResponse,
                    SUM(CommunityEngagement) AS CommunityEngagement,
                    SUM(ClearCommunication) AS ClearCommunication,
                    SUM(PositiveInteractions) AS PositiveInteractions,
                    SUM(EffectiveTraining) AS EffectiveTraining,
                    SUM(AccessToServices) AS AccessToServices,
                    SUM(CrimePrevention) AS CrimePrevention,
                    SUM(CollaborationSuccess) AS CollaborationSuccess,
                    SUM(TransparentFeedback) AS TransparentFeedback,
                    SUM(DelayedResponse) AS DelayedResponse,
                    SUM(PoorCommunication) AS PoorCommunication,
                    SUM(UnprofessionalBehavior) AS UnprofessionalBehavior,
                    SUM(InaccessibleServices) AS InaccessibleServices,
                    SUM(LackOfCommunityEngagement) AS LackOfCommunityEngagement,
                    SUM(TrainingNeedsImprovement) AS TrainingNeedsImprovement,
                    SUM(FeedbackNeglect) AS FeedbackNeglect,
                    SUM(ResourceShortage) AS ResourceShortage,
                    SUM(TechnologyIssues) AS TechnologyIssues,
                    SUM(CollaborationChallenges) AS CollaborationChallenges
                FROM
                    BigFeedback
                WHERE
                    station_id = ?
                GROUP BY
                    station_id";
    }

    $stmt = $conn->prepare($query);

    if ($selectedStationId !== 'all') {
        $stmt->bind_param("i", $selectedStationId);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the results into an associative array
    $feedbackData = $result->fetch_all(MYSQLI_ASSOC);

    // Get column names
    $columns = array_keys($feedbackData[0]);

    // Get values
    $values = array_values($feedbackData[0]);

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();

    // Send the JSON response with columns and values
    echo json_encode(['status' => 'success', 'columns' => $columns, 'values' => $values]);
} else {
    // Invalid request, send an error response
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
