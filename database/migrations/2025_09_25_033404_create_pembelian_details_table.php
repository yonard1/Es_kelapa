<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembelian_details', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_pembelian'); 
            $table->unsignedBigInteger('id_bahan');
            $table->integer('jumlah');
            $table->decimal('harga', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();

            // relasi ke tabel pembelians
            $table->foreign('id_pembelian')->references('id_pembelian')->on('pembelians')->onDelete('cascade');

            // relasi ke tabel bahans
            $table->foreign('id_bahan')->references('id_bahan')->on('materials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_details');
    }
};
