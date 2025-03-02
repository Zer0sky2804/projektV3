<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $targetDir = 'pictures/';
    $fileName = basename($_FILES['image']['name']);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    
    // Povolené formáty obrázků
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            // Připojení k databázi
            $servername = 'localhost';
            $username = 'root';
            $password = ''; // uprav dle potřeby
            $dbname = 'projektv3';

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die('Connection failed: ' . $conn->connect_error);
            }

            // Přepsání názvu obrázku v tabulce admin, řádek s id 1
            $stmt = $conn->prepare('UPDATE admin SET picture_name = ? WHERE id = 1');
            $stmt->bind_param('s', $fileName);
            if ($stmt->execute()) {
                echo '✅ Obrázek byl úspěšně aktualizován.';
            } else {
                echo '❌ Chyba při aktualizaci obrázku.';
            }
            
            $stmt->close();
            $conn->close();
        } else {
            echo '❌ Chyba při nahrávání obrázku.';
        }
    } else {
        echo '❌ Nepovolený formát souboru. Nahrávejte pouze obrázky (jpg, jpeg, png, gif, webp).';
    }
}
?>
