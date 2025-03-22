<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="galerie.css">
    <title>Správa galerie</title>
</head>
<body>
    <div class="table">
        <div class="header">
            <h2>Již přidané obrázky</h2>
            <button id="modalBtn" class="open-modal-btn">Přidat obrázek</button>
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

            $sql = "SELECT galerie_id, pictures_name FROM gallery";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='post'>
                            <div class='post-header'>
                                <img class='thumbnail' src='galerie_pics/" . htmlspecialchars($row['pictures_name']) . "' alt='Obrázek galerie'>
                                <div class='button-group'>
                                    <button class='view-image-btn' data-image='galerie_pics/" . htmlspecialchars($row['pictures_name']) . "'>Zobrazit obrázek</button>
                                    <button class='delete-btn' data-id='" . $row['galerie_id'] . "' onclick='deletePost(" . $row['galerie_id'] . ")'>Smazat</button>
                                    </div>
                                </div>
                        </div>";
                }
            } else {
                echo "<p>Žádné obrázky nebyly nalezeny.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <!-- Modal pro přidání obrázku -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Přidat nový obrázek</h2>
            <form action="add_image.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="image" required><br>
                <button type="submit">Nahrát</button>
            </form>
        </div>
    </div>

    <!-- Modal pro zobrazení obrázku -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Náhled obrázku</h2>
            <img id="preview-image" src="" alt="Náhled obrázku">
        </div>
    </div>

    <script>
        document.getElementById('modalBtn').addEventListener('click', function() {
            document.getElementById('addModal').style.display = 'block';
        });

        document.querySelectorAll('.view-image-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('preview-image').src = this.dataset.image;
                document.getElementById('viewModal').style.display = 'block';
            });
        });

        document.querySelectorAll('.close').forEach(closeBtn => {
            closeBtn.addEventListener('click', function() {
                this.closest('.modal').style.display = 'none';
            });
        });

        window.onclick = function(event) {
            document.querySelectorAll('.modal').forEach(modal => {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });
        }
        function deletePost(id) {
    if (confirm('Opravdu chcete tento obrázek smazat?')) {
        fetch('delete_image.php', {
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
