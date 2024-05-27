<?php
session_start();

// untuk memeriksa apakah pengguna sudah login. Jika tidak, arahkan ke halaman login.
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php'); 
    exit();
}

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Latihan Gym</title>
    <link rel="stylesheet" href="hasil-latihan.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
        }
        .navbar-brand {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 18px;
        }
        .navbar-nav {
            float: right;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .navbar-nav li {
            float: left;
        }
        .navbar-nav .nav-link {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar-nav .nav-link:hover {
            background-color: #575757;
        }
        main {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="#" class="navbar-brand">Hasil Latihan Gym</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="rencana.php" class="nav-link">Rencana Latihan</a>
            </li>
            <li class="nav-item">
                <a href="hasil.php" class="nav-link">Hasil Latihan</a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="nav-link">Logout</a>
            </li>
        </ul>
    </nav>
    <main>
        <h1>Hasil Latihan</h1>
        <table>
            <thead>
                <tr>
                    <th>Rencana ID</th>
                    <th>Nama Latihan</th>
                    <th>Deskripsi</th>
                    <th>Durasi</th>
                    <th>Level Kesulitan</th>
                    <th>Hasil</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($hasilLatihan as $hasil): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($hasil['rencanaID']); ?></td>
                        <td><?php echo htmlspecialchars($hasil['namaLatihan']); ?></td>
                        <td><?php echo htmlspecialchars($hasil['deskripsi']); ?></td>
                        <td><?php echo htmlspecialchars($hasil['durasi']); ?></td>
                        <td><?php echo htmlspecialchars($hasil['levelKesulitan']); ?></td>
                        <td><?php echo htmlspecialchars($hasil['hasil']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
