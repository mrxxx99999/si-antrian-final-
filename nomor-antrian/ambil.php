<?php
$jenis = $_GET['jenis'] ?? '';

// Validasi input jenis layanan
if (!in_array($jenis, ['konsultasi', 'permintaan'])) {
  header("Location: ../index.php"); // Kembali ke halaman utama
  exit;
}

// Penyesuaian tampilan berdasarkan jenis
$judul = $jenis === 'konsultasi' ? 'Konsultasi' : 'Permintaan Data';
$icon  = $jenis === 'konsultasi' ? 'bi-chat-dots-fill' : 'bi-search';
$warna = $jenis === 'konsultasi' ? 'success' : 'primary';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Ambil Nomor - <?= $judul ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #f8f9fa, #e9ecef);
    }
    .card {
      border-radius: 1rem;
      border: none;
    }
    .icon-box {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background-color: rgba(0, 0, 0, 0.05);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      margin: 0 auto 1rem;
    }
  </style>
</head>
<body>

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <!-- Header -->
        <div class="text-center mb-4">
          <div class="icon-box text-<?= $warna ?>">
            <i class="bi <?= $icon ?>"></i>
          </div>
          <h3 class="fw-bold">Form Ambil Nomor</h3>
          <p class="text-muted mb-1">Layanan: <strong><?= $judul ?></strong></p>
        </div>

        <!-- Form Ambil Nomor -->
        <div class="card shadow-sm">
          <div class="card-body p-4">
            <form method="POST" action="insert.php">
              <input type="hidden" name="jenis" value="<?= htmlspecialchars($jenis) ?>">

              <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama Anda" required>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-<?= $warna ?> btn-lg">
                  <i class="bi bi-person-plus-fill me-2"></i> Ambil Nomor
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Link kembali -->
        <div class="text-center mt-4">
          <a href="../index.php" class="text-decoration-none small">&larr; Kembali ke halaman utama</a>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
