<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->bigInteger('detail_pesanan_id');
            $table->unsignedBigInteger('pelanggan_id');
            $table->foreign('pelanggan_id')->on('pelanggan')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('kasir_id');
            $table->foreign('kasir_id')->on('kasir')->references('id')->onDelete('cascade');
            $table->string('jumlah_pembayaran');
            $table->string('total_bayar');
            $table->string('kembalian');
            $table->date('tgl_transaksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
