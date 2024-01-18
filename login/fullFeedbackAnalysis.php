<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["station_id"])) {
    $selectedStationId = $_POST["station_id"];

    $conn = new mysqli("localhost", "root", "", "pfsnew");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($selectedStationId === 'all') {
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

    $feedbackData = $result->fetch_all(MYSQLI_ASSOC);

    $columns = array_keys($feedbackData[0]);

    $values = array_values($feedbackData[0]);

    $stmt->close();
    $conn->close();

    echo json_encode(['status' => 'success', 'columns' => $columns, 'values' => $values]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
