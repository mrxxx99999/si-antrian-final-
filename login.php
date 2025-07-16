<?php
session_start();
require 'config/database.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ? AND role = 'admin'");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
      $_SESSION['admin'] = $user['username'];
      header("Location: panggilan-antrian/index.php");
      exit;
    } else {
      $error = "Password salah.";
    }
  } else {
    $error = "Akun admin tidak ditemukan.";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow-sm">
          <div class="card-body">
            <h4 class="text-center mb-4">Login Admin</h4>
            <?php if ($error): ?>
              <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
              </div>
              <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
              </div>
              <button class="btn btn-success w-100">Login</button>
            </form>

            <!-- Tambahan tombol register -->
            <div class="text-center mt-3">
              <span class="text-muted">Belum punya akun?</span><br>
              <a href="register.php" class="btn btn-outline-primary mt-2 w-100">Daftar Admin</a>
            </div>
          </div>
        </div>

        <div class="text-center mt-3">
          <a href="index.php" class="text-decoration-none">&larr; Kembali ke halaman utama</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
