<!DOCTYPE html>
<html lang="en">

<head>
    <title>Chart Example with Bootstrap</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Container untuk chart -->
    <div class="container mt-4">
        <!-- Pilihan OPD dengan Bootstrap -->
        <div class="form-group">
            <select class="form-control" id="opdSelect" onchange="updateChart()">
                <!-- Opsi akan ditambahkan secara dinamis setelah menerima respons dari API -->
            </select>
        </div>

        <!-- Container untuk chart -->
        <div id="chartContainer" style="display: flex;"></div>
    </div>

    <script>
        var tanggal = new Date();
        var tahun = tanggal.getFullYear();
        var bulan = tanggal.getMonth() + 1;
        var tanggal = tanggal.getDate();

        var apiUrl = "api/kehadiran?tanggal=" + tahun + "-" + bulan + "-" + tanggal;

        // Fungsi untuk mengisi opsi dropdown dari API
        function fillDropdownOptions() {
            var opdSelect = document.getElementById('opdSelect');

            // Mengambil data dari API untuk mengisi opsi dropdown
            fetch(apiUrl)
                .then(response => response.json())
                .then(apiData => {
                    // Menghapus opsi yang sudah ada (kecuali opsi "Semua OPD")
                    opdSelect.innerHTML = '<option value="">Semua OPD</option>';

                    // Menambahkan opsi berdasarkan data dari API
                    apiData.data.forEach(function(entry) {
                        var option = document.createElement('option');
                        option.value = entry.nama_opd;
                        option.text = entry.nama_opd;
                        opdSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching data for dropdown options:', error));
        }

        // Panggil fungsi fillDropdownOptions untuk mengisi opsi dropdown pertama kali
        fillDropdownOptions();

        // Fungsi untuk mengambil data dari API dan mengupdate chart
        function updateChart() {
            var selectedOpd = document.getElementById('opdSelect').value;

            // Mengambil data dari API
            fetch(apiUrl)
                .then(response => response.json())
                .then(apiData => {
                    // Filter data berdasarkan OPD yang dipilih
                    var filteredData = apiData.data.filter(entry => selectedOpd === '' || entry.nama_opd ===
                        selectedOpd);

                    // Grouping data by OPD
                    var groupedData = {};
                    filteredData.forEach(function(entry) {
                        groupedData[entry.nama_opd] = {
                            'Jumlah Pegawai': entry.jumlah_pegawai,
                            'Hadir': entry.jumlah_hadir,
                            'Dinas': entry.jumlah_dinas,
                            'Izin': entry.jumlah_izin,
                            'Sakit': entry.jumlah_sakit,
                            'Cuti': entry.jumlah_cuti,
                            'Tanpa Keterangan': entry.jumlah_tanpa_keterangan,
                        };
                    });

                    // Clear existing chart containers
                    var chartContainer = document.getElementById('chartContainer');
                    chartContainer.innerHTML = '';

                    // Iterate over each OPD and create a bar chart
                    Object.keys(groupedData).forEach(function(opdName) {
                        var opdData = groupedData[opdName];

                        // Prepare data for Chart.js
                        var chartData = {
                            labels: Object.keys(opdData),
                            datasets: [{
                                label: opdName,
                                data: Object.values(opdData),
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)',
                                    'rgba(201, 203, 207, 0.2)',
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(201, 203, 207, 1)',
                                ],
                                borderWidth: 1,
                            }],
                        };

                        // Create Chart
                        var canvas = document.createElement('canvas');


                        var ctx = canvas.getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: chartData,
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            },
                        });

                        chartContainer.appendChild(canvas);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    </script>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
