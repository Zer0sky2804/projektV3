<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projektv3";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Připojení k databázi selhalo: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $targetDir = "galerie_pics/";
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        $sql = "INSERT INTO gallery (pictures_name) VALUES ('$fileName')";
        if ($conn->query($sql) === TRUE) {
            echo "Obrázek byl úspěšně nahrán.";
        } else {
            echo "Chyba při nahrávání obrázku: " . $conn->error;
        }
    } else {
        echo "Chyba při nahrávání souboru.";
    }
}

$conn->close();
header("Location: galerie.php");
exit();
?>
