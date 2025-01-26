<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projektv3";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Připojení k databázi selhalo: " . $conn->connect_error);
}

$sql = "SELECT nickname, email FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="users.css">
    <title>Users</title>
</head>
<body>
    <div class="table">
        <div class="header">
            <h2>Již přidaní uživatelé</h2>
            <button id="modalBtn" onclick="alert('test');" class="open-modal-btn">Přidat uživatele</button>
        </div>
        <div class="content">
            <?php if ($result && $result->num_rows > 0): ?>
                <ul class="user-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li>
                            <strong>Jméno:</strong> <?php echo htmlspecialchars($row['nickname']); ?> <br>
                            <strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>Žádní uživatelé nebyli nalezeni.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modální okno -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="login-form" name="login-form" action="register.php" method="POST">
                <h2>Přidání uživatele</h2>
                <label for="nickname">Jméno:</label><br>
                <input type="text" id="nickname" name="nickname" required><br>
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" required><br>
                <label for="password">Heslo:</label><br>
                <input type="password" id="password" name="password" required><br>
                <button type="submit">Přidat uživatele</button>
            </form>
        </div>
    </div>

    <script src="modal.js"></script>
</body>
</html>

<?php
$conn->close();
?>
