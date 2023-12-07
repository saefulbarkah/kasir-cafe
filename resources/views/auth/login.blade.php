@extends('layouts.app')

@section('content')
    <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
            <div class="p-4 m-3">
                <img src="{{ asset('assets/img/logo.webp') }}" alt="logo" width="80"
                    class="shadow-light rounded-circle mb-5 mt-2">
                <h4 class="text-dark font-weight-normal">Selamat datang di
                    <span class="font-weight-bold">Kasir Cafe</span>
                </h4>
                <p class="text-muted">
                    Sebelum memulai, Anda harus login.</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input id="email" autocomplete="off" type="email"
                            class="form-control @error('email') is-invalid @enderror" name="email" tabindex="1" required
                            autofocus>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="d-block">
                            <label for="password" class="control-label">Kata sandi</label>
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror "
                            name="password" tabindex="2" required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                            Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom"
            data-background="{{ asset('assets/img/unsplash/login-bg2.jpg') }}" style="height: 102vh">
            <div class="absolute-bottom-left index-2">
                <div class="text-light p-5 pb-2">
                    <div class="mb-5 pb-3">
                        <h1 class="mb-2 display-4 font-weight-bold text-shadow" id="sayHelo"></h1>
                        <h5 class="font-weight-normal text-muted-transparent">Kabupaten
                            Bandung, Jawa Barat, Indonesia
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $(document).ready(function() {
                var today = new Date()
                var curHr = today.getHours()
                if (curHr < 10) {
                    $('#sayHelo').text('Selamat Pagi')
                } else if (curHr < 15) {
                    $('#sayHelo').text('Selamat Siang')
                } else if (curHr < 18) {
                    $('#sayHelo').text('Selamat Sore')
                } else {
                    $('#sayHelo').text('Selamat Malam')
                }
            });
        </script>
    @endpush
@endsection
