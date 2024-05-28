<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "poi";

$kon = mysqli_connect($host, $user, $password, $db);
if (!$kon) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$sql = "SELECT PK_POI, X(KOORDINAT_POSISI) AS latitude, Y(KOORDINAT_POSISI) AS longitude, NAMA, DESKRIPSI FROM poi_data";
$result = mysqli_query($kon, $sql);

if (mysqli_num_rows($result) > 0) {
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo "Tidak ada data POI.";
}

mysqli_close($kon);
?>
