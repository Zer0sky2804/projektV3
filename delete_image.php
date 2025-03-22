<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projektv3";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Připojení k databázi selhalo: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];

    $sql = "SELECT pictures_name FROM gallery WHERE galerie_id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $filePath = "galerie_pics/" . $row["pictures_name"];

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $sql = "DELETE FROM gallery WHERE galerie_id = $id";
        if ($conn->query($sql) === TRUE) {
            echo "Obrázek byl úspěšně smazán.";
        } else {
            echo "Chyba při mazání obrázku: " . $conn->error;
        }
    }
}

$conn->close();
?>
