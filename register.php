<?php
// db.php should be included to connect to DB
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email already registered. Please login.'); window.location.href='login.html';</script>";
        exit();
    }
    $stmt->close();

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        // Registration success - alert then redirect
        echo "<script>
                alert('Registered successfully! Please login.');
                window.location.href='login.html';
              </script>";
    } else {
        echo "<script>alert('Registration failed. Try again.'); window.location.href='register.html';</script>";
    }
    $stmt->close();
    $conn->close();
}
?>
