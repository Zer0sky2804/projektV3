<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projektv3";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Chyba připojení k databázi.");
}

$sql = "SELECT title, keywords, description, nadpis FROM admin WHERE id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentTitle = $row["title"];
    $currentKeywords = $row["keywords"];
    $currentDescription = $row["description"];
    $currentNadpis = $row["nadpis"];
} else {
    $currentTitle = "Default Title";
    $currentKeywords = "default, keywords";
    $currentDescription = "Default description.";
    $currentNadpis = "Default Nadpis";
}

$conn->close();
?>
