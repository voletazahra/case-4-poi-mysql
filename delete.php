<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "poi";

$kon = mysqli_connect($host, $user, $password, $db);
if (!$kon) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $latitude = $data['latitude'] ?? '';
    $longitude = $data['longitude'] ?? '';

    if ($latitude && $longitude) {
        $sql = "DELETE FROM poi WHERE latitude = ? AND longitude = ?";
        $stmt = mysqli_prepare($kon, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "dd", $latitude, $longitude);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo json_encode(array("status" => "success", "message" => "Data POI berhasil dihapus."));
            } else {
                echo json_encode(array("status" => "error", "message" => "Data dengan koordinat ($latitude, $longitude) tidak ditemukan."));
            }

            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(array("status" => "error", "message" => "Error: " . mysqli_error($kon)));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Koordinat tidak valid."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Metode pengiriman tidak valid."));
}

mysqli_close($kon);
?>
