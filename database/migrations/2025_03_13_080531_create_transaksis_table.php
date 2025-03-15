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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking');
            $table->integer('rental_id');
            $table->integer('user_id');
            $table->integer('sesi_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('status_transaksi');
            $table->string('status_pembayaran');
            $table->string('metode_pembayaran')->nullable();
            $table->string('paid_at')->nullable();
            $table->integer('total_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
