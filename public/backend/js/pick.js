
// console.log("Fungsi JavaScript terpanggil di Yourjs");

// // Fungsi untuk menangani klik tombol
// function handleClick() {
//     const button = document.getElementById("myButton");
//     button.textContent = "Tombol Diklik";

//     setTimeout(function () {
//         button.textContent = "Lokasi Saya";
//     }, 2000); // Ganti kembali ke "Lokasi Saya" setelah 2 detik (opsional)
// }

// // Tambahkan event listener ke tombol untuk menangani klik
// const button = document.getElementById("myButton");
// button.addEventListener("click", handleClick);

// const map = L.map("map").setView([0.14046111044624462, 100.16573217696032], 13);

// // Tambahkan peta tile (misalnya dari OpenStreetMap)
// L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
//     maxZoom: 19,
// }).addTo(map);

// // Tambahkan marker untuk lokasi di database
// const databaseLocation = L.marker([
//     0.14046111044624462, 100.16573217696032,
// ]).addTo(map);

// // Dapatkan koordinat pengguna menggunakan Geolocation API
// navigator.geolocation.getCurrentPosition(
//     function (position) {
//         const userLat = position.coords.latitude;
//         const userLng = position.coords.longitude;

//         // Hitung jarak antara lokasi pengguna dan lokasi database
//         const distance = geolib.getDistance(
//             { latitude: userLat, longitude: userLng },
//             { latitude: 0.14046111044624462, longitude: 100.16573217696032 }
//         );

//         // Periksa jarak
//         const button = document.getElementById("myButton");

//         if (distance <= 500) {
//             // Aktifkan tombol dan atur teksnya menjadi "Klik Saya"
//             button.disabled = false;
//             button.textContent = "Klik Absen";
//         } else {
//             // Aktifkan tombol dan atur teksnya menjadi "Lokasi Saya"
//             button.disabled = true;
//             button.textContent = "Jarak Anda > 20 M";
//         }
//         console.log("Jarak:", distance); // Cetak nilai jarak untuk debug
//     },
//     function (error) {
//         // Tangani kesalahan ketika lokasi tidak dapat dideteksi
//         console.error("Gagal mendeteksi lokasi:", error);

//         // Aktifkan tombol dan atur teksnya menjadi "Lokasi Tidak Dapat Dideteksi"
//         const button = document.getElementById("myButton");
//         button.disabled = false;
//         button.textContent = "Lokasi Tidak Dapat Dideteksi";
//     }
// );

// L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//   maxZoom: 19,
// }).addTo(map);

// // Dapatkan koordinat pengguna menggunakan Geolocation API
// navigator.geolocation.getCurrentPosition(function (position) {
//   const userLat = position.coords.latitude;
//   const userLng = position.coords.longitude;

//   // Hitung jarak antara lokasi pengguna dan lokasi database
//   const distance = geolib.getDistance(
//     { latitude: userLat, longitude: userLng },
//     { latitude: 0.14046111044624462, longitude: 100.16573217696032 }
//   );

//   // Periksa jarak
//   const button = document.getElementById('myButton');

//   if (distance <= 1000) {
//     // Aktifkan tombol dan atur teksnya menjadi "Klik Absen"
//     button.disabled = false;
//     button.textContent = 'Klik Absen';

//     // Tambahkan marker untuk lokasi pengguna
//     const userLocationMarker = L.marker([userLat, userLng]).addTo(map);
//     userLocationMarker.bindPopup('Lokasi Anda').openPopup();

//     // Set peta agar fokus pada lokasi pengguna
//     map.setView([userLat, userLng], 13);
//   } else {
//     // Aktifkan tombol dan atur teksnya menjadi "Lokasi Saya"
//     button.disabled = true;
//     button.textContent = 'Jarak Anda > 20 M';
//   }
//   console.log('Jarak:', distance); // Cetak nilai jarak untuk debug

// }, function (error) {
//   // Tangani kesalahan ketika lokasi tidak dapat dideteksi
//   console.error('Gagal mendeteksi lokasi:', error);

//   // Aktifkan tombol dan atur teksnya menjadi "Lokasi Tidak Dapat Dideteksi"
//   const button = document.getElementById('myButton');
//   button.disabled = false;
//   button.textContent = 'Lokasi Tidak Dapat Dideteksi';
// });
