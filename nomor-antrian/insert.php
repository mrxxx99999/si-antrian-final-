<?php
// koneksi ke database
require '../config/database.php';

// Ambil data dari form
$nama  = trim($_POST['nama'] ?? '');
$jenis = $_POST['jenis'] ?? '';

// Validasi input
if ($nama === '' || !in_array($jenis, ['konsultasi', 'permintaan'])) {
  die("<h4 class='text-danger text-center'>Data tidak valid.</h4>");
}

$tanggal = date('Y-m-d');

// Cek nomor antrian terakhir hari ini berdasarkan jenis
$q = $mysqli->prepare("SELECT MAX(no_antrian) AS max_nomor FROM tbl_antrian WHERE tanggal = ? AND jenis_antrian = ?");
$q->bind_param("ss", $tanggal, $jenis);
$q->execute();
$result = $q->get_result();
$fetch = $result->fetch_assoc();
$no_antrian = ($fetch['max_nomor'] ?? 0) + 1;

// Simpan data ke database
$stmt = $mysqli->prepare("INSERT INTO tbl_antrian (nama, jenis_antrian, tanggal, no_antrian) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $nama, $jenis, $tanggal, $no_antrian);

if ($stmt->execute()) {
  // Tampilkan hasil
  ?>
  <!doctype html>
  <html lang="id">
  <head>
    <meta charset="UTF-8">
    <title>Nomor Anda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
  </head>
  <body class="bg-light">
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-6 text-center">
          <div class="alert alert-success shadow-sm">
            <h4 class="mb-3">Nomor Antrian Anda</h4>
            <h1 class="display-1 fw-bold text-success"><?= $no_antrian ?></h1>
            <p class="lead">Layanan: <strong><?= ucfirst($jenis) ?></strong></p>
            <p>Nama: <strong><?= htmlspecialchars($nama) ?></strong></p>
          </div>
          <a href="../index.php" class="btn btn-outline-secondary mt-3">Kembali ke Halaman Utama</a>
        </div>
      </div>
    </div>
  </body>
  </html>
  <?php
} else {
  echo "<p class='text-danger text-center'>Gagal menyimpan data: " . $stmt->error . "</p>";
}
?>
