@extends('layouts.master')
@push('css')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endpush
@section('title-page', 'Data manager')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.manager.create') }}" class="btn btn-icon btn-primary rounded-0"><i
                            class="fa fa-plus"></i> Tambah data</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($manager as $no => $item)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $item->nama_lengkap }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            <a href="{{ route('admin.manager.edit', $item->manager_id) }}"
                                                class="btn btn-info"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-danger delete"
                                                data-href="{{ route('admin.manager.delete', $item->manager_id) }}"
                                                data-name="{{ $item->nama_lengkap }}"><i class="fa fa-trash"></i></a>
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
                        text: 'Kamu akan menghapus data ' + nama,
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
