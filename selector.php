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

$page = isset($_GET['page']) ? $_GET['page'] : 'users.php';
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
            <button class="btn" id="ModalBtn"><p><?php echo $userName; ?></p></button>
        </div>
    </div>

    <div class="main-content">
        <div class="container">
            <button class="container-btn" onclick="changePage('users.php')">Uživatelé</button>
            <button class="container-btn" onclick="changePage('blog.php')">Blogy</button>
            <button class="container-btn" onclick="changePage('aktuality.php')">Aktuality</button>
            <button class="container-btn" onclick="changePage('galerie.php')">Galerie</button>
            <button class="container-btn" onclick="changePage('sett.php')">Nastavení</button>
        </div>

        <div class="content-display" id="content-display">
            <?php include $page; ?>
        </div>
    </div>

    <div id="mModal" class="Modal">
        <div class="modal_content">
            <span class="closed">&times;</span>
            <p><?php echo $userName; ?></p>  
            <a href="logout.php" class="logout-link">Odhlásit se</a>
        </div>
    </div>

    <script>
        function changePage(page) {
            window.location.href = '?page=' + page;
        }
    </script>
    <script src="selector.js"></script>
</body>
</html>
