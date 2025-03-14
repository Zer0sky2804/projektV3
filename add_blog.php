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
$imageName = "";

if (isset($_FILES['blog-image']) && $_FILES['blog-image']['error'] == 0) {
    $targetDir = "blog_pics/";
    $imageName = basename($_FILES['blog-image']['name']);
    $targetFile = $targetDir . $imageName;

    if (!move_uploaded_file($_FILES['blog-image']['tmp_name'], $targetFile)) {
        die("Chyba při nahrávání obrázku.");
    }
}

$sql = "INSERT INTO blog (title, text, `nazev-obr`) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $title, $content, $imageName);

if ($stmt->execute()) {
    
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    echo "Chyba: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
