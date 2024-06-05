<?php
// Database
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'flashgym';

// Konek ke database
$conn = new mysqli($host, $user, $pass, $db);

// cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// CRUD 

// Tambah
function tambahPeralatan($nama, $jenis, $jumlah, $kondisi, $conn) {
    $sql = "INSERT INTO peralatan (nama, jenis, jumlah, kondisi) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $nama, $jenis, $jumlah, $kondisi);
    $stmt->execute();
    $stmt->close();
}

// Ambil semua Peralatan
function semuaPeralatan($conn) {
    $sql = "SELECT * FROM peralatan";
    $result = $conn->query($sql);
    $peralatan = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $peralatan[] = $row;
        }
    }
    return $peralatan;
}

// Hapus
function hapusPeralatan($id, $conn) {
    $sql = "DELETE FROM peralatan WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Ubah 
function ubahPeralatan($id, $nama, $jenis, $jumlah, $kondisi, $conn) {
    $sql = "UPDATE peralatan SET nama=?, jenis=?, jumlah=?, kondisi=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $nama, $jenis, $jumlah, $kondisi, $id);
    $stmt->execute();
    $stmt->close();
}

// Menampilkkan satu Peralatan berdasarkan ID
function satuPeralatan($id, $conn) {
    $sql = "SELECT * FROM peralatan WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $peralatan = $result->fetch_assoc();
    $stmt->close();
    return $peralatan;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menambah Peralatan
    if (isset($_POST['tambah'])) {
        tambahPeralatan($_POST['nama'], $_POST['jenis'], $_POST['jumlah'], $_POST['kondisi'], $conn);
    }
    // Menghapus Peralatan
    elseif (isset($_POST['hapus'])) {
        hapusPeralatan($_POST['id'], $conn);
    }
    // Mengubah Peralatan
    elseif (isset($_POST['ubah'])) {
        // Periksa apakah data yang diperlukan ada
        if (isset($_POST['id'], $_POST['nama'], $_POST['jenis'], $_POST['jumlah'], $_POST['kondisi'])) {
            $id = $_POST['id'];
            $nama = $_POST['nama'];
            $jenis = $_POST['jenis'];
            $jumlah = $_POST['jumlah'];
            $kondisi = $_POST['kondisi'];
            ubahPeralatan($id, $nama, $jenis, $jumlah, $kondisi, $conn);
        }
    }
}

// Tampilkan semua Peralatan
$peralatan = semuaPeralatan($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Peralatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
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
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            padding: 10px 20px;
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
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .action-btns {
            display: flex;
            gap: 10px;
        }
        .action-btns form {
            margin: 0;
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

<?php
// Periksa apakah ada peralatan yang akan diedit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $peralatanEdit = satuPeralatan($id, $conn);
}
?>

<?php if (isset($peralatanEdit)) : ?>
    <h2>Ubah Peralatan</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?= $peralatanEdit['id']; ?>">
        <label for="nama">Nama Peralatan:</label>
        <input type="text" id="nama" name="nama" value="<?= $peralatanEdit['nama']; ?>" required>
        <label for="jenis">Jenis:</label>
        <input type="text" id="jenis" name="jenis" value="<?= $peralatanEdit['jenis']; ?>" required>
        <label for="jumlah">Jumlah:</label>
        <input type="number" id="jumlah" name="jumlah" value="<?= $peralatanEdit['jumlah']; ?>" required>
        <label for="kondisi">Kondisi:</label>
        <select id="kondisi" name="kondisi" required>
            <option value="Baik" <?= $peralatanEdit['kondisi'] == 'Baik' ? 'selected' : ''; ?>>Baik</option>
            <option value="Rusak" <?= $peralatanEdit['kondisi'] == 'Rusak' ? 'selected' : ''; ?>>Rusak</option>
        </select>
        <button type="submit" name="ubah">Ubah Peralatan</button>
    </form>
<?php else : ?>
    <h2>Tambah Peralatan</h2>
    <form method="post">
        <label for="nama">Nama Peralatan:</label>
        <input type="text" id="nama" name="nama" required>
        <label for="jenis">Jenis:</label>
        <input type="text" id="jenis" name="jenis" required>
        <label for="jumlah">Jumlah:</label>
        <input type="number" id="jumlah" name="jumlah" required>
        <label for="kondisi">Kondisi:</label>
        <select id="kondisi" name="kondisi" required>
            <option value="Baik">Baik</option>
            <option value="Rusak">Rusak</option>
        </select>
        <button type="submit" name="tambah">Tambah Peralatan</button>
    </form>
<?php endif; ?>

<h2>Daftar Peralatan</h2>
<form method="post" action="generate_pdf.php">
    <button type="submit">Unduh Laporan PDF</button>
</form>
<table border="2">
    <tr>
        <th>Nama</th>
        <th>Jenis</th>
        <th>Jumlah</th>
        <th>Kondisi</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($peralatan as $p) : ?>
        <tr>
            <td><?= $p['nama']; ?></td>
            <td><?= $p['jenis']; ?></td>
            <td><?= $p['jumlah']; ?></td>
            <td><?= $p['kondisi']; ?></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $p['id']; ?>">
                    <button type="submit" name="hapus">Hapus</button>
                </form>
                <a href="?edit=<?= $p['id']; ?>"><button type="submit">Ubah</button></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
