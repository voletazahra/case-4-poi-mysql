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

    $name = $data['name'] ?? '';
    $description = $data['description'] ?? '';
    $address = $data['address'] ?? '';
    $category = $data['category'] ?? '';
    $phone = $data['phone'] ?? '';
    $website = $data['website'] ?? '';
    $longitude = $data['longitude'] ?? '';
    $latitude = $data['latitude'] ?? '';

    if ($name && $longitude && $latitude) {
        $sql = "INSERT INTO poi (latitude, longitude, name, description, address, category, phone, website) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($kon, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ddssssss", $latitude, $longitude, $name, $description, $address, $category, $phone, $website);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo json_encode(array("status" => "success", "message" => "Data POI berhasil disimpan."));
            } else {
                echo json_encode(array("status" => "error", "message" => "Gagal menyimpan data POI."));
            }

            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(array("status" => "error", "message" => "Error: " . mysqli_error($kon)));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Data yang dikirim tidak lengkap."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Metode pengiriman tidak valid."));
}

mysqli_close($kon);
?>
