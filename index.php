<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaflet Map - Case 4</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <div id="map"></div>
    
    <dialog id="modal">
        <div class="dialog-content">
            <h2 id="modal-title">Simpan ke database?</h2>
            <p>Longitude: <span id="longitude"></span></p>
            <p>Latitude: <span id="latittude"></span></p>
            <form class="form" id="location-form" method="post">
                <label for="name"> Nama Lokasi</label>
                <input type="text" name="name" id="name">
                <label for="description"> Deskripsi Lokasi</label>
                <input type="text" name="description" id="description">
                <label for="address"> Alamat</label>
                <input type="text" name="address" id="address">
                <label for="category"> Kategori</label>
                <input type="text" name="category" id="category">
                <label for="phone"> Telepon</label>
                <input type="text" name="phone" id="phone">
                <label for="website"> Website</label>
                <input type="text" name="website" id="website">
                <button type="button" id="cancel">Cancel</button>
                <button id="simpan" type="submit">Simpan</button>
            </form>
        </div>
    </dialog>
    
    <dialog id="confirm-delete">
        <div class="dialog-content">
            <h2>Konfirmasi Hapus</h2>
            <p>Apakah Anda yakin ingin menghapus data ini?</p>
            <div class="container">
                <button type="button" id="delete-cancel">Cancel</button>
                <button type="button" id="delete-confirm">Hapus</button>
            </div>
        </div>
    </dialog>

    <div id="notification"></div>
    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

    <script src="script.js"></script>
</body>
</html>
