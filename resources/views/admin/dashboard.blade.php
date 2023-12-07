@extends('layouts.master')

@section('title-page', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total admin</h4>
                    </div>
                    <div class="card-body">
                        {{ $admin }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total manager</h4>
                    </div>
                    <div class="card-body">
                        {{ $manager }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total kasir</h4>
                    </div>
                    <div class="card-body">
                        {{ $kasir }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="{{ asset('node_modules/sweetalert/dist/sweetalert.min.js') }}"></script>
        @if (Session::has('success'))
            <script>
                swal('Berhasil', '{{ Session::get('success') }}', 'success');
            </script>
        @endif
    @endpush
@endsection
