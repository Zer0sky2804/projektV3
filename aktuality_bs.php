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
        <nav class="header-nav">
            <a href="index.php">Home</a>
            <a href="blog_bs.php">Blog</a>
            <a href="" class="active">Aktuality</a>
            <a href="galerie_show.php">Galerie</a>
        </nav>
    </header>

    <div id="aktuality-container">
        <?php
        $conn = new mysqli('localhost', 'root', '', 'projektv3');
        if ($conn->connect_error) {
            die("Připojení selhalo: " . $conn->connect_error);
        }

        $sql = "SELECT akt_id, title, text, `nazev-obr` FROM aktuailty";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $shortText = mb_substr($row['text'], 0, 50) . '...';

                $imagePath = !empty($row['nazev-obr']) ? 'aktuality_pics/' . htmlspecialchars($row['nazev-obr']) : 'aktuality_pics/default.jpg';

                echo '<div class="aktualita">';
                echo '<img src="' . $imagePath . '" alt="Obrázek aktuality">';
                echo '<p>' . htmlspecialchars($shortText) . '</p>';
                echo '<a href="aktuality_detail.php?id=' . $row['akt_id'] . '"><button>Přečíst</button></a>';
                echo '</div>';
            }
        } else {
            echo "<p>Žádné aktuality nenalezeny.</p>";
        }
        $conn->close();
        ?>
    </div>

</body>
</html>
