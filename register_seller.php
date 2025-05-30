<?php
// Database config
$host = 'localhost';
$user = 'root';
$password = 'YOUR_PASSWORD';
$dbname = 'thrift';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password_raw = isset($_POST['password']) ? $_POST['password'] : '';

    if ($username === '' || $email === '' || $password_raw === '') {
        echo "Please fill all required fields.";
        exit;
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "Email already registered. Please <a href='login.php'>login</a>.";
        $stmt->close();
        exit;
    }
    $stmt->close();

    // Hash password
    $hashed_password = password_hash($password_raw, PASSWORD_DEFAULT);
    $role = 'seller';

    // Insert new seller
    $insert_stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $insert_stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

    if ($insert_stmt->execute()) {
        echo "
        <html>
        <head>
            <meta http-equiv='refresh' content='3;url=login.php' />
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background: #f9f1e7;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    color: #4b2e2e;
                    text-align: center;
                }
                .message-box {
                    background: #fff;
                    padding: 40px;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                }
                .message-box a {
                    color: brown;
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <div class='message-box'>
                <h2>Registration Successful!</h2>
                <p>Redirecting to login page in 3 seconds...</p>
                <p>If not redirected, <a href='login.php'>click here</a>.</p>
            </div>
        </body>
        </html>
        ";
    } else {
        echo "Error during registration: " . $conn->error;
    }

    $insert_stmt->close();
}

$conn->close();
