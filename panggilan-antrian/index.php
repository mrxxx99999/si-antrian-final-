<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: ../login.php");
  exit;
}
?>

<?php
require '../config/database.php';
$tanggal = date('Y-m-d');
$data = $mysqli->query("SELECT * FROM tbl_antrian WHERE tanggal = '$tanggal' ORDER BY no_antrian ASC");
?>

<!doctype html>
<html lang="id" class="h-100">

<head>
  <meta charset="utf-8">
  <title>Dashboard Admin - Panggilan Antrian</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Aplikasi Antrian Berbasis Web - Admin">
  <meta name="author" content="Marthin Juan">
  <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">

  <!-- Bootstrap & DataTables -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" rel="stylesheet">

  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="d-flex flex-column h-100 bg-light">

<main class="flex-shrink-0">
  <div class="container py-4">

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row px-4 py-3 mb-4 bg-white rounded-2 shadow-sm">
      <div class="d-flex align-items-center me-md-auto">
        <i class="bi-mic-fill text-success me-3 fs-3"></i>
        <h1 class="h5 pt-2 mb-0">Panggilan Antrian</h1>
      </div>
      <div class="pt-2">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#"><i class="bi-house-fill text-success"></i></a></li>
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item active">Antrian</li>
          </ol>
        </nav>
      </div>
    </div>

    <!-- Informasi Antrian -->
    <div class="row">
      <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0">
          <div class="card-body d-flex align-items-center">
            <i class="bi-people text-warning fs-2 me-3"></i>
            <div>
              <p id="jumlah-antrian" class="fs-4 fw-bold mb-0">0</p>
              <small class="text-muted">Jumlah Antrian</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0">
          <div class="card-body d-flex align-items-center">
            <i class="bi-person-check text-success fs-2 me-3"></i>
            <div>
              <p id="antrian-sekarang" class="fs-4 fw-bold mb-0">-</p>
              <small class="text-muted">Antrian Sekarang</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0">
          <div class="card-body d-flex align-items-center">
            <i class="bi-person-plus text-info fs-2 me-3"></i>
            <div>
              <p id="antrian-selanjutnya" class="fs-4 fw-bold mb-0">-</p>
              <small class="text-muted">Antrian Selanjutnya</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0">
          <div class="card-body d-flex align-items-center">
            <i class="bi-person text-danger fs-2 me-3"></i>
            <div>
              <p id="sisa-antrian" class="fs-4 fw-bold mb-0">0</p>
              <small class="text-muted">Sisa Antrian</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tabel Antrian -->
    <div class="card border-0 shadow-sm">
      <div class="card-body">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Data Antrian Hari Ini</h5>
          <a href="form_laporan.php" class="btn btn-outline-success">
             <i class="bi bi-filter-circle me-1"></i> Export Laporan
         </a>
      </div>

        <div class="table-responsive">
          <table id="tabel-antrian" class="table table-bordered table-striped" width="100%">
            <thead>
              <tr>
                <th>Nomor Antrian</th>
                <th>Nama</th>
                <th>Jenis Layanan</th>
                <th>Status</th>
                <th>Panggil</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

  </div>
</main>

<!-- Footer -->
<footer class="footer mt-auto py-3 bg-white">
  <div class="container text-center small text-muted">
    <hr>
    &copy; <?= date('Y') ?> - Aplikasi Antrian. Marthin Juan.
  </div>
</footer>

<!-- Bell Sound -->
<audio id="tingtung" src="../assets/audio/tingtung.mp3"></audio>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
<script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script>

<script>
  $(document).ready(function () {
    // Load info box
    $('#jumlah-antrian').load('get_jumlah_antrian.php');
    $('#antrian-sekarang').load('get_antrian_sekarang.php');
    $('#antrian-selanjutnya').load('get_antrian_selanjutnya.php');
    $('#sisa-antrian').load('get_sisa_antrian.php');

    // DataTable
    const table = $('#tabel-antrian').DataTable({
      ajax: 'get_antrian.php',
      lengthChange: false,
      searching: false,
      columns: [
        { data: 'no_antrian', className: 'text-center' },
        { data: 'nama', className: 'text-center' },
        {data: 'jenis_antrian', className: 'text-center'},
        { data: 'status', visible: false },
        {
          data: null,
          className: 'text-center',
          orderable: false,
          render: function (data) {
            if (!data.status) return "-";
            if (data.status === "0") {
              return `<button class="btn btn-success btn-sm rounded-circle"><i class="bi bi-mic-fill"></i></button>`;
            } else {
              return `<button class="btn btn-secondary btn-sm rounded-circle"><i class="bi bi-mic-fill"></i></button>`;
            }
          }
        }
      ],
      order: [[0, 'asc']],
      iDisplayLength: 10
    });

    // Panggil suara
    $('#tabel-antrian tbody').on('click', 'button', function () {
      const data = table.row($(this).parents('tr')).data();
      const id = data.id;
      const bell = document.getElementById('tingtung');

      bell.pause();
      bell.currentTime = 0;
      bell.play();

      setTimeout(() => {
        responsiveVoice.speak("Nomor Antrian " + data.no_antrian + ", atas nama " + data.nama + "", "Indonesian Male", {
          rate: 0.9,
          pitch: 1,
          volume: 1
        });
      }, bell.duration * 100);

      // Update status
      $.post('update.php', { id: id });
    });

    // Auto refresh data
    setInterval(() => {
      $('#jumlah-antrian').load('get_jumlah_antrian.php');
      $('#antrian-sekarang').load('get_antrian_sekarang.php');
      $('#antrian-selanjutnya').load('get_antrian_selanjutnya.php');
      $('#sisa-antrian').load('get_sisa_antrian.php');
      table.ajax.reload(null, false);
    }, 1000);
  });
</script>

</body>
</html>
