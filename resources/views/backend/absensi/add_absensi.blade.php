<div class="row">

    <div class="col-md-12">
        <div class="card card-primary">

            <div class="card-body">
                <div class="text-center mb-3">
                    @php
                        $user = Auth::user();
                        $currentDate = \Carbon\Carbon::now()->toDateString();
                        $attendance = $absen
                            ->where('user_id', $user->id)
                            ->where('tanggal', $currentDate)
                            ->first();
                    @endphp

                    <div class="d-flex justify-content-center align-items-center">
                        @if ($attendance)
                            @if (!$attendance->jam_keluar)
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <button type="button" class="absen-button" disabled>Datang:
                                            {{ $attendance->jam_masuk }}</button>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <form method="POST"
                                            action="{{ route('absensi.insert_keluar', ['id' => $attendance->id]) }}">
                                            @csrf
                                            <input type="hidden" name="jam_keluar"
                                                value="{{ \Carbon\Carbon::now()->toTimeString() ?? '-' }}">
                                            @if ($attendance->jam_keluar)
                                                <button type="submit" class="absen-button-pulang"
                                                    id="absenKeluarButton">Pulang:
                                                    {{ $attendance->jam_keluar }}</button>
                                            @else
                                                <button type="submit" class="absen-button-pulang"
                                                    id="absenKeluarButton">Pulang</button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <button type="button" class="absen-button" disabled>Datang:
                                            {{ $attendance->jam_masuk }}</button>
                                    </div>
                                    <div class="col-md-6">
                                        <form method="POST"
                                            action="{{ route('absensi.insert_keluar', ['id' => $attendance->id]) }}">
                                            @csrf
                                            <input type="hidden" name="jam_keluar"
                                                value="{{ \Carbon\Carbon::now()->toTimeString() ?? '-' }}">
                                            <button type="submit" class="absen-button-pulang"
                                                id="absenKeluarButton">Pulang: {{ $attendance->jam_keluar }}</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @else
                            <form method="POST" action="{{ route('absensi.insert') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::user()->user_id }}">
                                <input type="hidden" name="tanggal"
                                    value="{{ \Carbon\Carbon::now()->toDateString() }}">
                                <input type="hidden" name="jam_masuk"
                                    value="{{ \Carbon\Carbon::now()->toTimeString() }}">
                                <input type="hidden" name="jam_keluar" value="">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <button type="submit" class="absen-button" id="absenMasukButton"
                                            disabled>Datang</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="absen-button-pulang" id="absenKeluarButton"
                                            disabled>Pulang</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    console.log("Fungsi Javascript Dipanggil");

    // Variabel untuk melacak apakah tombol "Absen Masuk" telah diklik
    let absenMasukClicked = false;

    let userLatitude;
    let userLongitude;
    let maxDistance = 1;

    let entry1Latitude;
    let entry1Longitude;
    let entry2Latitude;
    let entry2Longitude;

    const today = new Date().getDay();
    console.log("Hari saat ini : " + today);


    fetch("/user-coordinates", {
            method: "GET",
            headers: {
                Accept: "application/json",
            },
        })
        .then((response) => response.json())
        .then((data) => {
            if (data.koordinat && Array.isArray(data.koordinat)) {
                // Menyimpan semua koordinat dalam array userCoordinates
                const userCoordinates = data.koordinat.map(coord => ({
                    latitude: parseFloat(coord.latitude),
                    longitude: parseFloat(coord.longitude),
                    radius: parseFloat(coord.radius)
                }));

                // Simpan koordinat di variabel global untuk digunakan di fungsi checkDistanceAndSetButtons
                window.userCoordinates = userCoordinates;

                // Panggil fungsi checkDistanceAndSetButtons
                checkDistanceAndSetButtons();
            } else {
                console.error("No coordinates found");
            }
        })
        .catch((error) => console.error("Error:", error));


    // Ambil koordinat absen keluar dari endpoint
    fetch("/user-coordinates", {
            method: "GET",
            headers: {
                Accept: "application/json",
            },
        })
        .then((response) => response.json())
        .then((data) => {
            if (data.koordinat && Array.isArray(data.koordinat)) {
                // Menyimpan semua koordinat dalam array userCoordinates
                const userCoordinates = data.koordinat.map(coord => ({
                    latitude: parseFloat(coord.latitude),
                    longitude: parseFloat(coord.longitude),
                    radius: parseFloat(coord.radius)
                }));

                // Simpan koordinat di variabel global untuk digunakan di fungsi checkDistanceAndSetButtons
                window.userCoordinates = userCoordinates;

                // Panggil fungsi checkDistanceAndSetButtons
                handleAbsenKeluarClick();
            } else {
                console.error("No coordinates found");
            }
        })
        .catch((error) => console.error("Error:", error));
    // Fungsi untuk menentukan jarak dan mengatur tombol
    function checkDistanceAndSetButtons() {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;

                // Ambil tanggal hari ini
                const today = new Date().getDay();

                let isWithinAnyDistance = false;

                const mondaySpecialCoordinates = {
                    latitude: 0.1405111391276412,
                    longitude: 100.16706773994271,
                    radius: 60 // Misalkan radius 25 meter untuk koordinat spesifik ini
                };

                const fridaySpecialCoordinates = {
                    latitude: 0.13879060059364723,
                    longitude: 100.16557101994853,
                    radius: 60 // Misalkan radius 25 meter untuk koordinat spesifik ini
                };

                if (today === 1) { // Jika hari ini adalah Senin
                    const distanceToMondaySpecial = geolib.getDistance({
                        latitude: userLat,
                        longitude: userLng
                    }, {
                        latitude: mondaySpecialCoordinates.latitude,
                        longitude: mondaySpecialCoordinates.longitude
                    });

                    console.log(
                        `Jarak Anda ke titik koordinat spesifik (100, 200) adalah ${distanceToMondaySpecial} meter`
                    );

                    if (distanceToMondaySpecial <= mondaySpecialCoordinates.radius) {
                        isWithinAnyDistance = true;
                    }
                }

                if (today === 5) { // Jika hari ini adalah Jumat
                    const distanceToFridaySpecial = geolib.getDistance({
                        latitude: userLat,
                        longitude: userLng
                    }, {
                        latitude: fridaySpecialCoordinates.latitude,
                        longitude: fridaySpecialCoordinates.longitude
                    });

                    console.log(
                        `Jarak Anda ke titik koordinat spesifik (199, 999) adalah ${distanceToFridaySpecial} meter`
                    );

                    if (distanceToFridaySpecial <= fridaySpecialCoordinates.radius) {
                        isWithinAnyDistance = true;
                    }
                }

                window.userCoordinates.forEach(coord => {
                    const distance = geolib.getDistance({
                        latitude: userLat,
                        longitude: userLng
                    }, {
                        latitude: coord.latitude,
                        longitude: coord.longitude
                    });

                    console.log(
                        `Jarak Anda ke titik dengan koordinat (${coord.latitude}, ${coord.longitude}) adalah ${distance} meter`
                    );

                    // Jika jarak ke salah satu titik kurang dari atau sama dengan radius, set isWithinAnyDistance menjadi true
                    if (distance <= coord.radius) {
                        isWithinAnyDistance = true;
                    }
                });

                const absenMasukButton = document.getElementById("absenMasukButton");

                // Jika hari ini Senin atau tidak, tombol Absen Masuk akan aktif jika berada dalam radius dari salah satu koordinat
                if (isWithinAnyDistance) {
                    absenMasukButton.disabled = false;
                    absenMasukButton.textContent = "Datang";
                } else {
                    absenMasukButton.disabled = true;
                    absenMasukButton.textContent = "Jarak Anda > 25 M";
                }

                console.log("Is within any distance:", isWithinAnyDistance); // Cetak nilai untuk debug
            },
            function(error) {
                // Tangani kesalahan ketika lokasi tidak dapat dideteksi
                console.error("Gagal mendeteksi lokasi:", error);

                // Aktifkan tombol "Absen Masuk" dan atur teksnya menjadi "Lokasi Tidak Dapat Dideteksi"
                const absenMasukButton = document.getElementById("absenMasukButton");
                absenMasukButton.disabled = true;
                absenMasukButton.textContent = "Lokasi Tidak Dapat Dideteksi";

                // Aktifkan tombol "Absen Keluar" dan atur teksnya menjadi "Lokasi Tidak Dapat Dideteksi"
                const absenKeluarButton = document.getElementById("absenKeluarButton");
                absenKeluarButton.disabled = true;
                absenKeluarButton.textContent = "Lokasi Tidak Dapat Dideteksi";
            }
        );
    }

    function handleAbsenKeluarClick() {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;

                let isWithinAnyDistance = false;

                window.userCoordinates.forEach(coord => {
                    const distance = geolib.getDistance({
                        latitude: userLat,
                        longitude: userLng
                    }, {
                        latitude: coord.latitude,
                        longitude: coord.longitude
                    });

                    console.log(
                        `Jarak Anda ke titik dengan koordinat (${coord.latitude}, ${coord.longitude}) adalah ${distance} meter`
                    );

                    // Jika jarak ke salah satu titik kurang dari atau sama dengan radius, set isWithinAnyDistance menjadi true
                    if (distance <= coord.radius) {
                        isWithinAnyDistance = true;
                    }
                });

                const absenKeluarButton = document.getElementById("absenKeluarButton");

                // Hanya aktifkan tombol "Absen Keluar" jika berada dalam radius dari salah satu koordinat
                if (isWithinAnyDistance) {
                    absenKeluarButton.disabled = false;
                    absenKeluarButton.textContent = "Pulang";
                } else {
                    absenKeluarButton.disabled = true;
                    absenKeluarButton.textContent = "Jarak Anda > 25 M";
                }

                console.log("Is within any distance:", isWithinAnyDistance); // Cetak nilai untuk debug
            },
            function(error) {
                // Tangani kesalahan ketika lokasi tidak dapat dideteksi
                console.error("Gagal mendeteksi lokasi:", error);

                // Aktifkan tombol "Absen Keluar" dan atur teksnya menjadi "Lokasi Tidak Dapat Dideteksi"
                const absenKeluarButton = document.getElementById("absenKeluarButton");
                absenKeluarButton.disabled = true;
                absenKeluarButton.textContent = "Lokasi Tidak Dapat Dideteksi";
            }
        );
    }
</script>
