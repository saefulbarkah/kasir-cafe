<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'nama_lengkap' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123atu123')
        ]);
        $admin->assignRole('admin');
    }
}
