<?php
require 'config/database.php';
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $role = 'admin'; // otomatis admin

  $stmt = $mysqli->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $username, $password, $role);

  if ($stmt->execute()) {
    // Redirect ke halaman login
    header("Location: login.php");
    exit;
  } else {
    $message = "Registrasi gagal: " . $stmt->error;
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Registrasi Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #f8f9fa, #e9ecef);
    }
    .card {
      border: none;
      border-radius: 1rem;
    }
    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
    }
  </style>
</head>
<link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">

<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="text-center mb-4">
          <i class="bi bi-person-plus-fill text-success" style="font-size: 3rem;"></i>
          <h3 class="mt-2">Registrasi Admin</h3>
          <p class="text-muted">Silakan isi untuk membuat akun admin</p>
        </div>

        <div class="card shadow-sm">
          <div class="card-body p-4">
            <?php if ($message): ?>
              <div class="alert alert-danger text-center"><?= $message ?></div>
            <?php endif; ?>

            <form method="POST">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                  <input type="text" name="username" id="username" class="form-control" required>
                </div>
              </div>

              <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                  <input type="password" name="password" id="password" class="form-control" required>
                </div>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-success">Daftar</button>
              </div>

              <div class="text-center mt-3">
                Sudah punya akun? <a href="login.php" class="text-decoration-none">Login di sini</a>
              </div>
            </form>
          </div>
        </div>

        <div class="text-center mt-4">
          <a href="index.php" class="text-decoration-none small">&larr; Kembali ke halaman utama</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
