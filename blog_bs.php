<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogy</title>
    <link rel="stylesheet" href="BA_styles.css">
</head>
<body>
    <header>
        <h1>Vítejte v sekci blogy</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Domů</a></li>
            <li><a href="" class="active" >Blog</a></li>
            <li><a href="aktuality_bs.php">Aktuality</a></li>
            <li><a href="galerie_show.php">Galerie</a></li>
        </ul>
    </nav>

    <div id="blog-buttons">
        <?php
        $conn = new mysqli('localhost', 'root', '', 'projektv3');
        if ($conn->connect_error) {
            die("Připojení selhalo: " . $conn->connect_error);
        }
        
        $sql = "SELECT blog_id, title FROM blog";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<a href="blog_detail.php?id=' . $row['blog_id'] . '"><button>' . htmlspecialchars($row['title']) . '</button></a>';
            }
        }
        $conn->close();
        ?>
    </div>
    
</body>
</html>
