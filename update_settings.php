<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projektv3";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Chyba připojení k databázi.");
}

$fieldMap = [
    'title' => 'title',
    'keywords' => 'keywords',
    'description' => 'description',
    'nadpis' => 'nadpis'
];

foreach ($fieldMap as $postKey => $dbColumn) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST[$postKey])) {
        $value = trim($_POST[$postKey]);

        if (!empty($value)) {
            $stmt = $conn->prepare("UPDATE admin SET $dbColumn = ? WHERE id = 1");
            $stmt->bind_param("s", $value);
            if ($stmt->execute()) {
                echo ucfirst($dbColumn) . " byl úspěšně aktualizován.";
            } else {
                echo "Chyba při aktualizaci.";
            }
            $stmt->close();
        } else {
            echo ucfirst($dbColumn) . " nemůže být prázdný!";
        }
    }
}

$conn->close();
?>
