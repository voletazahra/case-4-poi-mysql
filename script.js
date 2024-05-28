var map = L.map("map").setView([-2.5489, 118.0149], 5);

L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 19,
  attribution:
    '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);

const modal = document.querySelector("#modal");
const simpan = document.querySelector("#simpan");
const cancel = document.querySelector("#cancel");
const longitude = document.querySelector("#longitude");
const latittude = document.querySelector("#latittude");
const confirmDelete = document.querySelector("#confirm-delete");
const deleteConfirm = document.querySelector("#delete-confirm");
const deleteCancel = document.querySelector("#delete-cancel");
var lat;
var lng;
var marker;
var isUpdating = false;
var updateMarkerId = null;

// Event yang terjadi kalo map diklik
map.on("click", function (e) {
  lat = e.latlng.lat;
  lng = e.latlng.lng;
  
  marker = L.marker([lat, lng], { draggable: true })
    .addTo(map)
    .bindPopup("Coordinates: " + lat + ", " + lng)
    .openPopup();
  
  cancel.addEventListener("click", (e) => {
    e.preventDefault();
    modal.close();
    map.removeLayer(marker);
  });
  
  marker.on("click", function (e) {
    var name = document.getElementById("name").value;
    var description = document.getElementById("description").value;
    
    marker.bindPopup(
      "<b>Nama Lokasi:</b> " +
        name +
        "<br>" +
        "<b>Deskripsi:</b> " +
        description +
        "<br>" +
        '<button onclick="confirmDeleteMarker(' +
        marker._leaflet_id +
        ')">Hapus</button>' +
        '<br>' +
        '<button onclick="updateMarker(' +
        marker._leaflet_id +
        ')">Update</button>'
    ).openPopup();
  });

  marker.on("dragend", function(e) {
    lat = e.target.getLatLng().lat;
    lng = e.target.getLatLng().lng;
    isUpdating = true;
    updateMarkerId = marker._leaflet_id;
    document.getElementById("modal-title").innerText = "Update POI Data?";
    longitude.innerHTML = lng;
    latittude.innerHTML = lat;
    modal.showModal();
  });

  longitude.innerHTML = lng;
  latittude.innerHTML = lat;
  modal.showModal();
});

simpan.addEventListener("click", (e) => {
  e.preventDefault();

  const name = document.getElementById("name").value;
  const description = document.getElementById("description").value;
  const address = document.getElementById("address").value;
  const category = document.getElementById("category").value;
  const phone = document.getElementById("phone").value;
  const website = document.getElementById("website").value;
  const koorLat = lat;
  const koorLong = lng;

  const data = {
    name: name,
    description: description,
    address: address,
    category: category,
    phone: phone,
    website: website,
    latitude: koorLat,
    longitude: koorLong,
  };

  const url = isUpdating ? "update.php" : "proses.php";

  fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("ERROR");
      }
      return response.text();
    })
    .then((data) => {
      console.log(data);
    })
    .catch((error) => {
      console.error("Terjadi kesalahan: ", error);
    });

  isUpdating = false;
  updateMarkerId = null;
  document.getElementById("modal-title").innerText = "Simpan ke database?";
  modal.close();
});

function confirmDeleteMarker(id) {
  confirmDelete.showModal();

  deleteConfirm.onclick = function() {
    hapusMarker(id);
    confirmDelete.close();
  };

  deleteCancel.onclick = function() {
    confirmDelete.close();
  };
}

function hapusMarker(id) {
  var marker = map._layers[id];
  if (marker instanceof L.Marker) {
    map.removeLayer(marker);
    console.log("Marker dengan ID " + id + " berhasil dihapus.");

    fetch("delete.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ latitude: marker.getLatLng().lat, longitude: marker.getLatLng().lng }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("ERROR");
        }
        return response.text();
      })
      .then((data) => {
        console.log(data);
      })
      .catch((error) => {
        console.error("Terjadi kesalahan saat menghapus marker: ", error);
      });
  }
}

function updateMarker(id) {
  var marker = map._layers[id];
  if (marker instanceof L.Marker) {
    lat = marker.getLatLng().lat;
    lng = marker.getLatLng().lng;
    isUpdating = true;
    updateMarkerId = id;

    var name = document.getElementById("name").value;
    var description = document.getElementById("description").value;
    var address = document.getElementById("address").value;
    var category = document.getElementById("category").value;
    var phone = document.getElementById("phone").value;
    var website = document.getElementById("website").value;

    document.getElementById("name").value = name;
    document.getElementById("description").value = description;
    document.getElementById("address").value = address;
    document.getElementById("category").value = category;
    document.getElementById("phone").value = phone;
    document.getElementById("website").value = website;
    
    document.getElementById("modal-title").innerText = "Update POI Data?";
    longitude.innerHTML = lng;
    latittude.innerHTML = lat;
    modal.showModal();
  }
}
