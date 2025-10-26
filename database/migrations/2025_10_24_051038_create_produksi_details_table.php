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
        Schema::create('produksi_details', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_produksi');
            $table->unsignedBigInteger('id_bahan');
            $table->double('jumlah_dipakai');
            $table->string('satuan', 20)->nullable();
            $table->timestamps();

            $table->foreign('id_produksi')
                ->references('id_produksi')
                ->on('produksis')
                ->onDelete('cascade');

            $table->foreign('id_bahan')
                ->references('id_bahan')
                ->on('materials')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksi_details');
    }
};
