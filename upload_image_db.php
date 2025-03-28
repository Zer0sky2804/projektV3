<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projektv3";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Chyba připojení: " . $conn->connect_error);
}

if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = "uploads/";
    $filename = basename($_FILES['image']['name']);
    $targetFilePath = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
        $sql = "UPDATE settings SET image = ? WHERE id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $filename);
        if ($stmt->execute()) {
            echo "Obrázek byl úspěšně nahrán!";
        } else {
            echo "Chyba při ukládání do databáze.";
        }
        $stmt->close();
    } else {
        echo "Chyba při nahrávání souboru.";
    }
} else {
    echo "Chyba při nahrávání souboru.";
}

$conn->close();
?>
