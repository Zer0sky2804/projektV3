<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projektv3";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Připojení k databázi selhalo: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['blog-id']);
    $newTitle = $conn->real_escape_string($_POST['blog-title']);
    $newContent = $conn->real_escape_string($_POST['blog-content']);

    $updateSql = "UPDATE blog SET title = ?, text = ? WHERE blog_id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssi", $newTitle, $newContent, $id);

    if ($updateStmt->execute()) {
        echo "Článek byl úspěšně aktualizován.";
    } else {
        echo "Chyba při aktualizaci článku: " . $conn->error;
    }

    $updateStmt->close();
}
$conn->close();
header("Location: selector.php");
exit();
?>
