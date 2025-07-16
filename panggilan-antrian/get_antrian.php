<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
  require_once "../config/database.php";

  $tanggal = gmdate("Y-m-d", time() + 60 * 60 * 7);

  $query = mysqli_query($mysqli, "SELECT id, nama, no_antrian, jenis_antrian, status FROM tbl_antrian 
                                  WHERE tanggal='$tanggal'")
          or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));

  $response = array();
  $response["data"] = array();

  if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
      $data = array(
        "id"            => $row["id"],
        "nama"          => $row["nama"],
        "no_antrian"    => $row["no_antrian"],
        "jenis_antrian" => $row["jenis_antrian"],
        "status"        => $row["status"]
      );
      $response["data"][] = $data;
    }
  } else {
    $response["data"][] = array(
      "id"            => "",
      "nama"          => "-",
      "no_antrian"    => "-",
      "jenis_antrian" => "-",
      "status"        => ""
    );
  }

  echo json_encode($response);
}
?>
