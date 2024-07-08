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
$dbname = "test2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize form data
$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
$matricNo = htmlspecialchars($_POST['matricNo'], ENT_QUOTES, 'UTF-8');
$addressCu = htmlspecialchars($_POST['addressCu'], ENT_QUOTES, 'UTF-8');
$addressHo = htmlspecialchars($_POST['addressHo'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
$phoneNum = htmlspecialchars($_POST['phoneNum'], ENT_QUOTES, 'UTF-8');

// Insert data into database
$sql = $conn->prepare("INSERT INTO student_detail (name, matricNo, addressCu, addressHo, email, phoneNum) VALUES (?, ?, ?, ?, ?, ?)");
$sql->bind_param("ssssss", $name, $matricNo, $addressCu, $addressHo, $email, $phoneNum);

if ($sql->execute() === TRUE) {
    echo "User registered successfully.";
} else {
    echo "Error: " . $sql->error;
}

$conn->close();
?>
