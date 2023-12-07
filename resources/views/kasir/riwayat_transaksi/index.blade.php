@extends('layouts.master')
@push('css')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
@endpush
@section('title-page', 'Riwayat Transaksi')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode transaksi</th>
                                    <th>Nama pelanggan</th>
                                    <th>Jumlah pembayaran</th>
                                    <th>Total bayar</th>
                                    <th>Kembalian</th>
                                    <th>Tanggal transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi as $no => $item)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>
                                            <span class="badge badge-danger">{{ $item->kode_transaksi }}</span>
                                        </td>
                                        <td>{{ $item->nama_pelanggan }}</td>
                                        <td>Rp. {{ number_format($item->jumlah_pembayaran) }}</td>
                                        <td>Rp. {{ number_format($item->total_bayar) }}</td>
                                        <td>Rp. {{ number_format($item->kembalian) }}</td>
                                        <td>{{ $item->tgl_transaksi }}</td>
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
