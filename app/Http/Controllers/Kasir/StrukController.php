<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Pesanan;
use App\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class StrukController extends Controller
{
    public function index($id)
    {
        $getId  =  Crypt::decrypt($id);
        $transaksi = Transaksi::findOrFail($getId);
        $pesanan = Pesanan::join('menus', 'menus.id', '=', 'pesanan.menu_id')
            ->where('detail_pesanan_id', $transaksi->detail_pesanan_id)->get();
        // dd($pesanan);
        return view('kasir.struk.index', compact('transaksi', 'pesanan'));
    }
    public function cetakStruk($id)
    {
        $getId  =  Crypt::decrypt($id);
        $transaksi = Transaksi::findOrFail($getId);
        $pesanan = Pesanan::join('menus', 'menus.id', '=', 'pesanan.menu_id')
            ->where('detail_pesanan_id', $transaksi->detail_pesanan_id)->get();
        // dd($pesanan);
        $pdf = PDF::loadView('kasir.struk.cetak', compact('transaksi', 'pesanan'));
        return $pdf->download($transaksi->kode_transaksi . '.pdf');
    }
}
