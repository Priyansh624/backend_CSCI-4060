<?php
require "db_connection.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = ($_POST['name']);
    $email = ($_POST['email']);
    $password = md5($_POST['password']); 

    $stmt_check = $con->prepare("SELECT id FROM users WHERE email = ?");
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "<script>
                alert('Email already registered! Try logging in.');
                document.location = 'login.php';
              </script>";
        exit();
    }
    $stmt_check->close();

    $stmt = $con->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        echo "<script>
                alert('New user added successfully! Please Log In.');
                document.location = 'login.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>CSCI 4060</title>
    <link rel="stylesheet" href="custom_style.css">
</head>

<body>
    <div id="content_div">
        <h1>Insert New User</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="name" placeholder="Enter your name" required><br><br>
            <input type="email" name="email" placeholder="Enter your email" required><br><br>
            <input type="password" name="password" placeholder="Enter preferred password" required><br><br>



            <input type="submit" id="submit_btn" name="register_in_btn" value="Register">
        </form>
        <h3>Already a user? <a href='login.php'> Log In Here!</a></h3>
    </div>
</body>

</html>