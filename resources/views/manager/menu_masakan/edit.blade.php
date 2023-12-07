@extends('layouts.master')

@section('title-page', 'Update Menu Makanan')
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
                    <form action="{{ route('manager.menu.update', $menu->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Nama Menu</label>
                                    <input type="text" name="nama_menu"
                                        class="form-control @error('nama_menu') is-invalid @enderror" autofocus
                                        value="{{ $menu->nama_menu }}">
                                    @error('nama_menu')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" name="harga" placeholder="Rp "
                                        class="form-control uang @error('harga') is-invalid @enderror" autofocus
                                        value="{{ $menu->harga }}">
                                    @error('harga')
                                        <div class=" invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select class="custom-select @error('kategori') is-invalid @enderror" name="kategori">
                                        <option selected disabled>Pilih kategori</option>
                                        <option value="Makanan" @if ($menu->kategori == 'Makanan') selected @endif>Makanan
                                        </option>
                                        <option value="Minuman" @if ($menu->kategori == 'Minuman') selected @endif>Minuman
                                        </option>
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="custom-select @error('status') is-invalid @enderror" name="status">
                                        <option selected disabled>Pilih status</option>
                                        <option value="Tersedia" @if ($menu->status == 'Tersedia') selected @endif>Tersedia
                                        </option>
                                        <option value="Tidak Tersedia" @if ($menu->status == 'Tidak Tersedia') selected @endif>
                                            Tidak Tersedia</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Upload gambar</label>
                                    <div class="custom-file">
                                        <input type="file" name="gambar"
                                            class="custom-file-input @error('gambar') is-invalid @enderror" id="imgInp">
                                        <label class="custom-file-label" for="imgInp">Pilih gambar</label>
                                        @error('gambar')
                                            <div class="invalid-feedback alert alert-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <img id="blah" src="{{ asset('myAssets/menu/' . $menu->gambar) }}"
                                        class="img-fluid" />
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a class="btn btn-danger" href="{{ route('manager.menu') }}">
                                <i class="fas fa-arrow-left">
                                </i>
                                Kembali
                            </a>
                            <button class="btn btn-primary mr-1" type="submit" onclick="submitForm(this);">
                                <i class="fas fa-save"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('assets/js/jquery.inputmask.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.uang').inputmask({
                    prefix: 'Rp ',
                    rightAlign: false,
                    groupSeparator: ".",
                    alias: "numeric",
                })
            });
        </script>
        <script>
            imgInp.onchange = evt => {
                const [file] = imgInp.files
                if (file) {
                    blah.src = URL.createObjectURL(file)
                }
            }
        </script>
    @endpush
@endsection
