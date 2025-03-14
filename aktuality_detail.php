<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail aktuality</title>
    <link rel="stylesheet" href="BA_styles.css">
</head>
<body>
    <?php
    // Připojení k databázi
    $conn = new mysqli('localhost', 'root', '', 'projektv3');
    if ($conn->connect_error) {
        die("Připojení selhalo: " . $conn->connect_error);
    }

    // Získání ID aktuality z URL
    $akt_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $sql = "SELECT title, text, `nazev-obr` FROM aktuailty WHERE akt_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $akt_id);
    $stmt->execute();
    $stmt->bind_result($title, $text, $nazev_obr);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    ?>

    <header>
        <h1><?php echo htmlspecialchars($title); ?></h1>
    </header>

    <div class="article-content">
        <p><?php echo nl2br(htmlspecialchars($text)); ?></p>
        <?php if (!empty($nazev_obr)): ?>
            <img src="aktuality_pics/<?php echo htmlspecialchars($nazev_obr); ?>" alt="<?php echo htmlspecialchars($title); ?>">
        <?php endif; ?>
    </div>

    <div class="back-link">
        <a href="aktuality_bs.php">Zpět</a>
    </div>
</body>
</html>
