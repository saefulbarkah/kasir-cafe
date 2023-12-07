<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendapatanController extends Controller
{
    public function index()
    {
        $pendapatan = Transaksi::select([
            DB::raw("DATE_FORMAT(tgl_transaksi, '%Y-%m-%d') as day"),
            DB::raw("sum(jumlah_pembayaran) as pendapatan"),
            "id"
        ])
            ->groupBy('day')
            ->orderBy('day', "ASC")
            ->get();
        // dd($pendapatan);
        return view('manager.pendapatan.index', compact('pendapatan'));
    }

    public function filter(Request $request)
    {
        $request->validate(
            [
                'from_date' => 'required|before_or_equal:to_date',
                'to_date' => 'required|after_or_equal:from_date',
            ],
            [
                'from_date.required'    => "Dari tanggal wajib di isi",
                'to_date.required'      => "Sampai tanggal wajib di isi",
                'from_date.before_or_equal'        => "Dari tanggal harus sebelum atau sama dengan sampai tanggal.",
                'to_date.after_or_equal'         => "Sampai tanggal harus setelah atau sama dengan dari tanggal.",
            ]
        );
        if (isset($request->cari)) {
            $pendapatan = Transaksi::select([
                DB::raw("DATE_FORMAT(tgl_transaksi, '%Y-%m-%d') as day"),
                DB::raw("sum(jumlah_pembayaran) as pendapatan"),
            ])
                ->whereBetween('tgl_transaksi', [$request->from_date, $request->to_date])
                ->groupBy('day')
                ->orderBy('day', "ASC")
                ->get();
            if ($pendapatan->isEmpty()) {
                return redirect()->back()->with('error', 'Data tidak di temukan');
            } else {
                $show = true;
                return view('manager.pendapatan.index', compact('pendapatan', 'show'));
            }
        }
        if (isset($request->cetak)) {
            $pendapatan = Transaksi::select([
                DB::raw("DATE_FORMAT(tgl_transaksi, '%Y-%m-%d') as day"),
                DB::raw("sum(jumlah_pembayaran) as pendapatan"),
            ])
                ->whereBetween('tgl_transaksi', [$request->from_date, $request->to_date])
                ->groupBy('day')
                ->orderBy('day', "ASC")
                ->get();
            if ($pendapatan->isEmpty()) {
                return redirect()->back()->with('error', 'Data tidak di temukan');
            } else {
                $pdf = PDF::loadView("manager.pendapatan.cetak", compact('pendapatan'));
                return $pdf->download('laporan-pendapatan(' . $request->from_date . ' sampai ' . $request->to_date . '.pdf');
            }
        }
    }
    public function filterBulan(Request $request)
    {
        // formatting data and get month & year
        $time      = strtotime($request->month);
        $getMonth = date('m', $time);
        $getYear = date('Y', $time);
        // request validatation
        $request->validate(
            [
                'month' => 'required',
            ],
            [
                'month.required'    => "Bulan wajib diisi",
            ]
        );

        // check if request is set as cari
        if (isset($request->cari)) {

            // query builder and grouping data by month
            $pendapatan = Transaksi::select([
                DB::raw("DATE_FORMAT(tgl_transaksi, '%Y-%m') as day"),
                DB::raw("sum(jumlah_pembayaran) as pendapatan"),
            ])
                ->whereMonth('tgl_transaksi', $getMonth)
                ->whereYear('tgl_transaksi', $getYear)
                ->groupBy('day')
                ->orderBy('day', "ASC")
                ->get();
            // check if variable pendapatan is empty
            if ($pendapatan->isEmpty()) {
                // exec this code
                return redirect()->route('manager.laporan.pendapatan')->with('error', 'Data tidak di temukan');
            } else {
                // if not empty exec this code
                $show = true;
                return view('manager.pendapatan.index', compact('pendapatan', 'show'));
            }
        }

        // check if request is set as cetak
        if (isset($request->cetak)) {
            // query builder and grouping data by month
            $month = true;
            $pendapatan = Transaksi::select([
                DB::raw("DATE_FORMAT(tgl_transaksi, '%Y-%m') as month"),
                DB::raw("sum(jumlah_pembayaran) as pendapatan"),
            ])
                ->whereMonth('tgl_transaksi', $getMonth)
                ->whereYear('tgl_transaksi', $getYear)
                ->groupBy('month')
                ->orderBy('month', "ASC")
                ->get();

            // check if variable pendapatan is empty
            if ($pendapatan->isEmpty()) {
                // exec this code
                return redirect()->back()->with('error', 'Data tidak di temukan');
            } else {
                // if not empty exec this code
                $pdf = PDF::loadView("manager.pendapatan.cetak", compact('pendapatan', 'month'));
                return $pdf->download('laporan-pendapatan-bulan (' . $getMonth . '-' . $getYear . ').pdf');
            }
        }
    }
}
