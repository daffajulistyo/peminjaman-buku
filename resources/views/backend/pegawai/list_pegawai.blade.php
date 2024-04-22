@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header info">
                    <h3 class="card-title">Daftar Pegawai</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a href="#" class="btn btn-mm btn-info mb-4 " data-toggle="modal"
                        data-target="#addPegawaiModal">+ Tambah Pegawai</a>
                    @if (Auth::user()->role == 3)
                        <form action="{{ route('user.index') }}" method="GET" class="mb-2">
                            <div class="row justify-content-end">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ request()->query('nama') }}" placeholder="Cari Pegawai">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="opd" name="opd"
                                            value="{{ request()->query('opd') }}" placeholder="Cari Opd">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="nip" name="nip"
                                            value="{{ request()->query('nip') }}" placeholder="Cari NIP/NIK">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-info">Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <form action="{{ route('user.index') }}" method="GET" class="mb-2">
                            <div class="row justify-content-end">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ request()->query('nama') }}" placeholder="Cari Pegawai">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="nip" name="nip"
                                            value="{{ request()->query('nip') }}" placeholder="Cari NIP/NIK">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-info">Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                    <table id="exampleTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>NIP / NIK</th>
                                @if (Auth::user()->role == 3)
                                    <th>OPD</th>
                                @endif
                                <th>Jabatan</th>
                                <th>Pangkat</th>
                                <th>Status</th>
                                <th>Aktif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td> {{ $user->nip ?? '-' }} </td>
                                    @if (Auth::user()->role == 3)
                                        <td>{{ $user->opd ? $user->opd->name : '-' }}</td>
                                    @endif
                                    <td>{{ $user->jabatan ? $user->jabatan->name : '-' }}</td>
                                    <td>{{ $user->pangkat ? $user->pangkat->name : '-' }}</td>
                                    <td>{{ $user->status ?? '-' }}</td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('user.toggle_status', ['id' => $user->id]) }}">
                                            @csrf
                                            @if ($user->is_active == 1)
                                                <button type="submit" class="btn btn-sm btn-outline-success"
                                                    name="is_active" value="1">Online</button>
                                            @else
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    name="is_active" value="0">Offline</button>
                                            @endif
                                        </form>
                                        
                                    </td>


                                    <td style="white-space: nowrap">
                                        <div class="d-flex flex-column">
                                            <div class="dropdown">
                                                <button class="btn btn-info dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-cogs"></i>
                                                </button>
                                                <div class="dropdown-menu w-75 p-2" aria-labelledby="dropdownMenuButton">
                                                    <a href="{{ route('user.edit', ['id' => $user->id]) }}"
                                                        class="btn btn-sm btn-info mb-1 d-flex align-items-center p-2"
                                                        data-toggle="modal"
                                                        data-target="#editUserModal{{ $user->id }}">
                                                        <i class="fas fa-edit mr-2"></i>Edit
                                                    </a>

                                                    <a href="{{ route('user.delete', ['id' => $user->id]) }}"
                                                        class="btn btn-sm btn-danger mb-1 d-flex align-items-center p-2"
                                                        id="delete">
                                                        <i class="fas fa-trash-alt mr-2"></i>Delete
                                                    </a>

                                                    <a href="#resetPasswordModal{{ $user->id }}"
                                                        class="btn btn-sm btn-warning d-flex align-items-center p-2"
                                                        data-toggle="modal">
                                                        <i class="fas fa-key mr-2"></i>Reset Password
                                                    </a>
                                                </div>

                                            </div>

                                        </div>
                                    </td>


                                </tr>
                                @include('backend.modal.reset_password', ['user' => $user])


                                @include('backend.modal.edit_pegawai')

                                <?php $no++; ?>
                            @endforeach


                        </tbody>

                    </table>

                    <div class="pagination justify-content-center mt-2">
                        {{ $users->links() }}
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.toggle-active').change(function() {
                var userId = $(this).data('user-id');
                var isActive = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    type: 'POST',
                    url: '/user/set-active-status',
                    data: {
                        userId: userId,
                        isActive: isActive,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Status aktif diperbarui.');
                    },
                    error: function(xhr, status, error) {
                        console.error('Terjadi kesalahan:', error);
                    }
                });
            });
        });
    </script>

    @include('backend.modal.add_pegawai')
@endsection
