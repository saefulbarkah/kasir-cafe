<?php

namespace App\Http\Controllers\Kasir;

use App\Transaksi;
use App\Kasir;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function riwayat()
    {
        $kasirId    = Kasir::where('user_id', auth()->user()->id)->first();
        $transaksi = Transaksi::join('pelanggan', 'pelanggan.id', '=', 'transaksi.pelanggan_id')
            ->where('kasir_id', $kasirId->id)->get();
        return view('kasir.riwayat_transaksi.index', compact('transaksi'));
    }
}
