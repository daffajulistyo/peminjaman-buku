<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPON - Sistim Informasi Presensi Online</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Tambahkan link ke SweetAlert2 di bagian head HTML -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo_pasaman.png') }}" />
    <script src="https://cdn.jsdelivr.net/npm/geolib@3.3.3/lib/index.min.js"></script>


</head>

<body>
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card card-widget widget-user-2">
                <div class="widget-user-header bg-success">

                    <h3 class="text-center text-uppercase">{{ $opd_name }}</h3>
                    <h5 class="text-center">{{ \Carbon\Carbon::today()->locale('id_ID')->translatedFormat('l, j F Y') }}
                    </h5>
                </div>
                <div class="card-footer p-0">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link text-dark">
                                Jumlah Pegawai <span class="float-right badge bg-success">{{ $userCount }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-dark">
                                Kurang <span class="float-right badge bg-success">{{ $kurang }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-dark">
                                Hadir <span class="float-right badge bg-success">{{ $hadir }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-dark text-center text-bold">
                                Keterangan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-dark">
                                Dinas <span class="float-right badge bg-success">{{ $dinas }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-dark">
                                Izin <span class="float-right badge bg-success">{{ $izin }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-dark">
                                Cuti <span class="float-right badge bg-success">{{ $cuti }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-dark">
                                Sakit <span class="float-right badge bg-success">{{ $sakit }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-dark">
                                Tanpa Keterangan <span
                                    class="float-right badge bg-success">{{ $tanpaKeteranganCount }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.widget-user -->

        </div>
    </div>
    @if(count($tanpaKeteranganList) > 0)
        
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card card-widget widget-user-2">
                <div class="widget-user-header bg-success">
                    <h3 class="text-center text-uppercase">Tanpa Keterangan</h3>
                </div>
                <div class="card-footer p-0">
                    <ul class="nav flex-column">
                        @foreach ($tanpaKeteranganList as $tk)
                            <li class="nav-item">
                                <a href="#" class="nav-link text-dark">
                                    {{ $tk }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(count($dinasList) > 0)

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card card-widget widget-user-2">
                <div class="widget-user-header bg-success">
                    <h3 class="text-center text-uppercase">Dinas </h3>
                </div>
                <div class="card-footer p-0">
                    <ul class="nav flex-column">
                        @foreach ($dinasList as $dinas)
                            <li class="nav-item">
                                <a href="#" class="nav-link text-dark">
                                    {{ $dinas }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(count($izinList) > 0)

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card card-widget widget-user-2">
                <div class="widget-user-header bg-success">
                    <h3 class="text-center text-uppercase">Izin </h3>
                </div>
                <div class="card-footer p-0">
                    <ul class="nav flex-column">
                        @foreach ($izinList as $izin)
                            <li class="nav-item">
                                <a href="#" class="nav-link text-dark">
                                    {{ $izin }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(count($sakitList) > 0)

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card card-widget widget-user-2">
                <div class="widget-user-header bg-success">
                    <h3 class="text-center text-uppercase">Sakit </h3>
                </div>
                <div class="card-footer p-0">
                    <ul class="nav flex-column">
                        @foreach ($sakitList as $sakit)
                            <li class="nav-item">
                                <a href="#" class="nav-link text-dark">
                                    {{ $sakit }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(count($absensiList) > 0)
        
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card card-widget widget-user-2">
                <div class="widget-user-header bg-success">
                    <h3 class="text-center text-uppercase">Hadir</h3>
                </div>
                <div class="card-footer p-0">
                    <ul class="nav flex-column">
                        @foreach ($absensiList as $hadir)
                            <li class="nav-item">
                                <a href="#" class="nav-link text-dark">
                                    {{ $hadir }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- jQuery -->
    <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>



    <script>
        $(document).on("click", "#delete", function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            swal({
                    title: "Apakah Anda ingin menghapus?",
                    text: "Setelah dihapus, ini akan terhapus secara permanen!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = link;
                    }
                });
        });
    </script>

    <!-- <script src="{{ asset('backend/js/toastr.min.js') }}"></script> -->
    <script src="{{ asset('backend/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('backend/js/yourjavascript.js') }}"></script>
    {{-- <script src="{{ asset('backend/js/absenLocation.js') }}"></script> --}}


    <!-- End  Sweet Alert and Toaster notifications -->
    <!-- Pastikan Anda sudah menyertakan jQuery di halaman Anda -->

</body>

</html>
