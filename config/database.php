<?php
// deklarasi parameter koneksi database
$host     = "localhost";              // server database, default “localhost” atau “127.0.0.1”
$username = "root";                   // username database, default “root”
$password = "";                       // password database, default kosong
$database = "db_antri";             // memilih database yang akan digunakan

// buat koneksi database
$mysqli = mysqli_connect($host, $username, $password, $database);

// cek koneksi
// jika koneksi gagal 
if (!$mysqli) {
  // tampilkan pesan gagal koneksi
  die('Koneksi Database Gagal : ' . mysqli_connect_error());
}

$jenis = $_GET['jenis'] ?? 'konsultasi'; // default

$query = $mysqli->query("SELECT * FROM tbl_antrian WHERE tanggal = CURDATE() AND jenis_antrian = '$jenis' ORDER BY no_antrian ASC");
