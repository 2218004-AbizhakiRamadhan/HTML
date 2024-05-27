<?php
$servername = "localhost";
$db_username = "root";
$db_password = ""; // 
$dbname = "flashgym";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("aduh koneksi gagal bang, ga done dong: " . $conn->connect_error);
} else {
    echo "Koneksi berhasil! bang, done";
}

$conn->close();
?>