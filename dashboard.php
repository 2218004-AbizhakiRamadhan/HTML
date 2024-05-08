<?php
session_start();

// memeriksa apakah user sudah login. Jika tidak, arahkan ke halaman login.
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php'); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.navbar {
    background-color: #333;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar-brand {
    color: #fff;
    text-decoration: none;
    font-size: 24px;
}

.navbar-nav {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
}

.nav-item {
    margin-left: 20px;
}

.nav-link {
    color: #fff;
    text-decoration: none;
    font-size: 18px;
}

.nav-link:hover {
    text-decoration: underline;
}

.content {
    padding: 20px;
}

.content h2 {
    color: #333;
}

.content p {
    color: #666;
}
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="#" class="navbar-brand">FLASH GYM</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="rencana.php" class="nav-link">Rencana Latihan</a>
            </li>
            <li class="nav-item">
                <a href="hasil-latihan.php" class="nav-link">Hasil Latihan</a>
            </li>
            <li class="nav-item">
                <a href="Logout.php" class="nav-link">Logout</a>
            </li>
        </ul>
    </nav>
    <div class="content">
        <h2>Selamat Datang</h2>
        <p>Ini adalah halaman dashboard untuk Rencana Latihan Gym.</p>
        <p>ISI MASI DALAM PROSES</p>
    </div>
</body>
</html>
