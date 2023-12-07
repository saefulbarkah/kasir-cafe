<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = Menu::all();
        return view('manager.menu_masakan.index', compact('menu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.menu_masakan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // money formatting
        $uang = str_replace(
            [
                'Rp', ' ', ','
            ],
            '',
            $request->harga,
        );
        $request->validate(
            [
                'nama_menu' => 'required|unique:menus,nama_menu',
                'harga'     => 'required',
                'kategori'  => 'required',
                'gambar'    => 'mimes:png,jpg,jpeg|required',
            ],
            [
                'nama_menu.required'    => 'Nama menu wajib diisi',
                'harga.required'        => 'Harga wajib diisi',
                'kategori.required'     => 'Kategori wajib diisi',
                'gambar.required'       => 'File Gambar wajib diisi',

                'nama_menu.unique'      => 'Nama menu sudah di digunakan',
                'gambar.mimes'          => 'Format gambar salah, gunakan extension jpg,png,jpeg',
            ]
        );

        $menu = new Menu();
        $menu->nama_menu = $request->nama_menu;
        $menu->harga = $uang;
        $menu->kategori = $request->kategori;
        $menu->status = "Tersedia";

        // intervention image upload
        $file = $request->file('gambar');
        $newName = str_replace(' ', '-', $file->getClientOriginalName());
        $fileName = time() . $newName;
        $img = Image::make($file);
        $img->fit(900, 600, function ($constraint) {
            $constraint->upsize();
        });
        $img->save(public_path('myAssets/menu/' . $fileName, 70));
        $menu->gambar = $fileName;
        $menu->save();
        return redirect()->route('manager.menu')->with('success', 'Data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('manager.menu_masakan.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // money formatting
        $uang = str_replace(
            [
                'Rp', ' ', ','
            ],
            '',
            $request->harga,
        );
        $request->validate(
            [
                'nama_menu' => 'required|unique:menus,nama_menu,' . $id,
                'harga'     => 'required',
                'kategori'  => 'required',
                'status'    => 'required',
                'gambar'    => 'mimes:png,jpg,jpeg',
            ],
            [
                'nama_menu.required'    => 'Nama menu wajib diisi',
                'harga.required'        => 'Harga wajib diisi',
                'kategori.required'     => 'Kategori wajib diisi',
                'status.required'       => 'Status wajib diisi',

                'nama_menu.unique'      => 'Nama menu sudah di digunakan',
                'gambar.mimes'          => 'Format gambar salah, gunakan extension jpg,png,jpeg',
            ]
        );

        $menu = Menu::findOrFail($id);
        $menu->nama_menu = $request->nama_menu;
        $menu->harga = $uang;
        $menu->kategori = $request->kategori;
        $menu->status = $request->status;

        // upldaing image
        if ($request->has('gambar')) {
            File::delete(public_path('MyAssets/menu/' . $menu->gambar));
            // intervention image upload
            $file = $request->file('gambar');
            $newName = str_replace(' ', '-', $file->getClientOriginalName());
            $fileName = time() . $newName;
            $img = Image::make($file);
            $img->fit(900, 600, function ($constraint) {
                $constraint->upsize();
            });
            $img->save(public_path('myAssets/menu/' . $fileName, 70));
            $menu->gambar = $fileName;
        }
        $menu->save();

        return redirect()->route('manager.menu')->with('success', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        File::delete(public_path('myAssets/menu/' . $menu->gambar));
        $menu->delete();

        return redirect()->back()->with('success', 'Data berhasil di hapus');
    }
}
