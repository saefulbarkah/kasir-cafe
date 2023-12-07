<?php

use App\Kasir;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KasirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'nama_lengkap' => 'kasir',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('123atu123')
        ]);
        Kasir::create([
            'no_hp' => '083180012053',
            'jenis_kelamin' => 'Laki Laki',
            'alamat' => 'Bandung',
            'user_id' => $user->id,
        ]);
        $user->assignRole('kasir');
    }
}
