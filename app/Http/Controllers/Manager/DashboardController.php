<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Menu;
use App\Pesanan;
use App\Transaksi;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = [
            'menu' => Menu::count(),
            'kasir' => User::role('kasir')->count(),
            'pendapatan' => Transaksi::sum('jumlah_pembayaran'),
        ];
        $pendapatan = Transaksi::all();
        $menu = Pesanan::select([
            DB::raw('sum(sub_total) as total_pendapatan'),
            DB::raw('sum(qty) as total_penjualan'),
            'menu_id',
            'menus.id',
            'menus.nama_menu',
            'pesanan.created_at',
            'menus.gambar',
        ])
            ->join('menus', 'menus.id', '=', 'pesanan.menu_id')
            ->groupBy('menu_id')
            ->orderBy('total_penjualan', 'DESC')
            ->orderBy('nama_menu', 'ASC')
            ->where('pesanan.status', 'sudah_bayar')
            ->whereMonth('pesanan.created_at', Carbon::now()->format('m'))
            ->whereYear('pesanan.created_at', Carbon::now()->format('Y'))
            ->limit(5)
            ->get();
        return view('manager.dashboard', compact('count', 'pendapatan', 'menu'));
    }
}
