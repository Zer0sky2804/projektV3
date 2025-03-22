<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie</title>
    <link rel="stylesheet" href="galerie_show.css">
</head>
<body>

<header>
    <h1>Vítejte v sekci galerie</h1>
</header>

<nav>
    <ul>
        <li><a href="index.php">Domů</a></li>
        <li><a href="blog_bs.php">Blog</a></li>
        <li><a href="aktuality_bs.php">Aktuality</a></li>
        <li><a href="" class="active">Galerie</a></li>
    </ul>
</nav>

<div class="gallery-container">
    <?php
    $servername = "localhost";
    $username = "root";  
    $password = "";
    $dbname = "projektv3";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Připojení selhalo: " . $conn->connect_error);
    }

    $sql = "SELECT pictures_name FROM gallery";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<img class="gallery-img" src="galerie_pics/' . htmlspecialchars($row["pictures_name"]) . '" alt="Obrázek z galerie">';
        }
    } else {
        echo "<p>Žádné obrázky nenalezeny.</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
