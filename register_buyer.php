<?php
$host = 'localhost';
$user = 'root';
$password = 'YOUR_PASSWORD';
$database = 'thrift';

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Only proceed if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $raw_password = isset($_POST['password']) ? $_POST['password'] : '';
    $role = 'buyer';

    // Check if fields are empty
    if ($username === '' || $email === '' || $raw_password === '') {
        echo "<script>alert('Please fill all required fields.'); window.location.href='register_buyer.html';</script>";
        exit;
    }

    // Check if email or username already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $check->bind_param("ss", $email, $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Email or Username already registered. Please use different credentials or login.'); window.location.href='register_buyer.html';</script>";
        $check->close();
        exit;
    }
    $check->close();

    // Hash password
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    // Prepare SQL to insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "<script>
            alert('Registration successful as Buyer!');
            setTimeout(function() {
                window.location.href='login.html';
            }, 1000);
        </script>";
    } else {
        echo "<script>
            alert('Error during registration: " . $conn->error . "');
            window.location.href='register_buyer.html';
        </script>";
    }

    $stmt->close();
}

$conn->close();
?>
