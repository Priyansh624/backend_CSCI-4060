<?php
require "../db_connection.php";

if (!isset($_GET['name']) || empty($_GET['name'])) {
    echo json_encode([
        "status" => "error",
        "message" => "User name is required"
    ]);
    exit();
}

$name = $_GET['name'];

$stmt = $con->prepare("DELETE FROM users WHERE name = ?");
$stmt->bind_param("s", $name);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "status" => "success",
            "message" => $stmt->affected_rows . " user(s) deleted successfully"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "User not found"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => $stmt->error
    ]);
}

$stmt->close();
?>