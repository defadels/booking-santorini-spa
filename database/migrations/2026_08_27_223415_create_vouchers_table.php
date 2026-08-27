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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();                    // Kode unik voucher yang diinput customer
            $table->string('name');                              // Nama display voucher
            $table->unsignedTinyInteger('discount_percent');     // Persentase diskon (1–100)
            $table->unsignedInteger('quota');                    // Total kuota tersedia
            $table->unsignedInteger('used_count')->default(0);  // Jumlah terpakai
            $table->date('start_date');                          // Tanggal mulai berlaku
            $table->date('end_date');                            // Tanggal akhir berlaku
            $table->boolean('is_active')->default(true);         // Toggle aktif/nonaktif oleh admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
