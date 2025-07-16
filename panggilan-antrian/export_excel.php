<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: ../login.php");
  exit;
}

require '../config/database.php';

// Ambil filter
$dari   = $_GET['dari'] ?? date('Y-m-d');
$sampai = $_GET['sampai'] ?? date('Y-m-d');
$jenis  = $_GET['jenis'] ?? '';

// Set headers untuk Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Antrian_{$dari}_sampai_{$sampai}.xls");

// Query data
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

// Output HTML sebagai isi file Excel
echo "<table border='1'>";
echo "<tr>
        <th>No</th>
        <th>Nama</th>
        <th>No Antrian</th>
        <th>Jenis Layanan</th>
        <th>Status</th>
        <th>Tanggal</th>
        <th>Waktu</th>
      </tr>";

$no = 1;
while ($row = $result->fetch_assoc()) {
  echo "<tr>";
  echo "<td>" . $no++ . "</td>";
  echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
  echo "<td>" . $row['no_antrian'] . "</td>";
  echo "<td>" . ucfirst($row['jenis_antrian']) . "</td>";
  echo "<td>" . ($row['status'] == '1' ? 'Dipanggil' : 'Menunggu') . "</td>";
  echo "<td>" . $row['tanggal'] . "</td>";
  echo "<td>" . ($row['updated_date'] ?? '-') . "</td>";
  echo "</tr>";
}
echo "</table>";
?>
