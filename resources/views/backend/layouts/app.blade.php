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
    <!-- End Datatables -->
    <!-- Toster and Sweet Alert -->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/toastr.css') }}"> -->
    <!-- End Toaster and Sweet Alert-->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo_pasaman.png') }}" />
    <script src="https://cdn.jsdelivr.net/npm/geolib@3.3.3/lib/index.min.js"></script>

    <style>
        .rangkasurat {
            width: 100%;
            margin: 0 auto;
            /* background-color: #fff; */
            padding: 20px;
        }

        .overlay-image {
            position: absolute;
            top: 1.1cm;
            /* left: 20; */
            width: 70px
        }

        .absen-button {
            padding: 8px;
            background-color: #118ab2;
            text-align: center;
            width: 100%;
            height: 100px;
            color: white;
            border-radius: 8px;
            border: none;
            margin: 4px;
            box-shadow: none;
            transition: background-color 0.3s ease;
            font-size: 18px;
            font-family: 'Jetbrains Mono', monospace;
            font-weight: 600;
        }

        .absen-button-pulang {
            padding: 8px;
            background-color: #06d6a0;
            text-align: center;
            width: 100%;
            height: 100px;
            color: white;
            border-radius: 8px;
            border: none;
            margin: 4px;
            box-shadow: none;
            transition: background-color 0.3s ease;
            font-size: 18px;
            font-family: 'Jetbrains Mono', monospace;
            font-weight: 600;

        }

        table.report-absen {
            border-bottom: 5px solid # 000;
            padding: 2px
        }

        .tengah {
            text-align: center;
            line-height: 5px;
        }

        .kiri {
            text-align: left
        }

        .kanan {
            text-align: right
        }

        th.b3 {
            background-color: pink;
            text-align: center;

        }

        .rata-tengah {
            text-align: center;
            padding: 4px
        }

        .name-nowrap {
            padding: 3px;
            white-space: nowrap;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    @php
        $activeRoute = request()->route()->getName();
    @endphp

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">



                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('backend.layouts.sidebar')

        <!-- End Main Sidebar Container -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <!-- <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Starter Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>  -->
            <!-- /.content-header-->
            <br>
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @include('backend.flash-message')

                    @yield('content')

                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        {{-- @include('backend.layouts.footer') --}}

        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->
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
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                });
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
                $('#userTable').DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "paging": false,
                    "info": false,


                });
                $('#absensiTable').DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "paging": false,

                });
                $("#exampleTable").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "paging": false,
                    "info": false,
                    "searching": false,

                });

            });
        </script>


        <!-- End Datatables -->

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
