@extends('errors::minimal')

<section class="section">
    <div class="container">
        <div class="page-error">
            <div class="page-inner">
                <h1>404</h1>
                <div class="page-description">
                    Halaman yang Anda cari tidak dapat ditemukan.
                </div>
                <div class="page-search">
                    <div class="mt-3">
                        <a href="{{ url('/login') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left"></i>
                            Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
