<?php

// $conn = new mysqli("localhost", "id21716174_root","Hello@123","id21716174_pfs");
$conn = new mysqli("localhost", "root","","pfsnew");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, session_id FROM users WHERE username=? AND password=?");
$stmt->bind_param("ss", $username, $password);

$stmt->execute();
$stmt->store_result();


if ($stmt->num_rows > 0) {
    $sessionID = bin2hex(random_bytes(8));

    $stmt->bind_result($userID, $existingSessionID);
    $stmt->fetch();

    $updateStmt = $conn->prepare("UPDATE users SET session_id=? WHERE id=?");
    $updateStmt->bind_param("si", $sessionID, $userID);
    $updateStmt->execute();

    $stmt->close();
    $updateStmt->close();
    $conn->close();

    echo "<script>
            window.location.href = 'post_login.php?session_id=$sessionID';
          </script>";
    exit();
} else {
    echo "<script>
            window.location.href = 'login.html';
            alert('Login failed. Invalid username or password.')
            </script>";
    exit();
}

$stmt->close();
$updateStmt->close();
$conn->close();
?>
