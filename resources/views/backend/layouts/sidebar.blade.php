<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('backend/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
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
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->



                @if (Auth::user()->role == 1)
                    <li class="nav-item">
                        <a href="{{ route('book.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                List Book
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('book.show') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Add Book
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('user.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                List User
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('loan.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Loan
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </p>
                        </a>
                    </li>
                @endif


                @if (Auth::user()->role == 2)
                    <li class="nav-item">
                        <a href="{{ URL::to('/list_book') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                List Book
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </p>
                        </a>
                    </li>
                @endif


                <li class="nav-item">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-th"></i> Logout
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
