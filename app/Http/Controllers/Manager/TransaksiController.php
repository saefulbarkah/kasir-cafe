<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function riwayatTransaksi()
    {
        $transaksi = Transaksi::join('pelanggan', 'pelanggan.id', '=', 'transaksi.pelanggan_id')
            ->join('kasir', 'kasir.id', '=', 'transaksi.kasir_id')
            ->join('users', 'users.id', '=', 'kasir.user_id')
            ->orderBy('users.nama_lengkap', 'ASC')
            ->get();
        // dd($transaksi);
        return view('manager.riwayat_transaksi.index', compact('transaksi'));
    }

    public function filter(Request $request)
    {
        // validate
        if ($request->has('from_date')) {
            if ($request->from_date != null) {
                $validate = Validator::make($request->all(), [
                    'from_date' => 'before_or_equal:to_date',
                    'to_date' => 'after_or_equal:from_date',
                ]);
                if ($validate->fails()) {
                    return redirect()
                        ->route('manager.riwayat.transaksi')
                        ->withErrors($validate)
                        ->withInput();
                }
                $from_date = $request->from_date;
                $to_date = $request->to_date;
                $transaksi = Transaksi::join('pelanggan', 'pelanggan.id', '=', 'transaksi.pelanggan_id')
                    ->join('kasir', 'kasir.id', '=', 'transaksi.kasir_id')
                    ->join('users', 'users.id', '=', 'kasir.user_id')
                    ->whereBetween('tgl_transaksi', [$from_date, $to_date])
                    ->get();
                if ($transaksi->isEmpty()) {
                    return redirect()->route('manager.riwayat.transaksi')->with('error', 'Data tidak ditemukan!');
                }
                $show = true;
                return view('manager.riwayat_transaksi.index', compact('transaksi', 'show'));
            }
            return redirect()->back()->with('error', 'Data tidak di temukan');
        }
    }
}
