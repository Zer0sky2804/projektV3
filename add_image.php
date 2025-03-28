<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projektv3";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Připojení k databázi selhalo: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["images"])) {
    $targetDir = "galerie_pics/";

    foreach ($_FILES["images"]["name"] as $key => $fileName) {
        $targetFilePath = $targetDir . basename($fileName);

        if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $targetFilePath)) {
            $sql = "INSERT INTO gallery (pictures_name) VALUES ('$fileName')";
            if (!$conn->query($sql)) {
                echo "Chyba při nahrávání obrázku: " . $conn->error;
            }
        } else {
            echo "Chyba při nahrávání souboru: " . $fileName;
        }
    }
}

$conn->close();
header("Location: selector.php");
exit();
?>
