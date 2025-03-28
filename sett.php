<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sett.css">
    <title>Nastavení</title>
    <script>
        function updateField(fieldId, messageBoxId, fieldName) {
            let fieldValue = document.getElementById(fieldId).value;
            let messageBox = document.getElementById(messageBoxId);

            if (fieldValue.trim() === "") {
                messageBox.innerHTML = `⚠️ ${fieldName} nemůže být prázdný!`;
                messageBox.style.color = "red";
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "update_settings.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        messageBox.innerHTML = `${fieldName} byl úspěšně aktualizován!`;
                        messageBox.style.color = "green";
                    } else {
                        messageBox.innerHTML = "Chyba při aktualizaci.";
                        messageBox.style.color = "red";
                    }
                }
            };
            xhr.send(`${fieldId}=` + encodeURIComponent(fieldValue));
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
        <?php include 'load_settings.php'; ?>

        <div class="section">
            <h3>Title</h3>
            <div class="input-container">
                <input type="text" id="title" value="<?= htmlspecialchars($currentTitle) ?>" placeholder="Zadejte title">
                <button onclick="updateField('title', 'title-message-box', 'Title')">OK</button>
                <p id="title-message-box"></p>
            </div>
        </div>

        <div class="section">
            <h3>Keywords</h3>
            <div class="input-container">
                <input type="text" id="keywords" value="<?= htmlspecialchars($currentKeywords) ?>" placeholder="Zadejte keywords">
                <button onclick="updateField('keywords', 'keywords-message-box', 'Keywords')">OK</button>
                <p id="keywords-message-box"></p>
            </div>
        </div>

        <div class="section">
            <h3>Description</h3>
            <div class="input-container">
                <input type="text" id="description" value="<?= htmlspecialchars($currentDescription) ?>" placeholder="Zadejte popis">
                <button onclick="updateField('description', 'description-message-box', 'Description')">OK</button>
                <p id="description-message-box"></p>
            </div>
        </div>

        <div class="section">
            <h3>Hlavní nadpis</h3>
            <div class="input-container">
                <input type="text" id="nadpis" value="<?= htmlspecialchars($currentNadpis) ?>" placeholder="Zadejte hlavní nadpis">
                <button onclick="updateField('nadpis', 'nadpis-message-box', 'Nadpis')">OK</button>
                <p id="nadpis-message-box"></p>
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