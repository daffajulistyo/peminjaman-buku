@extends('backend.layouts.app')

@section('content')
    <!-- resources/views/your-view-name.blade.php -->
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chart Page</title>
        <!-- Include Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container mt-4">
            <h2>Data Chart berdasarkan Nama OPD</h2>
            <table id="opdTable" class="table table-striped table-bordered">
                <thead class="thead-success">
                    <tr>
                        <th>Nama OPD</th>
                        <th>Pegawai</th>
                        <th>Kurang</th>
                        <th>Hadir</th>
                        <th>Dinas</th>
                        <th>Izin</th>
                        <th>Sakit</th>
                        <th>Cuti</th>
                        <th>Tanpa Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data tabel akan diisi oleh JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Include Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- Data JSON -->
        <script>
            // JSON data yang disediakan secara langsung
            const jsonData = {
                "data": [
                    {
                        "nama_opd": "Dinas Komunikasi dan Informatika",
                        "jumlah_pegawai": 4,
                        "jumlah_kurang": 3,
                        "jumlah_hadir": 1,
                        "jumlah_dinas": 0,
                        "jumlah_izin": 0,
                        "jumlah_sakit": 0,
                        "jumlah_cuti": 0,
                        "jumlah_tanpa_keterangan": 3
                    },
                    {
                        "nama_opd": "Dinas Komunikasi dan Informatika",
                        "jumlah_pegawai": 4,
                        "jumlah_kurang": 3,
                        "jumlah_hadir": 1,
                        "jumlah_dinas": 0,
                        "jumlah_izin": 0,
                        "jumlah_sakit": 0,
                        "jumlah_cuti": 0,
                        "jumlah_tanpa_keterangan": 3
                    },
                    // Tambahkan data lainnya sesuai kebutuhan
                ]
            };

            // Panggil fungsi untuk memuat data dari JSON ke dalam tabel
            buildTableData(jsonData.data);

            function buildTableData(data) {
                const tbody = document.querySelector('#opdTable tbody');

                data.forEach(opd => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${opd.nama_opd}</td>
                        <td>${opd.jumlah_pegawai}</td>
                        <td>${opd.jumlah_kurang}</td>
                        <td>${opd.jumlah_hadir}</td>
                        <td>${opd.jumlah_dinas}</td>
                        <td>${opd.jumlah_izin}</td>
                        <td>${opd.jumlah_sakit}</td>
                        <td>${opd.jumlah_cuti}</td>
                        <td>${opd.jumlah_tanpa_keterangan}</td>
                    `;
                    tbody.appendChild(row);
                });
            }
        </script>
    </body>

    </html>
@endsection
