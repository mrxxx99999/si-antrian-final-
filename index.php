<?php session_start(); ?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <title>Aplikasi Antrian</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
  <style>
    body {
      background: linear-gradient(to right, #f8f9fa, #e9ecef);
      font-family: 'Segoe UI', sans-serif;
    }

    .service-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .service-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .icon-circle {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8rem;
      margin: 0 auto 1rem;
    }
    .navbar-brand img {
      height: 35px;          
      width: auto;            
      margin-right: 10px;     
      vertical-align: middle; 
    }
  </style>
</head>

<body>

 <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-success d-flex align-items-center" href="index.php">
      <img src="assets/img/bps.png" alt="BPS Logo">
      <span class="ms-2">Aplikasi Antrian</span>
    </a>

    <div class="ms-auto">
      <?php if (isset($_SESSION['admin'])): ?>
        <a href="logout.php" class="btn btn-outline-danger">Logout</a>
      <?php else: ?>
        <a href="login.php" class="btn btn-outline-success" target="_blank">Login Admin</a>
      <?php endif; ?>
    </div>

  </div>
</nav>


  <!-- Main Content -->
  <div class="container py-5">
    <div class="text-center mb-5">
      <h2 class="fw-bold mb-2">Selamat Datang</h2>
      <p class="text-muted">Silakan pilih jenis layanan yang Anda butuhkan</p>
    </div>

    <div class="row justify-content-center">
      <!-- Konsultasi -->
      <div class="col-md-5 col-lg-4 mb-4">
        <div class="card text-center service-card border-0 shadow-sm">
          <div class="card-body p-4">
            <div class="icon-circle bg-success text-white mb-3">
              <i class="bi bi-chat-dots-fill"></i>
            </div>
            <h4 class="card-title">Konsultasi</h4>
            <p class="card-text text-muted">Layanan konsultasi dengan petugas atau staf terkait.</p>
            <a href="nomor-antrian/ambil.php?jenis=konsultasi" class="btn btn-success w-100">
              Ambil Nomor
            </a>
          </div>
        </div>
      </div>

      <!-- Pencarian Data -->
      <div class="col-md-5 col-lg-4 mb-4">
        <div class="card text-center service-card border-0 shadow-sm">
          <div class="card-body p-4">
            <div class="icon-circle bg-primary text-white mb-3">
              <i class="bi bi-folder2-open"></i>
            </div>
            <h4 class="card-title">Permintaan Data</h4>
            <p class="card-text text-muted">Layanan untuk mencari atau verifikasi data yang tersedia.</p>
            <a href="nomor-antrian/ambil.php?jenis=permintaan" class="btn btn-primary w-100">
              Ambil Nomor
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="text-center py-4 small text-muted">
    &copy; <?= date('Y') ?> Aplikasi Antrian. Marthin Juan.
  </footer>

</body>

</html>
