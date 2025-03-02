<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projektv3";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Chyba připojení: " . $conn->connect_error);
}

$sql = "SELECT nadpis, picture_name FROM admin ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nadpis = htmlspecialchars($row["nadpis"], ENT_QUOTES, 'UTF-8');
    $image = htmlspecialchars($row["picture_name"], ENT_QUOTES, 'UTF-8');
} else {
    $nadpis = "Výchozí nadpis";
    $image = "default.jpg";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nadpis; ?></title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="background" style="background-image: url('pictures/<?php echo $image; ?>');"></div>
    <div class="title"><?php echo $nadpis; ?></div>

    <button class="menu-button" onclick="toggleSidenav()">Menu</button>

    <div class="sidenav" id="sidenav">
        <a href="#">Aktuality</a>
        <a href="#">Články</a>
        <a href="#">Galerie</a>
    </div>

    <script>
        function toggleSidenav() {
            const sidenav = document.getElementById('sidenav');
            sidenav.classList.toggle('active');
        }
    </script>
</body>
</html>