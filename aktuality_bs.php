<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktuality</title>
    <link rel="stylesheet" href="BA_styles.css">
</head>
<body>
    <header>
        <h1>Vítejte v sekci aktuality</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Domů</a></li>
            <li><a href="blog_bs.php">Blog</a></li>
            <li><a href="" class="active">Aktuality</a></li>
            <li><a href="#">Galerie</a></li>
        </ul>
    </nav>

    <div id="aktuality-buttons">
        <?php
        $conn = new mysqli('localhost', 'root', '', 'projektv3');
        if ($conn->connect_error) {
            die("Připojení selhalo: " . $conn->connect_error);
        }
        
        $sql = "SELECT akt_id, title FROM aktuailty";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<a href="aktuality_detail.php?id=' . $row['akt_id'] . '"><button>' . htmlspecialchars($row['title']) . '</button></a>';
            }
        } else {
            echo "Žádné aktuality nenalezeny.";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
