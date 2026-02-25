<?php
require "../db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $sql = "SELECT id, name, email FROM users";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {

        $users = [];

        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        echo json_encode([
            "status" => "success",
            "data" => $users
        ]);

    } else {
        echo json_encode([
            "status" => "error",
            "message" => "No users found"
        ]);
    }
}
?>