<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projektv3";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Připojení k databázi selhalo: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);
    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $sql = "UPDATE users SET nickname = ?, email = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nickname, $email, $user_id);
    if ($stmt->execute()) {
        echo "Uživatel byl úspěšně upraven.";
    } else {
        echo "Chyba při úpravě uživatele: " . $conn->error;
    }
}

$sql = "SELECT user_id, nickname, email FROM users";
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
            <button id="addUserBtn" class="open-modal-btn">Přidat uživatele</button>
        </div>
        <div class="content">
            <?php if ($result && $result->num_rows > 0): ?>
                <ul class="user-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li>
                            <strong>Jméno:</strong> <?php echo htmlspecialchars($row['nickname']); ?> <br>
                            <strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?> <br>
                            <button class="edit-btn" onclick="openEditModal(<?php echo $row['user_id']; ?>, '<?php echo htmlspecialchars($row['nickname']); ?>', '<?php echo htmlspecialchars($row['email']); ?>')">Upravit</button>
                            <button class="delete-btn" onclick="deleteUser(<?php echo $row['user_id']; ?>)">Smazat</button>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>Žádní uživatelé nebyli nalezeni.</p>
            <?php endif; ?>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <form method="POST">
                <h2>Upravit uživatele</h2>
                <input type="hidden" id="edit_user_id" name="user_id">
                <label for="edit_nickname">Jméno:</label><br>
                <input type="text" id="edit_nickname" name="nickname" required><br>
                <label for="edit_email">Email:</label><br>
                <input type="email" id="edit_email" name="email" required><br>
                <button type="submit">Uložit změny</button>
            </form>
        </div>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeAddUserModal">&times;</span>
            <form id="addUserForm" action="register.php" method="POST">
                <h2>Přidat uživatele</h2>
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

    <script>
        var addUserModal = document.getElementById("myModal");
        var addUserBtn = document.getElementById("addUserBtn");
        var closeAddUserModal = document.getElementById("closeAddUserModal");

        addUserBtn.onclick = function() {
            addUserModal.style.display = "block";
        }

        closeAddUserModal.onclick = function() {
            addUserModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == addUserModal) {
                addUserModal.style.display = "none";
            }
        }

        function openEditModal(userId, nickname, email) {
            document.getElementById('edit_user_id').value = userId;
            document.getElementById('edit_nickname').value = nickname;
            document.getElementById('edit_email').value = email;
            document.getElementById('editModal').style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>