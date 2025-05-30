<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Buyer Dashboard | THRIFT IT</title>
<link rel="stylesheet" href="style.css" />
<style>
  .dashboard-container {
    padding: 40px 20px;
    text-align: center;
    color: brown;
  }
  .dashboard-box {
    max-width: 700px;
    margin: 0 auto;
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  }
  h2 {
    color: saddlebrown;
    margin-bottom: 20px;
  }
  .btn-logout {
    background: brown;
    color: white;
    padding: 10px 20px;
    font-weight: bold;
    border: none;
    border-radius: 6px;
    cursor: pointer;
  }
  .btn-logout:hover {
    background: #5e2e2e;
  }
</style>
</head>
<body>
<header class="header-box">
  <div class="logo-title">
    <img src="./logo.png" alt="Logo" />
    <h1>THRIFT IT</h1>
  </div>
  <nav>
    <ul class="nav-links">
      <li><a href="profile.php">Profile</a></li>
      <li>
        <form method="post" action="logout.php" style="display:inline;">
          <button type="submit" class="btn-logout">Logout</button>
        </form>
      </li>
    </ul>
  </nav>
</header>

<div class="dashboard-container">
  <div class="dashboard-box">
    <h2>Buyer Dashboard</h2>
    <p>Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</p>
    <p>Here you can browse and purchase items.</p>
    <!-- You can add product browsing, order history, etc. here -->
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
