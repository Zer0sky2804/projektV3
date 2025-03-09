<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projektv3";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Připojení k databázi selhalo: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM blog WHERE blog_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Článek byl úspěšně smazán.";
    } else {
        echo "Chyba při mazání článku: " . $conn->error;
    }
}
$conn->close();
?>