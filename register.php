<?php
$servername = "localhost";
$username = "root";
$password = "";
$databasename = "projektV3";

$conn = new mysqli($servername, $username, $password, $databasename);

if ($conn->connect_error) {
    die("Something went wrong. Please try again latter.: " . $conn->connect_error);
}

$password = $_POST["password"];
$email = $_POST["email"];
$nickname = $_POST["nickname"]; 

$password = mysqli_real_escape_string($conn, $password);
$email = mysqli_real_escape_string($conn, $email);
$nickname = mysqli_real_escape_string($conn, $nickname); 

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql_check_email = "SELECT * FROM users WHERE email = '$email'";
$result_check_email = $conn->query($sql_check_email);

$sql_check_nickname = "SELECT * FROM users WHERE nickname = '$nickname'";
$result_check_nickname = $conn->query($sql_check_nickname);

if ($result_check_email->num_rows > 0) {
    echo "<script> alert('Zadaný email je již registraván.') </script>";
} elseif ($result_check_nickname->num_rows > 0) {
    echo "<script> alert('Použijte jinou přezdívku.') </script>";
} else {
$sql = "INSERT INTO users (nickname, password, email) VALUES ('$nickname', '$hashed_password', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "<script> alert('Registrace proběhla úspěšně.') </script>";
    echo "<script> window.location.href = 'selector.html'; </script>";
    
} else {
    echo "<script> alert('Registrace se nezdařila.') </script>";
    echo "<script> window.location.href = 'selector.html'; </script>";
}
}
$conn->close();
?>
