<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projektv3";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Připojení k databázi selhalo: " . $conn->connect_error);
}

$sql = "SELECT title FROM blog";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="creator.css">
    <title>Blog Articles</title>
</head>
<body>
    <div class="table">
        <div class="header">
            <h2>Již přidané články</h2>
            <button id="modalBtn" class="open-modal-btn">Přidat článek</button>
        </div>
 
        <div class="content">
            <?php if ($result && $result->num_rows > 0): ?>
                <ul class="article-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li>
                             <?php echo htmlspecialchars($row['title']); ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>Žádné články nebyly nalezeny.</p>
            <?php endif; ?>
        </div>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="blog-form" action="creator.php" method="POST" enctype="multipart/form-data">
                <h2>Přidání článku</h2>
                <label for="blog-title">Nadpis:</label><br>
                <input type="text" id="blog-title" name="blog-title" required><br>
                <label for="blog-content">Obsah:</label><br>
                <textarea id="blog-content" name="blog-content" rows="5" required></textarea><br>
                <label for="blog-image">Vložit obrázek:</label><br>
                <input type="file" id="blog-image" name="blog-image" accept="image/*"><br><br>
                <button type="submit">Přidat článek</button>
            </form>
        </div>
    </div>

    <script src="modal.js"></script>
</body>
</html>

<?php
$conn->close();
?>
