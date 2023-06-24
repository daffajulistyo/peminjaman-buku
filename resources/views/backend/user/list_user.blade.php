@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header info">
                    <h3 class="card-title">User List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a href="{{ route('user.show') }}" class="btn btn-mm btn-primary mb-2">+ Tambah Anggota</a>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; ?>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td> {{ $user->email }} </td>
                                    <td>
                                        @php
                                            
                                            if ($user->role == 1) {
                                                echo 'Admin';
                                            }
                                            if ($user->role == 2) {
                                                echo 'User';
                                            }
                                            
                                        @endphp

                                    </td>
                                    <td>
                                        <a href="{{ URL::to('user/edit_user/' . $user->id) }}" class="btn btn-sm btn-info">Edit</a>
                                        <a href="{{ URL::to('user/delete_user/' . $user->id) }}" class="btn btn-sm btn-danger"
                                            id="delete" class="middle-align">Delete</a>

                                    </td>
                                </tr>
                                <?php $no++ ;?>
                            @endforeach

                        </tbody>
              
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
