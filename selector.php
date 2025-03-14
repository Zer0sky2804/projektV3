<?php
session_start();

$servername = "localhost";
$username = "root";  
$password = "";
$dbname = "projektv3";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Chyba připojení k databázi: " . $connection->connect_error);
}

$userName = "Nepřihlášený uživatel";

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
   
    $query = "SELECT nickname FROM users WHERE user_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userName = htmlspecialchars($row['nickname']); 
    }
    $stmt->close();
}


$connection->close();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="selector.css">
    <title>Selector</title>
</head>
<body>
    <div class="head">
        <div class="left">
            <h1>BlogPage</h1>
        </div>
        <div class="right">
            <button class="btn" id="modalBtn">Open</button>
        </div>
    </div>

    <div class="main-content">
        <div class="container">
            <button class="container-btn" onclick="loadPage('users.php')">Uživatelé</button>
            <button class="container-btn" onclick="loadPage('blog.php')">Příspěvky</button>
            <button class="container-btn" onclick="loadPage('aktuality.php')">Aktuality</button>
            <button class="container-btn" onclick="loadPage('sett.php')">Nastavení</button>
        </div>

        <div class="content-display" id="content-display"></div>
    </div>

    <div id="myModal" class="Modal">
        <div class="modal_content">
            <span class="closed">&times;</span>
            <p><?php echo $userName; ?></p>  
            <a href="logout.php" class="logout-link">Odhlásit se</a>
        </div>
    </div>

    <script src="selector.js"></script>
</body>
</html>
