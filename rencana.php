<?php
// Database Configuration
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'flashgym';

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// CRUD Operations

// Tambah Rencana
function tambahRencana($nama, $deskripsi, $durasi, $level, $conn) {
    $sql = "INSERT INTO rencana (nama, deskripsi, durasi, level_kesulitan) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $nama, $deskripsi, $durasi, $level);
    $stmt->execute();
    $stmt->close();
}

// Ambil semua Rencana
function semuaRencana($conn) {
    $sql = "SELECT * FROM rencana";
    $result = $conn->query($sql);
    $rencana = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rencana[] = $row;
        }
    }
    return $rencana;
}

// Hapus Rencana
function hapusRencana($id, $conn) {
    $sql = "DELETE FROM rencana WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Ubah Rencana
function ubahRencana($id, $nama, $deskripsi, $durasi, $level, $conn) {
    $sql = "UPDATE rencana SET nama=?, deskripsi=?, durasi=?, level_kesulitan=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $nama, $deskripsi, $durasi, $level, $id);
    $stmt->execute();
    $stmt->close();
}

// Mendapatkan satu Rencana berdasarkan ID
function satuRencana($id, $conn) {
    $sql = "SELECT * FROM rencana WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rencana = $result->fetch_assoc();
    $stmt->close();
    return $rencana;
}

// Handler untuk POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menambah Rencana
    if (isset($_POST['tambah'])) {
        tambahRencana($_POST['nama'], $_POST['deskripsi'], $_POST['durasi'], $_POST['level'], $conn);
    }
    // Menghapus Rencana
    elseif (isset($_POST['hapus'])) {
        hapusRencana($_POST['id'], $conn);
    }
    // Mengubah Rencana
    elseif (isset($_POST['ubah'])) {
        if (isset($_POST['id'], $_POST['nama'], $_POST['deskripsi'], $_POST['durasi'], $_POST['level'])) {
            $id = $_POST['id'];
            $nama = $_POST['nama'];
            $deskripsi = $_POST['deskripsi'];
            $durasi = $_POST['durasi'];
            $level = $_POST['level'];
            ubahRencana($id, $nama, $deskripsi, $durasi, $level, $conn);
        }
    }
}

// Mendapatkan data rencana untuk form edit jika ada parameter id
$editRencana = null;
if (isset($_GET['edit'])) {
    $editRencana = satuRencana($_GET['edit'], $conn);
}

// Tampilkan semua Rencana
$rencana = semuaRencana($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rencana CRUD</title>
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
        h1, h2 {
            text-align: center;
        }
        form {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        textarea,
        input[type="number"],
        select {
            width: 100%;
            padding: 5px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button[type="submit"] {
            padding: 8px 20px;
            border: none;
            border-radius: 3px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background-color: #f5f5f5;
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
            <a href="peralatan.php" class="nav-link">Peralatan</a>
        </li>
        <li class="nav-item">
            <a href="logout.php" class="nav-link">Logout</a>
        </li>
    </ul>
</nav>

<?php if ($editRencana): ?>
    <h2>Edit Rencana</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?= $editRencana['id']; ?>">
        <label for="nama">Nama Rencana:</label><br>
        <input type="text" id="nama" name="nama" value="<?= $editRencana['nama']; ?>" required><br>
        <label for="deskripsi">Deskripsi:</label><br>
        <textarea id="deskripsi" name="deskripsi" required><?= $editRencana['deskripsi']; ?></textarea><br>
        <label for="durasi">Durasi (hari):</label><br>
        <input type="number" id="durasi" name="durasi" value="<?= $editRencana['durasi']; ?>" required><br>
        <label for="level">Level Kesulitan:</label><br>
        <select id="level" name="level" required>
            <option value="Mudah" <?= $editRencana['level_kesulitan'] == 'Mudah' ? 'selected' : ''; ?>>Mudah</option>
            <option value="Sedang" <?= $editRencana['level_kesulitan'] == 'Sedang' ? 'selected' : ''; ?>>Sedang</option>
            <option value="Sulit" <?= $editRencana['level_kesulitan'] == 'Sulit' ? 'selected' : ''; ?>>Sulit</option>
        </select><br><br>
        <button type="submit" name="ubah">Ubah Rencana</button>
    </form>
<?php else: ?>
    <h2>Tambah Rencana</h2>
    <form method="post">
        <label for="nama">Nama Rencana:</label><br>
        <input type="text" id="nama" name="nama" required><br>
        <label for="deskripsi">Deskripsi:</label><br>
        <textarea id="deskripsi" name="deskripsi" required></textarea><br>
        <label for="durasi">Durasi (hari):</label><br>
        <input type="number" id="durasi" name="durasi" required><br>
        <label for="level">Level Kesulitan:</label><br>
        <select id="level" name="level" required>
            <option value="Mudah">Mudah</option>
            <option value="Sedang">Sedang</option>
            <option value="Sulit">Sulit</option>
        </select><br><br>
        <button type="submit" name="tambah">Tambah Rencana</button>
    </form>
<?php endif; ?>

<h2>Daftar Rencana</h2>
<table border="2">
    <tr>
        <th>Nama</th>
        <th>Deskripsi</th>
        <th>Durasi (hari)</th>
        <th>Level Kesulitan</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($rencana as $r) : ?>
        <tr>
            <td><?= $r['nama']; ?></td>
            <td><?= $r['deskripsi']; ?></td>
            <td><?= $r['durasi']; ?></td>
            <td><?= $r['level_kesulitan']; ?></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $r['id']; ?>">
                    <button type="submit" name="hapus">Hapus</button>
                </form>
                <a href="?edit=<?= $r['id']; ?>"><button type="submit">Ubah</button></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>