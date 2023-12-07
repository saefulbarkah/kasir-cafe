@extends('layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
@endpush
@section('title-page', 'Struk pembayaran')
@section('content')
    <div class="invoice">
        <div class="invoice-print">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-title">
                        <h2>Struk</h2>
                        <div class="invoice-number">Kode transaksi #{{ $transaksi->kode_transaksi }}</div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="section-title">Ringkasan pesanan</div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-md">
                            <tr>
                                <th data-width="40">#</th>
                                <th>Menu</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-right">Harga total</th>
                            </tr>
                            @foreach ($pesanan as $no => $data)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $data->nama_menu }}</td>
                                    <td class="text-center">Rp. {{ number_format($data->harga) }}</td>
                                    <td class="text-center">{{ $data->qty }}</td>
                                    <td class="text-right">Rp. {{ number_format($data->sub_total) }}</td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12 text-right">
                            <div class="invoice-detail-item">
                                <div class="invoice-detail-name">Total pembayaran</div>
                                <div class="invoice-detail-value invoice-detail-value-lg">Rp.
                                    {{ number_format($transaksi->jumlah_pembayaran) }}</div>
                            </div>
                            <hr class="mt-2 mb-2">
                            <div class="invoice-detail-item">
                                <div class="invoice-detail-name">Nominal</div>
                                <div class="invoice-detail-value">Rp. {{ number_format($transaksi->total_bayar) }}</div>
                            </div>
                            <div class="invoice-detail-item">
                                <div class="invoice-detail-name">Kembalian</div>
                                <div class="invoice-detail-value">Rp. {{ number_format($transaksi->kembalian) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="text-md-right">
            <form action="{{ route('kasir.struk.pembayaran', Crypt::encrypt($transaksi->id)) }}" method="POST">
                <a href="{{ route('kasir.pesanan') }}" class="btn btn-success btn-icon icon-left">
                    <i class="fas fa-check"></i> Selesai</a>
                @csrf
                <button type="submit" class="btn btn-primary btn-icon icon-left"><i class="fas fa-print"></i>
                    Print</button>
            </form>
        </div>
    </div>
    @push('js')
        <script src="{{ asset('node_modules/izitoast/dist/js/iziToast.min.js') }}"></script>
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
