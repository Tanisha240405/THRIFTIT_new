<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$host = 'localhost';
$user = 'root';
$password = 'YOUR_PASSWORD';
$database = 'thrift';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = $_SESSION['user_id'];
$sql = "SELECT username, email, role FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile | THRIFT IT</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .profile-container {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 60px 20px;
    }

    .profile-box {
      background-color: white;
      color: brown;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
      max-width: 400px;
      text-align: center;
    }

    .profile-box h2 {
      color: saddlebrown;
      margin-bottom: 20px;
    }

    .profile-box p {
      margin: 10px 0;
      font-size: 1.1rem;
    }

    .logout-btn {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: brown;
      color: white;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }

    .logout-btn:hover {
      background-color: #5e2e2e;
    }
  </style>
</head>
<body>
  <header class="header-box">
    <div class="logo-title">
      <img src="./logo.png" alt="Logo">
      <h1>THRIFT IT</h1>
    </div>
    <nav>
      <ul class="nav-links">
        <li><a href="index.html">Home</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <div class="profile-container">
    <div class="profile-box">
      <h2>Welcome, <?= htmlspecialchars($user['username']) ?>!</h2>
      <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
      <p><strong>Role:</strong> <?= ucfirst($user['role']) ?></p>
      <form action="logout.php" method="post">
        <button type="submit" class="logout-btn">Logout</button>
      </form>
    </div>
  </div>

  <footer>
    <p>
      <a href="#">@Twitter</a> |
      <a href="#">@Facebook</a> |
      <a href="#">@Instagram</a>
    </p>
  </footer>
</body>
</html>
