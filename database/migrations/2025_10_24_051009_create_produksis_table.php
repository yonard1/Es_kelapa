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
        Schema::create('produksis', function (Blueprint $table) {
            $table->id('id_produksi');
            $table->unsignedBigInteger('id_produk');
            $table->date('tanggal_produksi');
            $table->integer('jumlah_dibuat');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksis');
    }
};
