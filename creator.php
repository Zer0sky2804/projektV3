<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projektv3";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Připojení k databázi selhalo: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['blog-title']);
    $text = $conn->real_escape_string($_POST['blog-content']);
    $user_id = intval($_POST['user-id']);
    $nazev_obr = null;

    if (isset($_FILES['blog-image']) && $_FILES['blog-image']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['blog-image']['name']);
        $upload_dir = 'images/';
        $nazev_obr = $upload_dir . $image_name;
        move_uploaded_file($_FILES['blog-image']['tmp_name'], $nazev_obr);
    }

    $sql = "INSERT INTO blog (title, text, user_id, `nazev-obr`) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $title, $text, $user_id, $nazev_obr);

    if ($stmt->execute()) {
        echo "<script>alert('Článek byl úspěšně přidán.'); window.location.href = 'selector.php';</script>";
    } else {
        echo "<script>alert('Chyba při přidávání článku: " . $conn->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
