<?php

$conn = new mysqli("localhost", "root", "", "pfsnew");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array();

if (isset($_POST['selectedTag'])) {
    $selectedTag = $conn->real_escape_string($_POST['selectedTag']);
    
    // Check if the selected tag is "Professionalism" or "UnprofessionalBehavior"
    if ($selectedTag === 'Professionalism') {
        $query = "SELECT tag_id, tag_name FROM FeedbackTags WHERE tag_name = 'Professionalism' OR tag_name = 'UnprofessionalBehavior'";
        $result = $conn->query($query);

        if ($result) {
            $tags = array();
            while ($row = $result->fetch_assoc()) {
                $tags[] = array("tag_id" => $row["tag_id"], "tag_name" => $row["tag_name"]);
            }

            $response = array("status" => "success", "tags" => $tags);
        } else {
            $response = array("status" => "error", "message" => "Error fetching tags");
        }
    } else if ($selectedTag === 'CommunityEngagement'){
        $query = "SELECT tag_id, tag_name FROM FeedbackTags WHERE tag_name = 'CommunityEngagement' OR tag_name = 'LackOfCommunityEngagement'";
        $result = $conn->query($query);

        if ($result) {
            $tags = array();
            while ($row = $result->fetch_assoc()) {
                $tags[] = array("tag_id" => $row["tag_id"], "tag_name" => $row["tag_name"]);
            }

            $response = array("status" => "success", "tags" => $tags);
        } else {
            $response = array("status" => "error", "message" => "Error fetching tags");
        }
    } else if ($selectedTag === 'Communication'){
        $query = "SELECT tag_id, tag_name FROM FeedbackTags WHERE tag_name = 'ClearCommunication' OR tag_name = 'PoorCommunication'";
        $result = $conn->query($query);

        if ($result) {
            $tags = array();
            while ($row = $result->fetch_assoc()) {
                $tags[] = array("tag_id" => $row["tag_id"], "tag_name" => $row["tag_name"]);
            }

            $response = array("status" => "success", "tags" => $tags);
        } else {
            $response = array("status" => "error", "message" => "Error fetching tags");
        }
    } else if ($selectedTag === 'Response'){
        $query = "SELECT tag_id, tag_name FROM FeedbackTags WHERE tag_name = 'DelayedResponse' OR tag_name = 'EfficientResponse'";
        $result = $conn->query($query);

        if ($result) {
            $tags = array();
            while ($row = $result->fetch_assoc()) {
                $tags[] = array("tag_id" => $row["tag_id"], "tag_name" => $row["tag_name"]);
            }

            $response = array("status" => "success", "tags" => $tags);
        } else {
            $response = array("status" => "error", "message" => "Error fetching tags");
        }
    } else if ($selectedTag === 'FeedbackQuality'){
        $query = "SELECT tag_id, tag_name FROM FeedbackTags WHERE tag_name = 'TransparentFeedback' OR tag_name = 'FeedbackNeglect'";
        $result = $conn->query($query);

        if ($result) {
            $tags = array();
            while ($row = $result->fetch_assoc()) {
                $tags[] = array("tag_id" => $row["tag_id"], "tag_name" => $row["tag_name"]);
            }

            $response = array("status" => "success", "tags" => $tags);
        } else {
            $response = array("status" => "error", "message" => "Error fetching tags");
        }
    } else if ($selectedTag === 'Collaboration'){
        $query = "SELECT tag_id, tag_name FROM FeedbackTags WHERE tag_name = 'CollaborationSuccess' OR tag_name = 'CollaborationChallenges'";
        $result = $conn->query($query);

        if ($result) {
            $tags = array();
            while ($row = $result->fetch_assoc()) {
                $tags[] = array("tag_id" => $row["tag_id"], "tag_name" => $row["tag_name"]);
            }

            $response = array("status" => "success", "tags" => $tags);
        } else {
            $response = array("status" => "error", "message" => "Error fetching tags");
        }
    } else if ($selectedTag === 'Services'){
        $query = "SELECT tag_id, tag_name FROM FeedbackTags WHERE tag_name = 'AccessToServices' OR tag_name = 'InaccessibleServices'";
        $result = $conn->query($query);

        if ($result) {
            $tags = array();
            while ($row = $result->fetch_assoc()) {
                $tags[] = array("tag_id" => $row["tag_id"], "tag_name" => $row["tag_name"]);
            }

            $response = array("status" => "success", "tags" => $tags);
        } else {
            $response = array("status" => "error", "message" => "Error fetching tags");
        }
    } else if ($selectedTag === 'CrimePrevention'){
        $query = "SELECT tag_id, tag_name FROM FeedbackTags WHERE tag_name = 'CrimePrevention'";
        $result = $conn->query($query);

        if ($result) {
            $tags = array();
            while ($row = $result->fetch_assoc()) {
                $tags[] = array("tag_id" => $row["tag_id"], "tag_name" => $row["tag_name"]);
            }

            $response = array("status" => "success", "tags" => $tags);
        } else {
            $response = array("status" => "error", "message" => "Error fetching tags");
        }
    } else if ($selectedTag === 'Training'){
        $query = "SELECT tag_id, tag_name FROM FeedbackTags WHERE tag_name = 'EffectiveTraining' OR tag_name = 'TrainingNeedsImprovement'";
        $result = $conn->query($query);

        if ($result) {
            $tags = array();
            while ($row = $result->fetch_assoc()) {
                $tags[] = array("tag_id" => $row["tag_id"], "tag_name" => $row["tag_name"]);
            }

            $response = array("status" => "success", "tags" => $tags);
        } else {
            $response = array("status" => "error", "message" => "Error fetching tags");
        }
    } else if ($selectedTag === 'Training'){
        $query = "SELECT tag_id, tag_name FROM FeedbackTags WHERE tag_name = 'EffectiveTraining' OR tag_name = 'TrainingNeedsImprovement'";
        $result = $conn->query($query);

        if ($result) {
            $tags = array();
            while ($row = $result->fetch_assoc()) {
                $tags[] = array("tag_id" => $row["tag_id"], "tag_name" => $row["tag_name"]);
            }

            $response = array("status" => "success", "tags" => $tags);
        } else {
            $response = array("status" => "error", "message" => "Error fetching tags");
        }
    } else if ($selectedTag === 'Interactions'){
        $query = "SELECT tag_id, tag_name FROM FeedbackTags WHERE tag_name = 'PositiveInteractions' OR tag_name = 'NegativeInteractions'";
        $result = $conn->query($query);

        if ($result) {
            $tags = array();
            while ($row = $result->fetch_assoc()) {
                $tags[] = array("tag_id" => $row["tag_id"], "tag_name" => $row["tag_name"]);
            }

            $response = array("status" => "success", "tags" => $tags);
        } else {
            $response = array("status" => "error", "message" => "Error fetching tags");
        }
    } else if ($selectedTag === 'Resources'){
        $query = "SELECT tag_id, tag_name FROM FeedbackTags WHERE tag_name = 'SufficientResources' OR tag_name = 'ResourceShortage'";
        $result = $conn->query($query);

        if ($result) {
            $tags = array();
            while ($row = $result->fetch_assoc()) {
                $tags[] = array("tag_id" => $row["tag_id"], "tag_name" => $row["tag_name"]);
            }

            $response = array("status" => "success", "tags" => $tags);
        } else {
            $response = array("status" => "error", "message" => "Error fetching tags");
        }
    } else if ($selectedTag === 'Technology'){
        $query = "SELECT tag_id, tag_name FROM FeedbackTags WHERE tag_name = 'GoodTechnology' OR tag_name = 'TechnologyIssues'";
        $result = $conn->query($query);

        if ($result) {
            $tags = array();
            while ($row = $result->fetch_assoc()) {
                $tags[] = array("tag_id" => $row["tag_id"], "tag_name" => $row["tag_name"]);
            }

            $response = array("status" => "success", "tags" => $tags);
        } else {
            $response = array("status" => "error", "message" => "Error fetching tags");
        }
    } else {
        $response = array("status" => "error", "message" => "No selected tag provided");
    }
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
