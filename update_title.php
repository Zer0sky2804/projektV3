<?php
$servername = "localhost";
$username = "root";  
$password = "";
$dbname = "projektv3";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["title"])) {
    $title = trim($_POST["title"]);

    if (!empty($title)) {
        $stmt = $conn->prepare("UPDATE admin SET nadpis = ? WHERE id = 1");
        $stmt->bind_param("s", $title);
        if ($stmt->execute()) {
            echo "Nadpis byl úspěšně aktualizován.";
        } else {
            echo "Chyba při aktualizaci.";
        }
        $stmt->close();
    } else {
        echo "Nadpis nemůže být prázdný!";
    }
}

$conn->close();
?>
