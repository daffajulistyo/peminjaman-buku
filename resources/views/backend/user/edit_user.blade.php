@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <div class="row">

            <div class="col-md-2">

            </div>
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit User for {{ $user->name }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ URL::to('user/update_user/' . $user->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="text">Nama</label>
                                <input type="text" name="name" value="{{ $user->name }}"
                                    class="form-control @error('title') is-invalid @enderror" id="text"
                                    placeholder="Enter User Name">

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" value="{{ $user->email }}"
                                    class="form-control @error('title') is-invalid @enderror" id="text"
                                    placeholder="Enter Your Email">

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                @php
                                    if ($user->role == 1) {
                                        echo 'Present Permission is : <b>Admin</b>';
                                    }
                                    if ($user->role == 2) {
                                        echo 'Present Permission is : <b>User</b>';
                                    }
                                @endphp
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Change the Permission</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="role" required>
                                    <option required> Please Select </option>
                                    <option value="1">Admin </option>
                                    <option value="2">User </option>
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-2">
            </div>
        </div>
        <!-- /.row -->
    </div>
@endsection
