


// Fungsi untuk menangani klik tombol "Absen Masuk"
// Fungsi untuk menangani klik tombol "Absen Masuk"
function handleAbsenMasukClick() {
    navigator.geolocation.getCurrentPosition(
      function (position) {
        const userLat = position.coords.latitude;
        const userLng = position.coords.longitude;
  
        // Hitung jarak antara lokasi pengguna dan lokasi database
        const distance = geolib.getDistance(
          { latitude: userLat, longitude: userLng },
          { latitude: 0.14046111044624462, longitude: 100.16573217696032 }
        );
  
        // Periksa jarak
        const button = document.getElementById("absenMasukButton");
  
        if (distance < 500) {
          // Aktifkan tombol dan atur teksnya menjadi "Klik Absen"
          button.disabled = false;
          button.textContent = "Klik Absen";
        } else {
          // Aktifkan tombol dan atur teksnya menjadi "Jarak Anda > 20 M"
          button.disabled = true;
          button.textContent = "Jarak Anda > 20 M";
        }
        console.log("Jarak:", distance); // Cetak nilai jarak untuk debug
      },
      function (error) {
        // Tangani kesalahan ketika lokasi tidak dapat dideteksi
        console.error("Gagal mendeteksi lokasi:", error);
  
        // Aktifkan tombol dan atur teksnya menjadi "Lokasi Tidak Dapat Dideteksi"
        const button = document.getElementById("absenMasukButton");
        button.disabled = false;
        button.textContent = "Lokasi Tidak Dapat Dideteksi";
      }
    );
  }
  
  // Menambahkan event listener ke tombol "Absen Masuk" setelah dokumen HTML selesai dimuat
  document.addEventListener("DOMContentLoaded", function () {
    const absenMasukButton = document.getElementById("absenMasukButton");
    absenMasukButton.addEventListener("click", handleAbsenMasukClick);
  });
  
