<?php
require "../db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST['id']) || empty($_POST['id'])) {
        echo json_encode([
            "status" => "error",
            "message" => "User ID is required"
        ]);
        exit();
    }

    $id = $_POST['id'];
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;

    if (empty($name) && empty($email)) {
        echo json_encode([
            "status" => "error",
            "message" => "Provide name or email to update"
        ]);
        exit();
    }

    $stmt_check = $con->prepare("SELECT id FROM users WHERE id = ?");
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows == 0) {
        echo json_encode([
            "status" => "error",
            "message" => "User not found"
        ]);
        exit();
    }
    $stmt_check->close();

    if (!empty($name) && !empty($email)) {
        $stmt = $con->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $email, $id);
    } elseif (!empty($name)) {
        $stmt = $con->prepare("UPDATE users SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);
    } else {
        $stmt = $con->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->bind_param("si", $email, $id);
    }

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "User updated successfully"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => $stmt->error
        ]);
    }

    $stmt->close();
}
?>