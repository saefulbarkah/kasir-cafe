@extends('layouts.master')
@push('css')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endpush
@section('title-page', 'Daftar menu')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('manager.menu.create') }}" class="btn btn-primary btn-square rounded-0"><i
                            class="fa fa-plus"></i> Tambah menu</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama menu</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menu as $no => $item)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>
                                            <img src="{{ asset('myAssets/menu/' . $item->gambar) }}" class="img-fluid"
                                                style="width: 120px" alt="">
                                        </td>
                                        <td>{{ $item->nama_menu }}</td>
                                        <td>{{ $item->kategori }}</td>
                                        <td>Rp. {{ number_format($item->harga) }}</td>
                                        <td>
                                            @if ($item->status == 'Tersedia')
                                                <div class="badge badge-success">
                                                    <i class="fa fa-check"></i> {{ $item->status }}
                                                </div>
                                            @endif
                                            @if ($item->status == 'Tidak Tersedia')
                                                <div class="badge badge-danger">
                                                    <i class="fa fa-x"></i> {{ $item->status }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('manager.menu.edit', $item->id) }}"
                                                class="btn btn-info"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-danger delete"
                                                data-href="{{ route('manager.menu.delete', $item->id) }}"
                                                data-name="{{ $item->nama_menu }}"><i class="fa fa-trash"></i></a>
                                        </td>
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
        <script>
            $(document).ready(function() {
                $('.myTable').DataTable({
                    "language": {
                        url: "{{ asset('node_modules/datatables/plugins/id.json') }}"
                    }
                });
            });
        </script>
        <!-- JS Libraies -->
        <script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('node_modules/sweetalert/dist/sweetalert.min.js') }}"></script>
        <script>
            $('.delete').click(function(e) {
                e.preventDefault();
                var nama = $(this).attr('data-name');
                var url = $(this).attr('data-href');
                swal({
                        title: 'Apakah kamu yakin?',
                        text: 'Kamu akan menghapus ' + nama,
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location.href = url;
                        }
                    });
            });
        </script>

        @if (Session::has('success'))
            <script>
                swal('Berhasil', '{{ Session::get('success') }}', 'success');
            </script>
        @endif
    @endpush
@endsection
