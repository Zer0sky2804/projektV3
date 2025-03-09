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

            $sql = "SELECT blog_id, title, text FROM blog";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="post">
                        <div class="post-header">
                            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                            <div class="button-group">
                                <button class="edit-btn" data-id="<?php echo $row['blog_id']; ?>" data-title="<?php echo htmlspecialchars($row['title']); ?>" data-text="<?php echo htmlspecialchars($row['text']); ?>">Upravit</button>
                                <button class="delete-btn" data-id="<?php echo $row['blog_id']; ?>" onclick="deletePost(<?php echo $row['blog_id']; ?>)">Smazat</button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Žádné články nebyly nalezeny.</p>
            <?php endif; ?>

            <?php $conn->close(); ?>
        </div>
    </div>

    <!-- Modal pro přidání článku -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="add-blog-form" action="add_blog.php" method="POST">
                <h2>Přidání článku</h2>
                <label for="add-blog-title">Nadpis:</label><br>
                <input type="text" id="add-blog-title" name="blog-title" required><br>
                <label for="add-blog-content">Obsah:</label><br>
                <textarea id="add-blog-content" name="blog-content" rows="5" required></textarea><br><br>
                <button type="submit">Přidat článek</button>
            </form>
        </div>
    </div>

    <!-- Modal pro editaci článku -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="edit-blog-form" action="edit_blog.php" method="POST">
                <input type="hidden" id="edit-blog-id" name="blog-id">
                <h2>Úprava článku</h2>
                <label for="edit-blog-title">Nadpis:</label><br>
                <input type="text" id="edit-blog-title" name="blog-title" required><br>
                <label for="edit-blog-content">Obsah:</label><br>
                <textarea id="edit-blog-content" name="blog-content" rows="5" required></textarea><br><br>
                <button type="submit">Uložit změny</button>
            </form>
        </div>
    </div>

    <script>
        // Otevření modálního okna pro přidání článku
        document.getElementById('modalBtn').addEventListener('click', function() {
            document.getElementById('addModal').style.display = 'block';
        });

        // Otevření modálního okna pro editaci článku
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('edit-blog-id').value = this.dataset.id;
                document.getElementById('edit-blog-title').value = this.dataset.title;
                document.getElementById('edit-blog-content').value = this.dataset.text;
                document.getElementById('editModal').style.display = 'block';
            });
        });

        // Zavření modálního okna
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

        function deletePost(blogId) {
            if (confirm('Opravdu chcete tento článek smazat?')) {
                fetch('delete_blog.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + blogId
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
</body>
</html>
