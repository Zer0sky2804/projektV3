<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projektv3";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Chyba připojení: " . $conn->connect_error);
}
$sql = "SELECT nadpis, picture_name, title, keywords, description FROM admin ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $title = !empty($row["title"]) ? htmlspecialchars($row["title"], ENT_QUOTES, 'UTF-8') : "Výchozí titulek";
    $nadpis = !empty($row["nadpis"]) ? htmlspecialchars($row["nadpis"], ENT_QUOTES, 'UTF-8') : "Výchozí nadpis";
    $image = !empty($row["picture_name"]) ? htmlspecialchars($row["picture_name"], ENT_QUOTES, 'UTF-8') : "default.jpg";
    $keywords = !empty($row["keywords"]) ? htmlspecialchars($row["keywords"], ENT_QUOTES, 'UTF-8') : "výchozí, klíčová, slova";
    $description = !empty($row["description"]) ? htmlspecialchars($row["description"], ENT_QUOTES, 'UTF-8') : "Výchozí popis stránky.";
} else {
    $title = "Výchozí titulek";
    $nadpis = "Výchozí nadpis";
    $image = "default.jpg";
    $keywords = "výchozí, klíčová, slova";
    $description = "Výchozí popis stránky.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <meta name="keywords" content="<?php echo $keywords; ?>">
    <meta name="description" content="<?php echo $description; ?>">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="background" style="background-image: url('pictures/<?php echo $image; ?>');"></div>
    <div class="title"><?php echo $nadpis; ?></div>

    <header>
        <nav class="header-nav">
            <a href="blog_bs.php">Blog</a>
            <a href="aktuality_bs.php">Aktuality</a>
            <a href="galerie_show.php">Galerie</a>
        </nav>
    </header>
</body>
</html>
