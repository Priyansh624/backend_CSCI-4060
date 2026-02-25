<?php
require "../db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email']; 
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (empty($name) || empty($email) || empty($password)) {
        echo "All fields are required!";
        exit();
    }

    $stmt_check = $con->prepare("SELECT id FROM users WHERE email = ?");
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "Email already registered! Please try logging in.";
        exit(); 
    }
    $stmt_check->close();

    $stmt = $con->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>