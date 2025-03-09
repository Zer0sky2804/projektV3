<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projektv3";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Připojení k databázi selhalo: " . $conn->connect_error);
}

$title = $_POST['blog-title'];
$content = $_POST['blog-content'];

$sql = "INSERT INTO blog (title, text) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $title, $content);

if ($stmt->execute()) {
    header("Location: " . $_SERVER['HTTP_REFERER']); // Refresh stránky
    exit();
} else {
    echo "Chyba: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
