<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="image tugas/logo flash.png" />
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            background-image: url('login.jpg');
            background-size: cover;
        }

        p {
            text-align: center;
        }

        div.container {
            margin: 20px auto;
            max-width: 60%;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #f2f2f2;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 2px solid #030303;
            border-radius: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            display: block;
            margin: 20px auto;
        }

        button:hover {
            background-color: #555;
        }

        /* animasi Popup box */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.3s ease forwards, slideIn 0.3s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translate(-50%, -70%);
            }

            to {
                transform: translate(-50%, -50%);
            }
        }

        @media (max-width: 768px) {
            div.container {
                max-width: 90%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Register</h1>
        <p>Silahkan Masukkan Data Diri Anda</p>
        <form id="registrationForm" method="post" action="register.php">
            <table>
                <tbody>
                    <tr>
                        <th>Username</th>
                        <td><input type="text" id="username" name="username" placeholder="Masukkan Nama" required /></td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td><input type="password" id="password" name="password" placeholder="Password Harus di buat" required /></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><input type="email" id="email" name="email" placeholder="Masukkan Email" required /></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" onclick="validateForm()">Daftar</button>
        </form>
    </div>

    <!-- Pop-up box -->
    <div id="popup" class="popup">
        <p>Semua data formulir harus diisi!</p>
        <button onclick="closePopup()">Tutup</button>
    </div>
    <div id="successPopup" class="popup">
        <p>Formulir berhasil diisi! Data Anda akan segera diproses.</p>
        <button onclick="closeSuccessPopup()">Tutup</button>
    </div>

    <script>
        function validateForm() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            var email = document.getElementById("email").value;

            if (username === '' || password === '' || email === '') {
                document.getElementById("popup").style.display = "block";
            } else {
                document.getElementById("registrationForm").submit();
            }
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }

        function closeSuccessPopup() {
            document.getElementById("successPopup").style.display = "none";
        }
    </script>
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (!empty($username) && !empty($password) && !empty($email)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $dbname = "flashgym";

        // Membuat koneksi ke database
        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        // Memeriksa koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Menyiapkan statement SQL untuk memasukkan data ke tabel pengguna
        $stmt = $conn->prepare("INSERT INTO user (username, password, email) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die("Error prepare: " . $conn->error);
        }

        $bind = $stmt->bind_param("sss", $username, $hashed_password, $email);
        if ($bind === false) {
            die("Error bind_param: " . $stmt->error);
        }

        $exec = $stmt->execute();
        if ($exec) {
            echo "<script>
                    alert('Welcome to Flash GYM');
                    window.location.href = 'Login.php';
                  </script>";
        } else {
            die("Error execute: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<script>
                document.getElementById('popup').style.display = 'block';
              </script>";
    }
}
?>

</body>

</html>
