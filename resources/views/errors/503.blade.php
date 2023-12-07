@extends('errors.minimal')

<section class="section">
    <div class="container">
        <div class="page-error">
            <div class="page-inner">
                <h1>503</h1>
                <div class="page-description">
                    Layanan tidak tersedia
                </div>
                <div class="page-search">
                    <div class="mt-3">
                        <a href="{{ url()->previous() }}" class="btn btn-primary"><i
                                class="fas fa-arrow-circle-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
