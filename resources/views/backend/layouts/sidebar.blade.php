<aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-bold">SIPON</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('backend/dist/img/user8-128x128.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @if (Auth::user()->role == 1)
                    <li
                        class="nav-item
                {{ $activeRoute == 'bidang.index' || $activeRoute == 'jabatan.index' ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ $activeRoute == 'bidang.index' || $activeRoute == 'jabatan.index' ? 'active' : '' }}"
                            id="absenToggle">
                            <i class="nav-icon fas fa-address-book"></i>
                            <p>
                                Data Master
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul id="absenSubMenu" class="nav nav-treeview">
                            <li class="nav-item {{ $activeRoute == 'bidang.index' ? 'menu-open' : '' }}">
                                <a href="{{ route('bidang.index') }}"
                                    class="nav-link {{ $activeRoute == 'bidang.index' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-ibook"></i>
                                    <p>Bidang</p>
                                </a>
                            </li>
                            <li class="nav-item {{ $activeRoute == 'jabatan.index' ? 'menu-open' : '' }}">
                                <a href="{{ route('jabatan.index') }}"
                                    class="nav-link {{ $activeRoute == 'jabatan.index' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-ibook"></i>
                                    <p>Jabatan</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (Auth::user()->role == 1 || Auth::user()->role == 3)
                    @if (Auth::user()->role != 3)
                        <li
                            class="nav-item
                        {{ $activeRoute == 'absensi.index' || $activeRoute == 'dinas.index' || $activeRoute == 'cuti.index' || $activeRoute == 'izin.index' || $activeRoute == 'sakit.index' ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ $activeRoute == 'absensi.index' || $activeRoute == 'dinas.index' || $activeRoute == 'cuti.index' || $activeRoute == 'izin.index' || $activeRoute == 'sakit.index' ? 'active' : '' }}"
                                id="absenToggle">
                                <i class="nav-icon fas fa-address-book"></i>
                                <p>
                                    Absen
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul id="absenSubMenu" class="nav nav-treeview">
                                <li class="nav-item {{ $activeRoute == 'absensi.index' ? 'menu-open' : '' }}">
                                    <a href="{{ route('absensi.index') }}"
                                        class="nav-link {{ $activeRoute == 'absensi.index' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-ibook"></i>
                                        <p>Hadir</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ $activeRoute == 'dinas.index' ? 'menu-open' : '' }}">
                                    <a href="{{ route('dinas.index') }}"
                                        class="nav-link {{ $activeRoute == 'dinas.index' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-ibook"></i>
                                        <p>Dinas</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ $activeRoute == 'cuti.index' ? 'menu-open' : '' }}">
                                    <a href="{{ route('cuti.index') }}"
                                        class="nav-link {{ $activeRoute == 'cuti.index' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-ibook"></i>
                                        <p>Cuti</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ $activeRoute == 'izin.index' ? 'menu-open' : '' }}">
                                    <a href="{{ route('izin.index') }}"
                                        class="nav-link {{ $activeRoute == 'izin.index' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-ibook"></i>
                                        <p>Izin</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ $activeRoute == 'sakit.index' ? 'menu-open' : '' }}">
                                    <a href="{{ route('sakit.index') }}"
                                        class="nav-link {{ $activeRoute == 'sakit.index' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-ibook"></i>
                                        <p>Sakit</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                        class="nav-item {{ $activeRoute == 'tugas.index' || $activeRoute == 'tugas.show' ? 'menu-open' : '' }}">
                        <a href="{{ route('tugas.index') }}"
                            class="nav-link {{ $activeRoute == 'tugas.index' || $activeRoute == 'tugas.show' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Tugas Belajar
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </p>
                        </a>
                    </li>
                    @endif



                    <li
                        class="nav-item {{ $activeRoute == 'user.index' || $activeRoute == 'user.show' ? 'menu-open' : '' }}">
                        <a href="{{ route('user.index') }}"
                            class="nav-link {{ $activeRoute == 'user.index' || $activeRoute == 'user.show' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Data Pegawai
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </p>
                        </a>
                    </li>
                    @if (Auth::user()->role == 3)
                        <li class="nav-item {{ $activeRoute == 'master.index' ? 'menu-open' : '' }}">
                            <a href="{{ route('master.index') }}"
                                class="nav-link {{ $activeRoute == 'master.index' || $activeRoute == 'bidang.index' || $activeRoute == 'opd.index' || $activeRoute == 'jabatan.index' || $activeRoute == 'pangkat.index' || $activeRoute == 'eselon.index' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Data Master
                                    <!-- <span class="right badge badge-danger">New</span> -->
                                </p>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeRoute == 'koordinat.index' ? 'menu-open' : '' }}">
                            <a href="{{ route('koordinat.index') }}"
                                class="nav-link {{ $activeRoute == 'koordinat.index' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-map"></i>
                                <p>
                                    Koordinat Kantor
                                    <!-- <span class="right badge badge-danger">New</span> -->
                                </p>
                            </a>
                        </li>

                        <li
                            class="nav-item {{ $activeRoute == 'report.index' || $activeRoute == 'report.minggu' || $activeRoute == 'report.hari' || $activeRoute == 'filter.admin' ? 'menu-open' : '' }}">
                            <a href="{{ route('report.index') }}"
                                class="nav-link {{ $activeRoute == 'report.index' || $activeRoute == 'report.minggu' || $activeRoute == 'report.hari' || $activeRoute == 'filter.admin' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-print"></i>
                                <p>
                                    Laporan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul id="absenSubMenu" class="nav nav-treeview">
                                <li class="nav-item {{ $activeRoute == 'report.index' ? 'menu-open' : '' }}">
                                    <a href="{{ route('report.index') }}"
                                        class="nav-link {{ $activeRoute == 'report.index' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-ibook"></i>
                                        <p>Bulanan</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ $activeRoute == 'report.minggu' ? 'menu-open' : '' }}">
                                    <a href="{{ route('report.minggu') }}"
                                        class="nav-link {{ $activeRoute == 'report.minggu' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-ibook"></i>
                                        <p>Mingguan</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ $activeRoute == 'report.hari' ? 'menu-open' : '' }}">
                                    <a href="{{ route('report.hari') }}"
                                        class="nav-link {{ $activeRoute == 'report.hari' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-ibook"></i>
                                        <p>Harian</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ $activeRoute == 'filter.admin' ? 'menu-open' : '' }}">
                                    <a href="{{ route('filter.admin') }}"
                                        class="nav-link {{ $activeRoute == 'filter.admin' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-ibook"></i>
                                        <p>Nama</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li
                            class="nav-item
                        {{ $activeRoute == 'libur.index' ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ $activeRoute == 'libur.index' ? 'active' : '' }}"
                                id="absenToggle">
                                <i class="nav-icon fa fa-calendar"></i>
                                <p>
                                    Kalender
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul id="absenSubMenu" class="nav nav-treeview">
                                <li class="nav-item {{ $activeRoute == 'libur.index' ? 'menu-open' : '' }}">
                                    <a href="{{ route('libur.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-ibook"></i>
                                        <p>Libur Nasional</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ $activeRoute == 'faqs.index' ? 'menu-open' : '' }}">
                            <a href="{{ route('faqs.index') }}"
                                class="nav-link {{ $activeRoute == 'faqs.index' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-question"></i>
                                <p>
                                    Faq
                                </p>
                            </a>
                        </li>
                    @endif



                    @if (Auth::user()->role != 3)
                        <li
                            class="nav-item {{ $activeRoute == 'report.index' || $activeRoute == 'report.opd.nama' || $activeRoute == 'report.minggu' || $activeRoute == 'report.hari' ? 'menu-open' : '' }}">
                            <a href="{{ route('report.index') }}"
                                class="nav-link {{ $activeRoute == 'report.index' || $activeRoute == 'report.opd.nama' || $activeRoute == 'report.minggu' || $activeRoute == 'report.hari' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-print"></i>
                                <p>
                                    Laporan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul id="absenSubMenu" class="nav nav-treeview">
                                <li class="nav-item {{ $activeRoute == 'report.index' ? 'menu-open' : '' }}">
                                    <a href="{{ route('report.index') }}"
                                        class="nav-link {{ $activeRoute == 'report.index' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-ibook"></i>
                                        <p>Bulanan</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ $activeRoute == 'report.minggu' ? 'menu-open' : '' }}">
                                    <a href="{{ route('report.minggu') }}"
                                        class="nav-link {{ $activeRoute == 'report.minggu' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-ibook"></i>
                                        <p>Mingguan</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ $activeRoute == 'report.hari' ? 'menu-open' : '' }}">
                                    <a href="{{ route('report.hari') }}"
                                        class="nav-link {{ $activeRoute == 'report.hari' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-ibook"></i>
                                        <p>Harian</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ $activeRoute == 'report.opd.nama' ? 'menu-open' : '' }}">
                                    <a href="{{ route('report.opd.nama') }}"
                                        class="nav-link {{ $activeRoute == 'report.opd.nama' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-ibook"></i>
                                        <p>Per Nama</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

                @if (Auth::user()->role == 4)
                    <li class="nav-item {{ $activeRoute == 'report.hari' ? 'menu-open' : '' }}">
                        <a href="{{ route('report.hari') }}"
                            class="nav-link {{ $activeRoute == 'report.hari' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-print"></i>
                            <p>
                                Laporan Harian
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </p>
                        </a>
                    </li>
                    <li class="nav-item {{ $activeRoute == 'report.minggu' ? 'menu-open' : '' }}">
                        <a href="{{ route('report.minggu') }}"
                            class="nav-link {{ $activeRoute == 'report.minggu' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-print"></i>
                            <p>
                                Laporan Mingguan
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </p>
                        </a>
                    </li>
                    <li class="nav-item {{ $activeRoute == 'report.index' ? 'menu-open' : '' }}">
                        <a href="{{ route('report.index') }}"
                            class="nav-link {{ $activeRoute == 'report.index' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-print"></i>
                            <p>
                                Laporan Bulanan
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </p>
                        </a>
                    </li>
                    <li class="nav-item {{ $activeRoute == 'filter.admin' ? 'menu-open' : '' }}">
                        <a href="{{ route('filter.admin') }}"
                            class="nav-link {{ $activeRoute == 'filter.admin' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-print"></i>
                            <p>
                                Laporan
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </p>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role == 2)
                    <li class="nav-item
                {{ $activeRoute == 'absensi.index' ? 'menu-open' : '' }}">
                        <a href="{{ route('absensi.index') }}"
                            class="nav-link {{ $activeRoute == 'absensi.index' ? 'active' : '' }}" id="absenToggle">
                            <i class="nav-icon fas fa-address-book"></i>
                            <p>
                                Presensi
                            </p>
                        </a>

                    </li>
                    <li class="nav-item
                {{ $activeRoute == 'dinas.index' ? 'menu-open' : '' }}">
                        <a href="{{ route('dinas.index') }}"
                            class="nav-link {{ $activeRoute == 'dinas.index' ? 'active' : '' }}" id="absenToggle">
                            <i class="nav-icon fas fa-taxi"></i>
                            <p>
                                Dinas
                            </p>
                        </a>

                    </li>
                    <li class="nav-item
                {{ $activeRoute == 'izin.index' ? 'menu-open' : '' }}">
                        <a href="{{ route('izin.index') }}"
                            class="nav-link {{ $activeRoute == 'izin.index' ? 'active' : '' }}" id="absenToggle">
                            <i class="nav-icon fas fa-calendar"></i>
                            <p>
                                Izin
                            </p>
                        </a>

                    </li>
                    <li class="nav-item
                {{ $activeRoute == 'cuti.index' ? 'menu-open' : '' }}">
                        <a href="{{ route('cuti.index') }}"
                            class="nav-link {{ $activeRoute == 'cuti.index' ? 'active' : '' }}" id="absenToggle">
                            <i class="nav-icon fas fa-umbrella"></i>
                            <p>
                                Cuti
                            </p>
                        </a>

                    </li>
                    <li class="nav-item
                {{ $activeRoute == 'sakit.index' ? 'menu-open' : '' }}">
                        <a href="{{ route('sakit.index') }}"
                            class="nav-link {{ $activeRoute == 'sakit.index' ? 'active' : '' }}" id="absenToggle">
                            <i class="nav-icon fas fa-medkit"></i>
                            <p>
                                Sakit
                            </p>
                        </a>

                    </li>
                    <li class="nav-item
                {{ $activeRoute == 'report.nama' ? 'menu-open' : '' }}">
                        <a href="{{ route('report.nama') }}"
                            class="nav-link {{ $activeRoute == 'report.nama' ? 'active' : '' }}" id="absenToggle">
                            <i class="nav-icon fas fa-print"></i>
                            <p>
                                Laporan
                            </p>
                        </a>

                    </li>
                @endif


                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-lock"></i>
                        <p>Logout</p>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
