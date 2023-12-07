@extends('layouts.master')

@section('title-page', 'Edit data manager')
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
                    <form action="{{ route('admin.manager.update', $manager->manager_id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>
                                        <span class="text-danger">*</span>
                                        Nama Lengkap
                                    </label>
                                    <input type="text" name="nama_lengkap"
                                        class="form-control @error('nama_lengkap') is-invalid @enderror" required
                                        value="{{ $manager->nama_lengkap }}">
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>
                                        <span class="text-danger">*</span>
                                        Alamat Email
                                    </label>
                                    <input type="text" name="email"
                                        class="form-control @error('email') is-invalid @enderror" required
                                        value="{{ $manager->email }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group pw">
                                    <label>Password baru</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a class="btn btn-danger" href="{{ route('admin.manager') }}"><i
                                    class="fas fa-arrow-left"></i>
                                Kembali</a>
                            <button class="btn btn-warning spw"><i class="fas fa-lock"></i> Ubah password</button>
                            <button class="btn btn-warning hpw"><i class="fas fa-x"></i> Jangan ubah password</button>
                            <button class="btn btn-primary mr-1" type="submit"><i class="fas fa-save"></i>
                                Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $('.pw').hide();
            $('.hpw').hide();
            $('.spw').click(function(e) {
                e.preventDefault();
                $('.pw').show();
                $('.spw').hide();
                $('.hpw').show();
            });
            $('.hpw').click(function(e) {
                e.preventDefault();
                $('.pw').hide();
                $('.spw').show();
                $('.hpw').hide();
            });
        </script>
    @endpush
@endsection
