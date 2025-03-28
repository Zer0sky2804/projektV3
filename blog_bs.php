<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="BA_styles.css">
</head>
<body>

    <header>
        <nav class="header-nav">
            <a href="index.php">Home</a>
            <a href="" class="active">Blog</a>
            <a href="aktuality.php">Aktuality</a>
            <a href="galerie_show.php">Galerie</a>
        </nav>
    </header>

    <div id="blog-container">
        <?php
        $conn = new mysqli('localhost', 'root', '', 'projektv3');

        if ($conn->connect_error) {
            die("Připojení selhalo: " . $conn->connect_error);
        }

        $sql = "SELECT blog_id, title, text, `nazev-obr` FROM blog";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $shortText = htmlspecialchars(mb_substr($row['text'], 0, 100)) . '...';
                $imagePath = (!empty($row['nazev-obr']) && file_exists('blog_pics/' . $row['nazev-obr']))
                    ? 'blog_pics/' . htmlspecialchars($row['nazev-obr'])
                    : 'blog_pics/default.jpg';

                echo '<div class="blog-post">';
                echo '<img src="' . $imagePath . '" alt="Obrázek blogu">';
                echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                echo '<p>' . $shortText . '</p>';
                echo '<a href="blog_detail.php?id=' . $row['blog_id'] . '"><button>Přečíst</button></a>';
                echo '</div>';
            }
        } else {
            echo "<p>Žádné příspěvky nenalezeny.</p>";
        }

        $conn->close();
        ?>
    </div>

</body>
</html>
