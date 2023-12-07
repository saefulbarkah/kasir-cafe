@extends('layouts.master')
@push('css')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link href="{{ asset('node_modules/bootstrap-datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet">
@endpush
@section('title-page', 'Laporan Pendapatan')
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Filter Berdasarkan tanggal</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('manager.pendapatan.filter') }}" class="justify-content-right">
                        <div class="form-row">
                            <div class="form-group col-md-6 col-lg-6">
                                <label for="inputEmail4">Dari tanggal</label>
                                <input type="text" name="from_date" max="{{ date('Y-m-d') }}"
                                    class="form-control datepicker @error('from_date') is-invalid @enderror">
                                @error('from_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 col-lg-6">
                                <label for="inputPassword4">Sampai tanggal</label>
                                <input type="text" name="to_date" max="{{ date('Y-m-d') }}"
                                    class="form-control datepicker @error('to_date') is-invalid @enderror">
                                @error('to_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 col-lg-12">
                                <label>&nbsp;</label>
                                <div class="">
                                    <button class="btn btn-primary text-right" name="cari" value="cari">
                                        <i class="fas fa-search"></i>
                                        Cari
                                    </button>
                                    <button class="btn btn-success text-right" name="cetak" value="cetak">
                                        <i class="fas fa-print"></i>
                                        Cetak laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Filter Berdasarkan bulan</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('manager.pendapatan.filter.bulan') }}"
                        class="justify-content-right">
                        <div class="form-row">
                            <div class="form-group col-md-6 col-lg-12">
                                <label for="inputEmail4">Bulan</label>
                                <input type="text" name="month"
                                    class="form-control monthPicker @error('month') is-invalid @enderror"
                                    value="{{ date('Y-m') }}">
                                @error('month')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 col-lg-12">
                                <label>&nbsp;</label>
                                <div class="">
                                    <button class="btn btn-primary text-right" name="cari" value="cari">
                                        <i class="fas fa-search"></i>
                                        Cari
                                    </button>
                                    <button class="btn btn-success text-right" name="cetak" value="cetak">
                                        <i class="fas fa-print"></i>
                                        Cetak laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Pendapatan</h4>
                    @isset($show)
                        <a href="{{ route('manager.laporan.pendapatan') }}" class="btn btn-primary rounded-0">
                            <i class="fas fa-list"></i>
                            Tampilkan semua data
                        </a>
                    @endisset
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Waktu</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendapatan as $no => $data)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        @if (Request::has('month'))
                                            <td>{{ Carbon\Carbon::parse($data->day)->locale('id')->isoFormat('MMMM, Y') }}
                                            </td>
                                        @else
                                            <td>{{ Carbon\Carbon::parse($data->day)->locale('id')->isoFormat('dddd, D MMMM, Y') }}
                                            </td>
                                        @endif
                                        <td>Rp. {{ number_format($data->pendapatan) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <!-- JS Libraies -->
        <script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('node_modules/sweetalert/dist/sweetalert.min.js') }}"></script>
        <script src="{{ asset('node_modules/izitoast/dist/js/iziToast.min.js') }}"></script>
        <script src="{{ asset('node_modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('node_modules/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
        <script>
            $(".monthPicker").datepicker({
                format: "yyyy-mm",
                startView: "months",
                minViewMode: "months"
            });
        </script>
        @if (Session::has('error'))
            <script>
                iziToast.settings({
                    timeout: 3000,
                    resetOnHover: true,
                    icon: 'material-icons',
                    transitionIn: 'fadeInUp',
                    transitionIn: 'flipInY',
                    transitionOut: 'fadeOutUp',
                    transitionInMobile: 'fadeInUp',
                    transitionOutMobile: 'fadeOutDown',

                });
                iziToast.show({
                    theme: 'dark',
                    icon: 'fas fa-warning',
                    title: 'Kesalahan!',
                    message: '{{ Session::get('error') }}',
                    color: '#df4759',
                    position: 'topCenter'
                });
            </script>
        @endif
        <script>
            $(document).ready(function() {
                $('.myTable').DataTable({
                    "language": {
                        url: "{{ asset('node_modules/datatables/plugins/id.json') }}"
                    }
                });
            });
        </script>
    @endpush
@endsection
