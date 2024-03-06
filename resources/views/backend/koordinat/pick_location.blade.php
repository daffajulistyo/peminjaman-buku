<!DOCTYPE html>
<html>
<head>
    <!-- Tambahkan referensi ke Leaflet.js dan CSS-nya -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <!-- Tambahkan referensi ke geolib.js melalui CDN -->
    <script src="https://cdn.jsdelivr.net/npm/geolib@3.3.3/lib/index.min.js"></script>
</head>
<body>
    <div id="map" style="width: 400px; height: 400px;"></div>
    <button type="submit" id="myButton" disabled>Lokasi Saya</button>

    <!-- Script JavaScript untuk mengukur jarak -->
    <script src="{{ asset('backend/js/pick.js') }}"></script>
</body>
</html>
