<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sett.css">
    <title>Nastavení</title>
    <script>
        function updateTitle() {
            let title = document.getElementById("main-title").value;
            let messageBox = document.getElementById("message-box");

            if (title.trim() === "") {
                messageBox.innerHTML = "⚠️ Nadpis nemůže být prázdný!";
                messageBox.style.color = "red";
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "update_title.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        messageBox.innerHTML = "✅ Nadpis byl úspěšně aktualizován!";
                        messageBox.style.color = "green";
                    } else {
                        messageBox.innerHTML = "❌ Chyba při aktualizaci.";
                        messageBox.style.color = "red";
                    }
                }
            };
            xhr.send("title=" + encodeURIComponent(title));
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('upload-button').addEventListener('click', function() {
                let fileInput = document.getElementById('image-upload');
                let file = fileInput.files[0];
                if (!file) {
                    alert('Prosím, vyberte soubor!');
                    return;
                }

                let formData = new FormData();
                formData.append('image', file);

                fetch('upload_image_db.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.text())
                  .then(data => alert(data))
                  .catch(error => console.error('Chyba:', error));
            });
        });
    </script>
</head>

<body>
    <div class="table">
        <div class="section">
            <h3>Description</h3>
            <div class="input-container">
                <input type="text" placeholder="Textbox 1">
                <button>OK</button>
            </div>
        </div>
        
        <div class="section">
            <h3>Keywords</h3>
            <div class="input-container">
                <input type="text" placeholder="Textbox 2">
                <button>OK</button>
            </div>
        </div>

        <div class="section">
            <h3>Title</h3>
            <div class="input-container">
                <input type="text" placeholder="Textbox 1">
                <button>OK</button>
            </div>
        </div>

        <div class="section">
            <h3>Hlavní stránka</h3>
            <div class="input-container">
                <?php
                include 'load_title.php'; 
                ?>
                <input type="text" id="main-title" value="<?= htmlspecialchars($currentTitle) ?>" placeholder="Zadejte nadpis">
                <button onclick="updateTitle()">OK</button>
                <p id="message-box"></p> 
            </div>
        </div>

        <div class="section">
            <h3>Nahrát obrázek</h3>
            <div class="input-container">
                <input type="file" id="image-upload" accept="image/*">
                <button id="upload-button">Nahrát</button>
            </div>
        </div>
    </div>
</body>
</html>
