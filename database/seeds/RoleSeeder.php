<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);
        $manager = Role::create([
            'name' => 'manager',
            'guard_name' => 'web'
        ]);
        $kasir = Role::create([
            'name' => 'kasir',
            'guard_name' => 'web'
        ]);
    }
}
