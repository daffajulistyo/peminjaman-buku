console.log("Fungsi Javascript Dipanggil");

// Variabel untuk melacak apakah tombol "Absen Masuk" telah diklik
let absenMasukClicked = false;

let userLatitude;
let userLongitude;
let maxDistance = 30;

let entry1Latitude;
let entry1Longitude;
let entry2Latitude;
let entry2Longitude;

const today = new Date().getDay();
console.log("Hari saat ini : " + today);

if (today === 1) {
    // Jika hari Senin, kita akan menggunakan dua titik koordinat
    // Koordinat pertama
    entry1Latitude = 0.14045929167693957;
    entry1Longitude = 100.16687831565406;

    // Ambil koordinat kedua dari endpoint
    fetch("/user-coordinates", {
        method: "GET",
        headers: {
            Accept: "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            userLatitude = parseFloat(data.latitude);
            userLongitude = parseFloat(data.longitude);

            checkDistanceAndSetButtons();
        })
        .catch((error) => console.error("Error:", error));

    maxDistance = 60;
} else {
    fetch("/user-coordinates", {
        method: "GET",
        headers: {
            Accept: "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            userLatitude = parseFloat(data.latitude);
            userLongitude = parseFloat(data.longitude);

            checkDistanceAndSetButtons();
        })
        .catch((error) => console.error("Error:", error));
}

// Ambil koordinat absen keluar dari endpoint
fetch("/user-coordinates", {
    method: "GET",
    headers: {
        Accept: "application/json",
    },
})
    .then((response) => response.json())
    .then((data) => {
        exitLatitude = parseFloat(data.latitude);
        exitLongitude = parseFloat(data.longitude);

        handleAbsenKeluarClick();
    })
    .catch((error) => console.error("Error:", error));

// Fungsi untuk menentukan jarak dan mengatur tombol
function checkDistanceAndSetButtons() {
    navigator.geolocation.getCurrentPosition(
        function (position) {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;

            let distanceToEntry1 = 0;
            let distanceToEntry2 = 0;

            // Jika hari ini Senin, hitung jarak ke kedua titik masuk
            if (today === 1) {
                distanceToEntry1 = geolib.getDistance(
                    { latitude: userLat, longitude: userLng },
                    { latitude: userLatitude, longitude: userLongitude }
                );

                distanceToEntry2 = geolib.getDistance(
                    { latitude: userLat, longitude: userLng },
                    { latitude: entry1Latitude, longitude: entry1Longitude }
                );
            } else {
                // Jika bukan Senin, hitung jarak ke titik masuk pertama saja
                distanceToEntry1 = geolib.getDistance(
                    { latitude: userLat, longitude: userLng },
                    { latitude: userLatitude, longitude: userLongitude }
                );
            }

            console.log(
                "Jarak Anda Ke titik Absen Masuk 1 : " + distanceToEntry1,
                "Meter"
            );
            console.log(
                "Jarak Anda Ke titik Absen Masuk 2 : " + distanceToEntry2,
                "Meter"
            );

            const absenMasukButton =
                document.getElementById("absenMasukButton");

            // Jika hari ini Senin, tombol Absen Masuk akan aktif jika berada dalam jarak ke salah satu dari kedua titik masuk
            if (
                today === 1 &&
                (distanceToEntry1 <= 1000 ||
                    distanceToEntry2 <= maxDistance)
            ) {
                absenMasukButton.disabled = false;
                absenMasukButton.textContent = "Datang";

                // Tandai bahwa "Absen Masuk" telah diklik
                absenMasukClicked = true;
            } else if (today !== 1 && distanceToEntry1 <= maxDistance) {
                // Jika bukan Senin, tombol Absen Masuk akan aktif jika berada dalam jarak ke titik masuk pertama saja
                absenMasukButton.disabled = false;
                absenMasukButton.textContent = "Datang";

                // Tandai bahwa "Absen Masuk" telah diklik
                absenMasukClicked = true;
            } else {
                absenMasukButton.disabled = true;
                absenMasukButton.textContent = "Jarak Anda > 25 M";
            }

            console.log("Jarak:", distanceToEntry1, distanceToEntry2); // Cetak nilai jarak untuk debug
        },
        function (error) {
            // Tangani kesalahan ketika lokasi tidak dapat dideteksi
            console.error("Gagal mendeteksi lokasi:", error);

            // Aktifkan tombol "Absen Masuk" dan atur teksnya menjadi "Lokasi Tidak Dapat Dideteksi"
            const absenMasukButton =
                document.getElementById("absenMasukButton");
            absenMasukButton.disabled = true;
            absenMasukButton.textContent = "Lokasi Tidak Dapat Dideteksi";

            // Aktifkan tombol "Absen Keluar" dan atur teksnya menjadi "Lokasi Tidak Dapat Dideteksi"
            const absenKeluarButton =
                document.getElementById("absenKeluarButton");
            absenKeluarButton.disabled = true;
            absenKeluarButton.textContent = "Lokasi Tidak Dapat Dideteksi";
        }
    );
}

function handleAbsenKeluarClick() {
    navigator.geolocation.getCurrentPosition(
        function (position) {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;

            const distanceToExit = geolib.getDistance(
                { latitude: userLat, longitude: userLng },
                { latitude: exitLatitude, longitude: exitLongitude }
            );

            console.log(
                "Jarak Anda Ke titik Absen Keluar : " + distanceToExit,
                "Meter"
            );

            const absenKeluarButton =
                document.getElementById("absenKeluarButton");
            // Hanya aktifkan tombol "Absen Keluar" jika "Absen Masuk" telah diklik
            if (distanceToExit <= maxDistance) {
                absenKeluarButton.disabled = false;
                absenKeluarButton.textContent = "Pulang";
            } else {
                absenKeluarButton.disabled = true;
                absenKeluarButton.textContent = "Jarak Anda > 25 M";
            }

            console.log("Jarak:", distanceToExit); // Cetak nilai jarak untuk debug
        },
        function (error) {
            // Tangani kesalahan ketika lokasi tidak dapat dideteksi
            console.error("Gagal mendeteksi lokasi:", error);

            // Aktifkan tombol "Absen Keluar" dan atur teksnya menjadi "Lokasi Tidak Dapat Dideteksi"
            const absenKeluarButton =
                document.getElementById("absenKeluarButton");
            absenKeluarButton.disabled = true;
            absenKeluarButton.textContent = "Lokasi Tidak Dapat Dideteksi";
        }
    );
}
