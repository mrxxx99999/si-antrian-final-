<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: ../login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Filter Laporan Antrian</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h4 class="mb-4 text-center">Filter Laporan Antrian</h4>

    <div class="card shadow-sm">
      <div class="card-body">
        <form action="" method="get" id="formLaporan" target="_blank">
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="dari" class="form-label">Dari Tanggal</label>
              <input type="date" name="dari" id="dari" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="sampai" class="form-label">Sampai Tanggal</label>
              <input type="date" name="sampai" id="sampai" class="form-control" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="jenis" class="form-label">Jenis Layanan</label>
            <select name="jenis" id="jenis" class="form-select">
              <option value="">Semua</option>
              <option value="konsultasi">Konsultasi</option>
              <option value="permintaan">Permintaan Data</option>
            </select>
          </div>

          <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
             <button type="button" class="btn btn-outline-danger" onclick="submitForm('export_pdf.php')">
                 <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF
            </button>
            
            <button type="button" class="btn btn-outline-success" onclick="submitForm('export_excel.php')">
              <i class="bi bi-file-earmark-excel-fill me-1"></i> Export Excel
            </button>
          </div>
        </form>
      </div>
    </div>

    <div class="text-center mt-3">
      <a href="index.php" class="text-decoration-none">&larr; Kembali ke dashboard</a>
    </div>
  </div>

  <script>
    function submitForm(actionUrl) {
      const form = document.getElementById('formLaporan');
      form.action = actionUrl;
      form.submit();
    }
  </script>
</body>
</html>
