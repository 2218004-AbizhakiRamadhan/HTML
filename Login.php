<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="image tugas/logo flash.png" />
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            background-image: url('login.jpg'); 
            background-size: cover; 
            background-position: center; 
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .content {
            background-color: #fff;
            padding: 100px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
        }

        form {
            margin-top: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc; 
            border-radius: 5px;
        }

        input:focus {
            border-color: #007bff; 
        }

        button {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #555;
        }

        nav {
            margin-top: 10px;
        }

        nav span {
            color: #333;
        }

        nav a {
            color: #007bff;
            text-decoration: none;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .popup-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            border: 2px solid #007bff; 
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <?php
    session_start(); 
    
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "flashgym";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        // Query ke database untuk mengambil data pengguna
        $stmt = $conn->prepare("SELECT id, username, password FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Verifikasi password
            if (password_verify($password, $row['password'])) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                // Redirect ke halaman dashboard atau tampilkan pesan berhasil
                echo "<script>alert('Login berhasil!'); window.location.href = 'dashboard.php';</script>";
                exit();
            } else {
                echo "<script>alert('Username atau password salah!');</script>";
            }
        } else {
            echo "<script>alert('Username atau password salah!');</script>";
        }
    }
    
    $conn->close();    
    // Logout dari sesi
    if (isset($_GET['action']) && $_GET['action'] == 'logout') {
        session_destroy();
        echo "<script>alert('Logout berhasil!'); window.location.href = 'login.php';</script>";
    }
    ?>
    <div class="container">
        <div class="content">
            <h1>LOGIN FLASH GYM</h1>
            <p>Sudah Siap Angkat Beban?</p>
            <form action="" method="post" onsubmit="return validateForm()">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <p></p>
            <nav>
                <span>Lupa Password?</span> <a href="javascript:void(0)" onclick="openRecoveryPopup()">Recovery</a>
            </nav>
            <p></p>
            <nav>
                <span>Buat Member</span> <a href="Register.php" class="register">Register</a>
            </nav>
        </div>
    </div>

    <!-- Popup untuk Lupa Password -->
    <div class="popup" id="recoveryPopup">
        <div class="popup-content">
            <span class="close-btn" onclick="closeRecoveryPopup()">x</span>
            <h2>Lupa Password</h2>
            <p>Masukkan alamat email Anda untuk mengatur ulang kata sandi.</p>
            <input type="email" id="recoveryEmail" placeholder="Alamat Email" required>
            <button type="button" onclick="resetPassword()">Kirim</button>
        </div>
    </div>

    <script>
        function validateForm() {
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;

            if (username === '' || password === '') {
                document.getElementById('popup').style.display = 'block';
                return false; 
            }

            localStorage.setItem('username', username);
            localStorage.setItem('password', password);

            return true; 
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
        }

        function openRecoveryPopup() {
            document.getElementById('recoveryPopup').style.display = 'block';
        }

        function closeRecoveryPopup() {
            var recoveryPopup = document.getElementById('recoveryPopup');
            recoveryPopup.style.animation = 'fadeOut 0.5s ease'; 
            setTimeout(function () {
                recoveryPopup.style.display = 'none';
                recoveryPopup.style.animation = ''; 
            }, 500); 
        }

        function resetPassword() {
            // Logika untuk mengatur ulang kata sandi
            var email = document.getElementById('recoveryEmail').value;
            alert('Instruksi reset password telah dikirim ke ' + email);
        }

        window.onload = function () {
            var storedUsername = localStorage.getItem('username');
            var storedPassword = localStorage.getItem('password');
            if (storedUsername && storedPassword) {
                document.getElementById('username').value = storedUsername;
                document.getElementById('password').value = storedPassword;
            }
        };
    </script>
</body>
</html>