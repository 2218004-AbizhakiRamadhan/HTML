<?php
session_start();

// memeriksa apakah user sudah login. Jika tidak, arahkan ke halaman login.
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php'); 
    exit();
}

// Ambil nama pengguna dari sesi
$username = $_SESSION['username'];
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
            color: white;
            text-decoration: none;
            font-size: 24px;
        }
        .navbar-nav {
            list-style: none;
            margin: 0;
            padding: 0;
            float: right;
            padding-right: 20px;
        }
        .nav-item {
            display: inline-block;
            margin-right: 10px;
        }
        .nav-link {
            color: white;
            text-decoration: none;
            font-size: 18px;
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
        .widget {
            padding: 30px;
            text-align: center;
            margin-top: 5px;
            float: right; 
        }
        .widget2 {
            padding: 20px;
            margin-top: 5px;
        }
        .widget h3 {
            margin-top: 0;
        }
        .widget .time {
            font-size: 24px;
            font-weight: bold;
        }
    </style>
    <script>
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString();
            document.getElementById('time').textContent = timeString;
        }

        function updateWeather() {
            fetch('https://api.open-meteo.com/v1/forecast?latitude=-6.2&longitude=106.816&current_weather=true')
                .then(response => response.json())
                .then(data => {
                    const weather = data.current_weather;
                    const weatherString = `Temperatur: ${weather.temperature}°C, Kecepatan Angin: ${weather.windspeed} km/h`;
                    document.getElementById('weather').textContent = weatherString;
                })
                .catch(error => {
                    console.error('Error fetching weather data:', error);
                    document.getElementById('weather').textContent = 'Unable to fetch weather data.';
                });
        }

        window.onload = function() {
            updateTime();
            setInterval(updateTime, 1000);
            updateWeather();
        };
    </script>
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
                <a href="peralatan.php" class="nav-link">Peralatan</a>
            </li>
            <li class="nav-item">
                <a href="Logout.php" class="nav-link">Logout</a>
            </li>
        </ul>
    </nav>
    <div class="widget">
            <h3>Waktu Sekarang</h3>
            <div class="time" id="time"></div>
        </div>
    <div class="content">
    <h2>Halo,<?= htmlspecialchars($username); ?>!</h2>
    <h2>Mau Latihan Apa Hari Ini ?</h2>
    </div>
    <div class="widget2">
            <h3>Cuaca Hari Ini</h3>
            <div id="weather"></div>
    </div>
</body>
</html>