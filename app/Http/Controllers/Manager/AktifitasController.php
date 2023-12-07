<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class AktifitasController extends Controller
{
    public function index()
    {
        $data = Activity::join('users', 'users.id', '=', 'activity_log.causer_id')
            ->select('activity_log.created_at as tgl_aktifitas', 'users.*', 'activity_log.*')
            ->latest('activity_log.id')
            ->get();
        return view('manager.aktifitas.index', compact('data'));
    }

    public function delete()
    {
        Activity::truncate();
        return redirect()->back()->with('success', 'Log berhasil di hapus');
    }
}
