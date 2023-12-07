<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kasir;
use App\User;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kasir = Kasir::join('users', 'users.id', '=', 'kasir.user_id')
            ->select('kasir.*', 'kasir.id as kasir_id', 'users.id as id_user', 'users.*')->get();
        return view('admin.kasir.index', compact('kasir'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kasir.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'nama_lengkap' => 'required',
                'jenis_kelamin' => 'required',
                'no_hp' => 'required|min:13|unique:kasir,no_hp',
                'alamat' => 'required',
                'email'        => 'required|email|unique:users,email',
                'password'      => 'required|min:8',
            ],
            [
                'nama_lengkap.required' => 'Nama lengkap wajib diisi',
                'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
                'no_hp.required' => 'Nama lengkap wajib diisi',
                'no_hp.min'     => 'No hp minimal 10 angka',
                'alamat.required' => 'Nama lengkap wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Alamat email tidak valid',
                'email.unique' => 'Email sudah di gunakan',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
            ]
        );

        $user = new User();
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->assignRole('kasir');
        $user->save();

        $kasir = new Kasir();
        $kasir->user_id = $user->id;
        $kasir->jenis_kelamin = $request->jenis_kelamin;
        $kasir->no_hp = $request->no_hp;
        $kasir->alamat = $request->alamat;
        $kasir->save();

        return redirect()->route('admin.kasir')->with('success', 'Data berhasil di tambahkan');
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
        $kasir = Kasir::join('users', 'users.id', '=', 'kasir.user_id')
            ->select('kasir.*', 'kasir.id as kasir_id', 'users.id as id_user', 'users.*')->findOrFail($id);
        return view('admin.kasir.edit', compact('kasir'));
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
        $kasir = Kasir::findOrFail($id);
        $user = User::findOrFail($kasir->user_id);

        if ($request->password != null) {
            $request->validate(
                [
                    'nama_lengkap' => 'required',
                    'jenis_kelamin' => 'required',
                    'no_hp' => 'required|min:10|unique:kasir,no_hp',
                    'alamat' => 'required',
                    'email'        => 'required|email|unique:users,email,' . $user->id,
                    'password'      => 'required|min:8',
                ],
                [
                    'nama_lengkap.required' => 'Nama lengkap wajib diisi',
                    'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
                    'no_hp.required' => 'Nama lengkap wajib diisi',
                    'no_hp.unique' => 'No hp sudah digunakan',
                    'no_hp.min'     => 'No hp minimal 10 angka',
                    'alamat.required' => 'Nama lengkap wajib diisi',
                    'email.email' => 'Alamat email tidak valid',
                    'email.required' => 'Email wajib diisi',
                    'email.unique' => 'Email sudah di gunakan',
                    'password.required' => 'Password wajib diisi',
                    'password.min' => 'Password minimal 8 karakter',
                ]
            );
        }
        $request->validate(
            [
                'nama_lengkap' => 'required',
                'jenis_kelamin' => 'required',
                'no_hp' => 'required|min:10|unique:kasir,no_hp,' . $kasir->id,
                'alamat' => 'required',
                'email'        => 'required|email|unique:users,email,' . $user->id,
            ],
            [
                'nama_lengkap.required' => 'Nama lengkap wajib diisi',
                'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
                'no_hp.required' => 'Nama lengkap wajib diisi',
                'no_hp.unique' => 'No hp sudah digunakan',
                'no_hp.min'     => 'No hp minimal 10 angka',
                'email.email' => 'Alamat email tidak valid',
                'alamat.required' => 'Nama lengkap wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.unique' => 'Email sudah digunakan',
            ]
        );

        $kasir->user_id = $user->id;
        $kasir->no_hp = $request->no_hp;
        $kasir->jenis_kelamin = $request->jenis_kelamin;
        $kasir->alamat = $request->alamat;
        $kasir->save();

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }
        $user->assignRole('kasir');
        $user->save();

        return redirect()->route('admin.kasir')->with('success', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kasir   = Kasir::findOrFail($id);
        $user    = User::findOrFail($kasir->user_id);
        $user->delete();
        return redirect()->back()->with('success', 'Data berhasil di hapus');
    }
}
