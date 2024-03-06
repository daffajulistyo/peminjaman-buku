@extends('backend.layouts.app')

@section('content')

    @if (Auth::user()->role != 4)
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{ __('Dashboard') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            SELAMAT DATANG, <b> {{ Auth::user()->name }} </b>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif

    @if (Auth::user()->role == 4)
        @include('chart')
    @endif
@endsection
