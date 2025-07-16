<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: ../login.php");
  exit;
}

require_once '../dompdf/autoload.inc.php'; // ← sesuaikan path jika beda

use Dompdf\Dompdf;

require '../config/database.php';

$dari   = $_GET['dari'] ?? date('Y-m-d');
$sampai = $_GET['sampai'] ?? date('Y-m-d');
$jenis  = $_GET['jenis'] ?? '';

$sql = "SELECT * FROM tbl_antrian WHERE tanggal BETWEEN ? AND ?";
$params = [$dari, $sampai];
$types = "ss";

if (!empty($jenis)) {
  $sql .= " AND jenis_antrian = ?";
  $params[] = $jenis;
  $types .= "s";
}
$sql .= " ORDER BY tanggal ASC, no_antrian ASC";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// HTML laporan
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
  <style>
    body { font-family: sans-serif; font-size: 12px; }
    h3 { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 5px; text-align: center; }
  </style>
</head>
<body>
  <h3>Laporan Antrian</h3>
  <p style="text-align:center;">
    Tanggal: <?= date('d-m-Y', strtotime($dari)) ?> s.d <?= date('d-m-Y', strtotime($sampai)) ?><br>
    <?= !empty($jenis) ? "Jenis Layanan: <strong>" . ucfirst($jenis) . "</strong>" : "Semua Jenis Layanan" ?>
  </p>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>No Antrian</th>
        <th>Jenis</th>
        <th>Status</th>
        <th>Tanggal</th>
        <th>Waktu</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td><?= $row['no_antrian'] ?></td>
        <td><?= ucfirst($row['jenis_antrian']) ?></td>
        <td><?= $row['status'] == '1' ? 'Dipanggil' : 'Menunggu' ?></td>
        <td><?= $row['tanggal'] ?></td>
        <td><?= $row['updated_date'] ?? '-' ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
<?php
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("Laporan_Antrian_{$dari}_{$sampai}.pdf", ['Attachment' => 0]); // 0 = tampil di browser
exit;
