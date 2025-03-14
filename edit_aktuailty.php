<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projektv3";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Připojení k databázi selhalo: " . $conn->connect_error);
}

$aktId = $_POST['akt_id'];
$title = $_POST['title'];
$content = $_POST['text'];
$imageName = "";

if (isset($_FILES['nazev-obr']) && $_FILES['nazev-obr']['error'] == 0) {
    $targetDir = "aktuality_pics/";
    $imageName = basename($_FILES['nazev-obr']['name']);
    $targetFile = $targetDir . $imageName;

    if (!move_uploaded_file($_FILES['nazev-obr']['tmp_name'], $targetFile)) {
        die("Chyba při nahrávání obrázku.");
    }

    $sql = "UPDATE aktuailty SET title = ?, text = ?, `nazev-obr` = ? WHERE akt_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $content, $imageName, $aktId);
} else {
    $sql = "UPDATE aktuailty SET title = ?, text = ? WHERE akt_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $content, $aktId);
}

if ($stmt->execute()) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    echo "Chyba: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
