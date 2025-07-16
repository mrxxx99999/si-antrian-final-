<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: ../login.php");
  exit;
}

require '../config/database.php';

// Ambil filter dari GET
$dari   = $_GET['dari'] ?? date('Y-m-d');
$sampai = $_GET['sampai'] ?? date('Y-m-d');
$jenis  = $_GET['jenis'] ?? '';

// Query dasar
$sql = "SELECT * FROM tbl_antrian WHERE tanggal BETWEEN ? AND ?";
$params = [$dari, $sampai];
$types = "ss";

// Tambahkan filter jenis jika dipilih
if (!empty($jenis)) {
  $sql .= " AND jenis_antrian = ?";
  $params[] = $jenis;
  $types .= "s";
}

$sql .= " ORDER BY tanggal ASC, no_antrian ASC";

// Prepare dan execute
$stmt = $mysqli->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Antrian</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    @media print {
      .no-print { display: none; }
    }
  </style>
</head>
<body onload="window.print()">
  <div class="container mt-4">
    <h4 class="text-center">Laporan Antrian</h4>
    <p class="text-center text-muted">
      Tanggal: <?= date('d M Y', strtotime($dari)) ?> s.d. <?= date('d M Y', strtotime($sampai)) ?><br>
      <?= !empty($jenis) ? "Jenis Layanan: <strong>" . ucfirst($jenis) . "</strong>" : "Semua Jenis Layanan" ?>
    </p>

    <table class="table table-bordered table-striped mt-4">
      <thead class="table-secondary">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>No Antrian</th>
          <th>Jenis Layanan</th>
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

    <div class="text-center mt-5 no-print">
      <a href="form_laporan.php" class="btn btn-secondary">Kembali</a>
    </div>
  </div>
</body>
</html>
