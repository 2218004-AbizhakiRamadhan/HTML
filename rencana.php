<?php
session_start();

// untuk memeriksa apakah pengguna sudah login. Jika tidak, arahkan ke halaman login.
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
    <title>Rencana Latihan Gym</title>
    <link rel="stylesheet" href="rencana.css">
</head>
<body>
    <nav class="navbar">
        <a href="#" class="navbar-brand">Rencana Latihan Gym</a>
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
                <a href="Login.php" class="nav-link">Logout</a>
            </li>
        </ul>
    </nav>
    <main>
        <form id="gymForm">
            <table>
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Latihan</th>
                        <th>Sets</th>
                        <th>Reps</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="day1" placeholder="Hari"></td>
                        <td><input type="text" name="exercise1" placeholder="Latihan"></td>
                        <td><input type="text" name="sets1" placeholder="Sets"></td>
                        <td><input type="text" name="reps1" placeholder="Reps"></td>
                    </tr>
                </tbody>
            </table>
            <button type="submit">Simpan</button>
        </form>
    </main>
</body>
</html>
