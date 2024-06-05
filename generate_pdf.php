<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;

// Konfigurasi Database
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

// Mengambil data peralatan
$peralatan = semuaPeralatan($conn);

// Membuat HTML untuk PDF
$html = '<h1>Daftar Peralatan</h1>
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Kondisi</th>
                </tr>
            </thead>
            <tbody>';

foreach ($peralatan as $p) {
    $html .= '<tr>
                <td>' . $p['nama'] . '</td>
                <td>' . $p['jenis'] . '</td>
                <td>' . $p['jumlah'] . '</td>
                <td>' . $p['kondisi'] . '</td>
              </tr>';
}

$html .= '</tbody></table>';

// Membuat instance Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Opsional) Mengatur ukuran kertas dan orientasi
$dompdf->setPaper('A4', 'landscape');

// Merender HTML ke PDF
$dompdf->render();

// Mengirimkan file PDF ke browser
$dompdf->stream("laporan_peralatan.pdf", array("Attachment" => 0));
?>
