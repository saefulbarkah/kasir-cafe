<?php

use App\Manager;
use App\User;
use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'nama_lengkap' => 'manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('123atu123')
        ]);
        Manager::create([
            'user_id' => $user->id,
        ]);
        $user->assignRole('manager');
    }
}
