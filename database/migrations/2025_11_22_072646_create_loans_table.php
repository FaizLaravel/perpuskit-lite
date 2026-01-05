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

        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('kode_transaksi')->unique();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();

            $table->date('tanggal_pengajuan')->nullable();
            $table->date('tanggal_peminjaman')->nullable();
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->date('tanggal_pengembalian')->nullable();

            $table->enum('status', [
                'pending',
                'dipinjam',
                'dikembalikan',
                'terlambat',
                'dibatalkan',
                'hilang',
                'rusak'
            ])->default('pending');

            $table->enum('status_pembayaran', [
                'none',
                'bayar',
                'lunas'
            ])->default('none');

            $table->enum('status_perpanjangan', [
                'none',
                'pending',
                'approved',
                'rejected'
            ])->default('none');

            $table->decimal('denda', 10, 2)->default(0);
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
