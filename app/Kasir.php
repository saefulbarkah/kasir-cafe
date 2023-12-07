<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    protected $table = 'kasir';
    protected $fillable = [
        'user_id', 'alamat', 'jenis_kelamin', 'no_hp',
    ];
}
