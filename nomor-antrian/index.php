<!doctype html>
<html lang="id" class="h-100">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nomor Antrian - Aplikasi Antrian</title>
  <meta name="description" content="Aplikasi Antrian Berbasis Web">
  <meta name="author" content="Marthin Juan">

  <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="d-flex flex-column h-100 bg-light">
  <main class="flex-shrink-0">
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-lg-6 mb-4">
          <div class="card shadow-sm border-0">
            <div class="card-body">
              <div class="text-center mb-4">
                <i class="bi bi-people-fill text-success fs-1"></i>
                <h3 class="mt-2">Ambil Nomor Antrian</h3>
              </div>

              <!-- Display nomor antrian terbaru -->
              <div class="text-center mb-4">
                <div class="border rounded-3 p-4 border-success">
                  <h4>Nomor Saat Ini</h4>
                  <h1 id="antrian" class="display-1 fw-bold text-success lh-1"></h1>
                </div>
              </div>

              <!-- Form input nama -->
              <form id="formAntrian">
                <div class="mb-3">
                  <label for="nama" class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama Anda" required>
                </div>
                <button type="submit" class="btn btn-success w-100">
                  <i class="bi bi-person-plus me-2"></i>Ambil Nomor
                </button>
              </form>

              <!-- Hasil tampil di sini -->
              <div id="hasil" class="mt-4"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="footer mt-auto py-3 bg-white">
    <div class="container text-center small text-muted">
      &copy; <?= date('Y') ?> - Aplikasi Antrian. Marthin Juan.
    </div>
  </footer>

  <!-- JS -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#antrian').load('get_antrian.php');

      $('#formAntrian').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
          type: 'POST',
          url: 'insert.php',
          data: $(this).serialize(),
          success: function (response) {
            $('#hasil').html(response);
            $('#formAntrian')[0].reset();
            $('#antrian').load('get_antrian.php');
          },
          error: function () {
            $('#hasil').html('<div class="alert alert-danger">Terjadi kesalahan saat mengirim data.</div>');
          }
        });
      });
    });
  </script>
</body>

</html>
