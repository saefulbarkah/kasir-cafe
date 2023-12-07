<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'menu_id', 'qty', 'sub_total', 'detail_pesanan_id', 'pelanggan_id', 'kasir_id', 'status'
    ];
}
