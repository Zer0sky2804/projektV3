<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="creator.css">
    <title>Správa aktualit</title>
</head>
<body>
    <div class="table">
        <div class="header">
            <h2>Již přidané aktuality</h2>
            <button id="modalBtn" class="open-modal-btn">Přidat aktualitu</button>
        </div>

        <div class="posts-container">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "projektv3";

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Připojení k databázi selhalo: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM aktuailty";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='post'>
                            <div class='post-header'>
                                <h3>" . htmlspecialchars($row['title']) . "</h3>
                                <p>" . htmlspecialchars($row['text']) . "</p>
                                <div class='button-group'>
                                    <button class='edit-btn' data-id='" . $row['akt_id'] . "' data-title='" . htmlspecialchars($row['title']) . "' data-text='" . htmlspecialchars($row['text']) . "'>Upravit</button>
                                    <button class='delete-btn' data-id='" . $row['akt_id'] . "' onclick='deletePost(" . $row['akt_id'] . ")'>Smazat</button>
                                </div>
                            </div>
                        </div>";
                }
            } else {
                echo "<p>Žádné aktuality nebyly nalezeny.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="add-aktuailty-form" action="add_aktuailty.php" method="POST" enctype="multipart/form-data">
                <h2>Přidání aktuality</h2>
                <label for="add-title">Nadpis:</label><br>
                <input type="text" id="add-title" name="title" required><br>
                <label for="add-text">Obsah:</label><br>
                <textarea id="add-text" name="text" rows="5" required></textarea><br>
                <label for="add-image">Přidat obrázek:</label><br>
                <input type="file" id="add-image" name="nazev-obr" accept="image/*"><br><br>
                <button type="submit">Přidat aktualitu</button>
            </form>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="edit-aktuailty-form" action="edit_aktuailty.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="edit-id" name="akt_id">
                <h2>Úprava aktuality</h2>
                <label for="edit-title">Nadpis:</label><br>
                <input type="text" id="edit-title" name="title" required><br>
                <label for="edit-text">Obsah:</label><br>
                <textarea id="edit-text" name="text" rows="5" required></textarea><br>
                <label for="edit-image">Změnit obrázek:</label><br>
                <input type="file" id="edit-image" name="nazev-obr" accept="image/*"><br><br>
                <button type="submit">Uložit změny</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('modalBtn').addEventListener('click', function() {
            document.getElementById('addModal').style.display = 'block';
        });

        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('edit-id').value = this.dataset.id;
                document.getElementById('edit-title').value = this.dataset.title;
                document.getElementById('edit-text').value = this.dataset.text;
                document.getElementById('editModal').style.display = 'block';
            });
        });

        document.querySelectorAll('.close').forEach(closeBtn => {
            closeBtn.addEventListener('click', function() {
                document.getElementById('addModal').style.display = 'none';
                document.getElementById('editModal').style.display = 'none';
            });
        });

        window.onclick = function(event) {
            if (event.target == document.getElementById('addModal')) {
                document.getElementById('addModal').style.display = 'none';
            }
            if (event.target == document.getElementById('editModal')) {
                document.getElementById('editModal').style.display = 'none';
            }
        }
        function deletePost(id) {
    if (confirm('Opravdu chcete tuto aktualitu smazat?')) {
        fetch('delete_aktuailty.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + id
        }).then(response => response.text())
          .then(data => {
              alert(data);
              location.reload();
          }).catch(error => console.error('Chyba:', error));
    }
}

    </script>
</body>
</html>
