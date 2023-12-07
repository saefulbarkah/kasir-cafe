@extends('layouts.master')
@push('css')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
@endpush
@section('title-page', 'Riwayat Transaksi')
@section('content')
    @if ($errors->any())
        <div class="row">
            <div class="col">
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        Kesalahan isi format tanggal
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Filter transaksi</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('manager.riwayat.transaksi.filter') }}"
                        class="justify-content-right">
                        <div class="form-row">
                            <div class="form-group col-md-6 col-lg-3">
                                <label for="inputEmail4">Dari tanggal</label>
                                <input type="text" name="from_date" max="{{ date('Y-m-d') }}"
                                    class="form-control datepicker @error('from_date') is-invalid @enderror">
                                @error('from_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 col-lg-3">
                                <label for="inputPassword4">Sampai tanggal</label>
                                <input type="text" name="to_date" max="{{ date('Y-m-d') }}"
                                    class="form-control datepicker @error('to_date') is-invalid @enderror">
                                @error('to_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 col-lg-5">
                                <label>&nbsp;</label>
                                <div class="">
                                    <button class="btn btn-primary text-right" name="cari" value="cari">
                                        <i class="fas fa-search"></i>
                                        Cari
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
                    <h4>Riwayat Transaksi</h4>
                    @isset($show)
                        <a href="{{ route('manager.riwayat.transaksi') }}" class="btn btn-primary rounded-0">
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
                                    <th>Kode Transaksi</th>
                                    <th>Nama kasir</th>
                                    <th>Nama pelanggan</th>
                                    <th>Total Pembayaran</th>
                                    <th>Nominal</th>
                                    <th>Kembalian</th>
                                    <th>Tanggal Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi as $no => $data)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>
                                            <span class="badge badge-danger">
                                                {{ $data->kode_transaksi }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>
                                                {{ $data->nama_lengkap }}
                                            </strong>
                                        </td>
                                        <td>
                                            <strong>
                                                {{ $data->nama_pelanggan }}
                                            </strong>
                                        </td>
                                        <td>
                                            Rp. {{ number_format($data->jumlah_pembayaran) }}
                                        </td>
                                        <td>
                                            Rp. {{ number_format($data->total_bayar) }}
                                        </td>
                                        <td>
                                            Rp. {{ number_format($data->kembalian) }}
                                        </td>
                                        <td>{{ $data->tgl_transaksi }}</td>
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
