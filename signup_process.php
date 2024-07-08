<?php
session_start();

// Generate CSRF token if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check CSRF token
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize form data
$username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
$password = password_hash(htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8'), PASSWORD_DEFAULT);

// Insert data into database
$sql = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$sql->bind_param("ss", $username, $password);

if ($sql->execute() === TRUE) {
    echo "<script>alert('User registered successfully.'); window.location.href='login.php';</script>";
} else {
    echo "Error: " . $sql->error;
}

$conn->close();
?>
