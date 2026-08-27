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
        Schema::table('bookings', function (Blueprint $table) {
            // Tambah setelah kolom total_price
            $table->foreignId('voucher_id')->nullable()->after('total_price')->constrained('vouchers')->nullOnDelete();
            $table->decimal('original_price', 10, 2)->nullable()->after('voucher_id');   // Harga sebelum diskon
            $table->decimal('discount_amount', 10, 2)->default(0)->after('original_price'); // Nominal diskon
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['voucher_id']);
            $table->dropColumn(['voucher_id', 'original_price', 'discount_amount']);
        });
    }
};
