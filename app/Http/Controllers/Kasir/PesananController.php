<?php

namespace App\Http\Controllers\Kasir;

use App\DetailPesanan;
use App\Http\Controllers\Controller;
use App\Kasir;
use App\Menu;
use App\Pelanggan;
use App\Pesanan;
use App\Transaksi;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index()
    {
        $makanan    = Menu::where('kategori', 'Makanan')->orderBy('nama_menu', 'asc')->get();
        $minuman    = Menu::where('kategori', 'Minuman')->orderBy('nama_menu', 'asc')->get();
        $kasirId    = Kasir::where('user_id', auth()->user()->id)->first();
        $pesanan    = Pesanan::join('menus', 'menus.id', '=', 'pesanan.menu_id')
            ->select('menus.id as menu_id', 'menus.*', 'pesanan.id as pesanan_id', 'pesanan.*')
            ->where('menus.status', 'Tersedia')
            ->where('kasir_id', $kasirId->id)
            ->where('pesanan.status', 'sedang_dipesan')
            ->get();

        $deletePesanan  = Pesanan::join('menus', 'menus.id', '=', 'pesanan.menu_id')
            ->select('menus.id as menu_id', 'menus.*', 'pesanan.id as pesanan_id', 'pesanan.*')
            ->where('menus.status', 'Tidak Tersedia')
            ->where('kasir_id', $kasirId->id)
            ->where('pesanan.status', 'sedang_dipesan')
            ->delete();
        return view('kasir.pesanan.index', compact('makanan', 'minuman', 'pesanan', 'kasirId'));
    }

    public function addOrder(Request $request)
    {
        $qty = 1;
        Pesanan::create([
            'kasir_id'      => $request->kasir_id,
            'menu_id'       => $request->menu_id,
            'detail_pesanan_id' => null,
            'qty'           => $qty,
            'status'        => $request->status,
            'sub_total'     => $qty * $request->harga,
        ]);
        return redirect()->back()->with('success', 'Pesanan berhasil di tambahkan');
    }

    public function updateOrder(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $menu = Menu::findOrfail($pesanan->menu_id);
        $pesanan->qty = $request->qty;
        $pesanan->sub_total = $menu->harga * $request->qty;
        $pesanan->save();
        return redirect()->back()->with('success', 'Jumlah pesanan berhasil di update');
    }

    public function bayarOrder(Request $request)
    {
        // dd($request->all());
        // converting
        $total_bayar = str_replace(
            [
                'Rp', ' ', ','
            ],
            '',
            $request->total_bayar,
        );
        $kembalian = str_replace(
            [
                'Rp', ' ', ','
            ],
            '',
            $request->kembalian,
        );
        // query data
        $kasirId    = Kasir::where('user_id', auth()->user()->id)->first();
        $getPesanan = Pesanan::where('kasir_id', $kasirId->id)->where('status', 'sedang_dipesan')->get();
        $pesanan = Pesanan::where('kasir_id', $kasirId->id)->where('status', 'sedang_dipesan')->latest()->max('id');
        // dd($pesanan);
        // validating data
        $request->validate([
            'nama_pelanggan' => 'required',
            'total_bayar'    => 'required',
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi',
            'total_bayar.required'    => 'Total bayar Wajib diisi'
        ]);

        // checkIf total_bayar < total pembayaran
        if ($total_bayar < $request->jumlah_pembayaran) {
            return redirect()->back()->with('wronginput', 'total_bayar tidak mencukupi');
        }

        // creating data pelanggan
        $pelanggan = Pelanggan::create([
            'nama_pelanggan' => $request->nama_pelanggan,
        ]);

        // multi update data pesanan
        foreach ($getPesanan as $data) {
            $update_pesanan = Pesanan::whereIn('id', [$data->id])->update([
                'pelanggan_id' => $pelanggan->id,
                'status' => 'sudah_bayar',
                'detail_pesanan_id' => $pesanan,
            ]);
        }

        // multi insert data detailPesanan
        foreach ($getPesanan as $item) {
            $order_detail = DetailPesanan::create([
                'detail_pesanan_id' => $pesanan,
                'pesanan_id'        => $item->id
            ]);
        }

        // making code trnsaction
        $kode = "KF" . date('Ymd') . "/PG/" . $pelanggan->id;
        // inserting data transaction
        $transaksi = new Transaksi();
        $transaksi->kode_transaksi      = $kode;
        $transaksi->detail_pesanan_id   = $pesanan;
        $transaksi->pelanggan_id        = $pelanggan->id;
        $transaksi->kasir_id            = $kasirId->id;
        $transaksi->jumlah_pembayaran   = $request->jumlah_pembayaran;
        $transaksi->total_bayar         = $total_bayar;
        if ($kembalian == '0') {
            $transaksi->kembalian       = '0';
        } else {
            $transaksi->kembalian       = $kembalian;
        }
        $transaksi->tgl_transaksi       = Carbon::now()->format('Y-m-d');
        $transaksi->save();
        // return back
        return redirect()->route('kasir.struk.pembayaran', Crypt::encrypt($transaksi->id))->with('success', 'Pembayaran berhasil');
    }
    public function deleteOrder($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil di batalkan');
    }
    public function deleteAllOrder()
    {
        $kasirId    = Kasir::where('user_id', auth()->user()->id)->first();
        Pesanan::where('status', 'sedang_dipesan')->where('kasir_id', $kasirId->id)->delete();
        return redirect()->back()->with('success', 'Semua pesanan berhasil di batalkan');
    }
}
