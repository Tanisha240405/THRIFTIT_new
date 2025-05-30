<?php
session_start();
$host = 'localhost';
$user = 'root';
$password = 'YOUR_PASSWORD';
$database = 'thrift';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$email = trim($_POST['email']);
$pass = trim($_POST['password']);

$sql = "SELECT * FROM users WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        if ($user['role'] === 'buyer') {
            header("Location: buyer_dashboard.php");
            exit();
        } else if ($user['role'] === 'seller') {
            header("Location: seller_dashboard.php");
            exit();
        }
    }
}

echo "<script>alert('Invalid credentials'); window.location.href='login.html';</script>";
$stmt->close();
$conn->close();
?>
