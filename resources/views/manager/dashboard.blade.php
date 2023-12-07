@extends('layouts.master')
@section('title-page', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-burger"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Menu</h4>
                    </div>
                    <div class="card-body">
                        {{ $count['menu'] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Kasir</h4>
                    </div>
                    <div class="card-body">
                        {{ $count['kasir'] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-hand-holding-dollar"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total pendapatan</h4>
                    </div>
                    <div class="card-body">
                        Rp.{{ number_format($count['pendapatan']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card gradient-bottom">
                <div class="card-header">
                    <h4>5 Menu Favorit</h4>
                    <div class="card-header-action">
                        <i class="fa fa-calendar"></i>
                        <strong href="#">
                            Bulan
                            {{ Carbon\Carbon::now()->locale('id')->isoFormat('MMMM, Y') }}</strong>
                    </div>
                </div>
                <div class="card-body" id="top-5-scroll" tabindex="2"
                    style="height: 315px; overflow: hidden; outline: none;">
                    <ul class="list-unstyled list-unstyled-border">
                        @if ($menu->isEmpty())
                            <div class="text-center">
                                <div class="font-weight-600 text-muted">
                                    Tidak ada menu favorit
                                </div>
                                <h3>
                                    <i class="fas fa-circle-notch fa-spin fa-10x"></i>
                                </h3>
                            </div>
                        @else
                            @foreach ($menu as $data)
                                <li class="media">
                                    <img class="mr-3 rounded" width="55"
                                        src="{{ asset('myAssets/menu/' . $data->gambar) }}" alt="product">
                                    <div class="media-body">
                                        <div class="float-right">
                                            <div class="font-weight-600 text-muted text-small">Total penjualan :
                                                {{ $data->total_penjualan }}
                                            </div>
                                        </div>
                                        <div class="media-title">{{ $data->nama_menu }}</div>
                                        <div class="mt-1">
                                            <div class="budget-price">
                                                <div class="budget-price-square bg-primary" id="pendapatan">
                                                </div>
                                                <div class="budget-price-label">
                                                    <strong>Rp. {{ number_format($data->total_pendapatan) }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="card-footer pt-3 d-flex justify-content-center">
                    <div class="budget-price justify-content-center">
                        <div class="budget-price-square bg-primary" data-width="20" style="width: 20px;"></div>
                        <div class="budget-price-label">Pendapatan penjualan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
