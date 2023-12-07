@extends('layouts.master')
@push('css')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
@endpush
@section('title-page', 'Pesanan')
@section('content')
    @if ($pesanan->isNotEmpty())
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h4>Detail pesanan</h4>
                </div>
            </div>
            <div class="col-lg-8 d-flex align-items-stretch">
                <div class="card shadow">
                    <div class="card-header">
                        <h4>Menu</h4>
                    </div>
                    <div class="card-body">
                        @foreach ($pesanan as $item)
                            <div class="row mt-2">
                                <div class="col-lg-3 text-center">
                                    <img src="{{ asset('myAssets/menu/' . $item->gambar) }}" class="img-fluid img-rounded">
                                </div>
                                <div class="col-lg-4 text-center">
                                    <h4>{{ $item->nama_menu }}</h4>
                                    <div class="col-lg-12">
                                        <h5 class="text-danger">Rp. {{ number_format($item->sub_total) }}</h5>
                                    </div>
                                </div>
                                <div class="col-lg-5 mt-4">
                                    <form action="{{ route('kasir.pesanan.update.order', $item->pesanan_id) }}"
                                        method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <input type="hidden" name="pesanan_id" value="{{ $item->id }}"
                                                class="form-control text-center">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <strong>Jumlah</strong>
                                                </div>
                                            </div>
                                            <input type="number" autofocus min="1" name="qty" value="{{ $item->qty }}"
                                                class="form-control text-center">
                                            <div class="input-group-prepend">
                                                <button type="submit" class="btn btn-success ">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                            <div class="input-group-prepend">
                                                <a href="{{ route('kasir.pesanan.delete.order', $item->id) }}"
                                                    class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                        <ul class="list-group">
                            @if ($pesanan->count() > 1)
                                <a href="{{ route('kasir.pesanan.delete.all.order') }}" class="btn btn-danger"> <i
                                        class="fas fa-trash"></i> Batalkan semua pesanan</a>
                            @endif
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                                <strong>Total pembayaran :</strong>
                                <span class="text-danger"><strong id="total"
                                        data-total="{{ $pesanan->sum('sub_total') }}">Rp.
                                        {{ number_format($pesanan->sum('sub_total')) }}</strong></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h4>Transaksi</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('kasir.pesanan.bayar.order') }}" method="POST"
                            class="justify-content-center">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="jumlah_pembayaran" value="{{ $pesanan->sum('sub_total') }}">
                            </div>
                            <div class="form-group">
                                <span class="text-danger">*</span>
                                <label for="">Nama Pelanggan : </label>
                                <input type="text" name="nama_pelanggan" autocomplete="off"
                                    class="form-control @error('nama_pelanggan') is-invalid @enderror">
                                @error('nama_pelanggan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <span class="text-danger">*</span>
                                <label for="">Nominal : </label>
                                <input type="text" name="total_bayar" autocomplete="off"
                                    class="form-control uang @error('total_bayar') is-invalid @enderror @if (Session::has('wronginput')) is-invalid @endif"
                                    id="total_bayar" min="0">
                                @if (Session::has('wronginput'))
                                    <span class="text-danger">Uang tidak mencukupi</span>
                                @endif
                                @error('total_bayar')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="
                                form-group">
                                <label for="">Total pembayaran : </label>
                                <input type="text" class="form-control"
                                    value="Rp.{{ number_format($pesanan->sum('sub_total')) }}" readonly disabled>
                            </div>
                            <div class="
                                form-group">
                                <label for="">Kembalian : </label>
                                <input type="text" name="kembalian" min="0" class="form-control uang" id="kembali" value="0"
                                    readonly>
                            </div>
                            <button type="submit" class="btn btn-success btn-block mt-4" onclick="submitForm(this);">
                                <i class="fas fa-shopping-cart"></i> Bayar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="section-title">
                <h4>Makanan</h4>
            </div>
        </div>
        @foreach ($makanan as $item)
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 d-flex align-item-stretch">
                <article class="article article-style-b shadow" style="width: 100%">
                    <div class="article-header">
                        <div class="article-image img-fluid"
                            data-background="{{ asset('myAssets/menu/' . $item->gambar) }}">
                        </div>
                        <div class="article-badge">
                            <div class="row">
                                <div class="article-badge-item bg-danger">Rp. {{ number_format($item->harga) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="article-details">
                        <div class="article-title">
                            <h2 style="font-size: 18px" class="mb-2 text-center">{{ $item->nama_menu }}</h2>
                            <hr>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                                    Status
                                    @if ($item->status == 'Tersedia')
                                        <span class="badge badge-success badge-pill"><i class="fas fa-check"></i>
                                            {{ $item->status }}</span>
                                    @else
                                        <span class="badge badge-danger badge-pill"><i class="fas fa-x"></i>
                                            Kosong</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <div class="article-cta text-center">
                            <form action="{{ route('kasir.pesanan.add_order') }}" method="POST">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="hidden" name="kasir_id" class="form-control"
                                                    value="{{ $kasirId->id }}">
                                                <input type="hidden" name="harga" class="form-control"
                                                    value="{{ $item->harga }}">
                                                <input type="hidden" name="status" class="form-control"
                                                    value="sedang_dipesan">
                                                <input type="hidden" name="menu_id" class="form-control"
                                                    value="{{ $item->id }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($pesanan->where('menu_id', $item->id)->count() == 1)
                                    <span>
                                        <i class="fas fa-sync fa-spin"></i>
                                        Sedang di pesan
                                    </span>
                                @elseif ($item->status == 'Tersedia')
                                    <button type="submit" class="btn btn-primary btn-block" onclick="submitForm(this);"><i
                                            id="i" class="fas fa-shopping-cart"></i>
                                        <span>
                                            Pesan
                                        </span>
                                    </button>
                                @elseif ($item->status == 'Tidak Tersedia')
                                    <button class="btn btn-danger btn-block kosong">
                                        <i class="fas fa-sync fa-spin"></i>
                                        Menu kosong
                                    </button class="btn btn-danger btn-block">
                                @endif
                            </form>
                        </div>
                    </div>
                </article>
            </div>
        @endforeach
    </div>
    @if ($minuman->isNotEmpty())
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h4>Minuman</h4>
                </div>
            </div>
            @foreach ($minuman as $item)
                <div class="col-12 col-sm-6 col-md-6 col-lg-3 d-flex align-item-stretch">
                    <article class="article article-style-b shadow" style="width: 100%">
                        <div class="article-header">
                            <div class="article-image" data-background="{{ asset('myAssets/menu/' . $item->gambar) }}">
                            </div>
                            <div class="article-badge">
                                <div class="row">
                                    <div class="article-badge-item bg-danger">Rp. {{ number_format($item->harga) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="article-details">
                            <div class="article-title">
                                <h2 style="font-size: 18px" class="mb-2 text-center">{{ $item->nama_menu }}</h2>
                                <hr>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                                        Status
                                        @if ($item->status == 'Tersedia')
                                            <span class="badge badge-success badge-pill"><i class="fas fa-check"></i>
                                                {{ $item->status }}</span>
                                        @else
                                            <span class="badge badge-danger badge-pill"><i class="fas fa-x"></i>
                                                Kosong</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            <div class="article-cta text-center">
                                <form action="{{ route('kasir.pesanan.add_order') }}" method="POST">
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-lg-9">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="hidden" name="kasir_id" class="form-control"
                                                        value="{{ $kasirId->id }}">
                                                    <input type="hidden" name="harga" class="form-control"
                                                        value="{{ $item->harga }}">
                                                    <input type="hidden" name="status" class="form-control"
                                                        value="sedang_dipesan">
                                                    <input type="hidden" name="menu_id" class="form-control"
                                                        value="{{ $item->id }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($pesanan->where('menu_id', $item->id)->count() == 1)
                                        <span>
                                            <i class="fas fa-sync fa-spin"></i>
                                            Sedang di pesan
                                        </span>
                                    @elseif ($item->status == 'Tersedia')
                                        <button type="submit" class="btn btn-primary btn-block"
                                            onclick="submitForm(this);"><i class="fas fa-shopping-cart"></i>
                                            Pesan
                                        </button>
                                    @elseif ($item->status == 'Tidak Tersedia')
                                        <button class="btn btn-danger btn-block kosong">
                                            <i class="fas fa-sync fa-spin"></i>
                                            Menu kosong
                                        </button class="btn btn-danger btn-block">
                                    @endif
                                </form>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    @endif
    @push('js')
        <script>
            $(document).ready(function() {
                $('.myTable').DataTable();
            });
        </script>
        <!-- JS Libraies -->
        <script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
        {{-- <script src="{{ asset('node_modules/sweetalert/dist/sweetalert.min.js') }}"></script> --}}
        <script src="{{ asset('node_modules/izitoast/dist/js/iziToast.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.inputmask.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.uang').inputmask({
                    rightAlign: false,
                    groupSeparator: ".",
                    alias: "numeric",
                })
            });
        </script>
        <script>
            function submitForm(btn) {
                btn.disabled = true;
                // submit the form
                btn.form.submit();
            }
        </script>
        <script>
            $(document).ready(function() {
                $('#total_bayar').keyup(function(e) {
                    var total = parseInt($('#total').attr('data-total'));
                    var total_bayar = parseFloat($('#total_bayar').val().replace(/,/g, ""));
                    var kembali = total - total_bayar;
                    if (total < total_bayar) {
                        var noNegative = Math.abs(kembali)
                        $('#kembali').val(noNegative);
                    } else {
                        $('#kembali').val(0);
                    }
                });
            });
        </script>
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
        <script>
            $('.kosong').click(function(e) {
                e.preventDefault();
                iziToast.settings({
                    timeout: 4000,
                    resetOnHover: true,
                    icon: 'material-icons',
                    transitionIn: 'fadeInUp',
                    transitionIn: 'flipInY',
                    transitionOut: 'fadeOutUp',
                    transitionInMobile: 'fadeInUp',
                    transitionOutMobile: 'fadeOutDown',

                });
                iziToast.error({
                    icon: 'fas fa-x',
                    title: 'Yahhh habis!',
                    message: 'Stock menu sedang kosong',
                    position: 'topCenter'
                });
            });
        </script>
        @if (Session::has('success'))
            <script>
                iziToast.settings({
                    timeout: 4000,
                    resetOnHover: true,
                    icon: 'material-icons',
                    transitionIn: 'fadeInUp',
                    transitionIn: 'flipInY',
                    transitionOut: 'fadeOutUp',
                    transitionInMobile: 'fadeInUp',
                    transitionOutMobile: 'fadeOutDown',

                });
                iziToast.success({
                    icon: 'fas fa-check',
                    title: 'Berhasil!',
                    message: '{{ Session::get('success') }}',
                    position: 'topCenter'
                });
            </script>
        @endif
    @endpush
@endsection
