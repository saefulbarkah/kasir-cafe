<?php

namespace App;

use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaksi extends Model
{
    use LogsActivity;
    protected static $logAttributes = ["user_id", "kode_transaksi"];
    protected static $logName = 'Transaksi';
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Telah melakukan transaksi";
    }
    protected $table = "transaksi";
    protected $fillable = [
        'detail_pesanan_id', 'total_bayar', 'jumlah_pembayaran', 'tgl_transaksi', 'kembalian', 'kode_transaksi', 'user_id'
    ];
}
