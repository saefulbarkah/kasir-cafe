<?php

use App\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create([
            'nama_menu' => 'Roti bakar',
            'harga'     => 7000,
            'kategori'    => "Makanan",
            'gambar'    => 'roti_bakar.jpg',
            'status'    => "Tersedia",
        ]);
        Menu::create([
            'nama_menu' => 'Burger',
            'harga'     => 20000,
            'kategori'    => "Makanan",
            'gambar'    => 'burger.jpg',
            'status'    => "Tersedia",
        ]);
        Menu::create([
            'nama_menu' => 'Hot dogs',
            'harga'     => 10000,
            'kategori'    => "Makanan",
            'gambar'    => 'hot_dogs.jpg',
            'status'    => "Tersedia",
        ]);
        Menu::create([
            'nama_menu' => 'Kentang goreng',
            'harga'     => 15000,
            'kategori'    => "Makanan",
            'gambar'    => 'kentang_goreng.jpg',
            'status'    => "Tersedia",
        ]);

        // minuman
        Menu::create([
            'nama_menu' => 'Fruit juice',
            'harga'     => 5000,
            'kategori'    => "Minuman",
            'gambar'    => 'fruit-juice.jpg',
            'status'    => "Tersedia",
        ]);
        Menu::create([
            'nama_menu' => 'Ice coffe milk',
            'harga'     => 10000,
            'kategori'    => "Minuman",
            'gambar'    => 'ice-coffe-milk.jpg',
            'status'    => "Tersedia",
        ]);
        Menu::create([
            'nama_menu' => 'Ice coffe latte',
            'harga'     => 12000,
            'kategori'    => "Minuman",
            'gambar'    => 'ice-coffe-latte.jpg',
            'status'    => "Tersedia",
        ]);
        Menu::create([
            'nama_menu' => 'Americano',
            'harga'     => 15000,
            'kategori'    => "Minuman",
            'gambar'    => 'americano.jpg',
            'status'    => "Tersedia",
        ]);
    }
}
