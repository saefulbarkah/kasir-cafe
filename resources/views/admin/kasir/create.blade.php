@extends('layouts.master')

@section('title-page', 'Tambah data kasir')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-has-icon">
            <div class="alert-icon"><i class="fas fa-warning"></i></div>
            <div class="alert-body">
                <div class="alert-title">Kesalahan</div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.kasir.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <span class="text-danger">*</span>Nama Lengkap
                                    </label>
                                    <input type="text" name="nama_lengkap"
                                        class="form-control @error('nama_lengkap') is-invalid @enderror" autocomplete="off"
                                        required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>
                                        <span class="text-danger">*</span>
                                        Jenis kelamin
                                    </label>
                                    <select class="custom-select" name="jenis_kelamin" required>
                                        <option selected disabled>Pilih jenis kelamin</option>
                                        <option value="Laki Laki">Laki Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>
                                        <span class="text-danger">*</span>
                                        No hp
                                    </label>
                                    <input type="number" name="no_hp"
                                        class="form-control @error('no_hp') is-invalid @enderror" required
                                        autocomplete="off">
                                    @error('no_hp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <span class="text-danger">*</span>
                                        Alamat Email
                                    </label>
                                    <input type="text" name="email"
                                        class="form-control @error('email') is-invalid @enderror" required
                                        autocomplete="off">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>
                                        <span class="text-danger">*</span>
                                        Password
                                    </label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>
                                        <span class="text-danger">*</span>
                                        Alamat
                                    </label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" required name="alamat" rows="3"
                                        style="height: 120px"></textarea>
                                </div>
                                @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a class="btn btn-danger" href="{{ route('admin.kasir') }}"><i class="fas fa-arrow-left"></i>
                                Kembali</a>
                            <button class="btn btn-primary mr-1" type="submit"><i class="fas fa-save"></i>
                                Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
