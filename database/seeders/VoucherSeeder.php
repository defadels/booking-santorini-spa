<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = Carbon::today();

        $vouchers = [
            // ─── Voucher AKTIF ─────────────────────────────────────────────
            [
                'code'             => 'SANTO10',
                'name'             => 'Diskon Pelanggan Setia 10%',
                'discount_percent' => 10,
                'quota'            => 100,
                'used_count'       => 12,
                'start_date'       => $today->copy()->subDays(10),
                'end_date'         => $today->copy()->addDays(30),
                'is_active'        => true,
            ],
            [
                'code'             => 'SANTO20',
                'name'             => 'Promo Akhir Bulan 20%',
                'discount_percent' => 20,
                'quota'            => 50,
                'used_count'       => 8,
                'start_date'       => $today->copy()->subDays(5),
                'end_date'         => $today->copy()->addDays(15),
                'is_active'        => true,
            ],
            [
                'code'             => 'RELAX15',
                'name'             => 'Weekend Relaxation 15%',
                'discount_percent' => 15,
                'quota'            => 75,
                'used_count'       => 3,
                'start_date'       => $today->copy()->subDays(2),
                'end_date'         => $today->copy()->addDays(60),
                'is_active'        => true,
            ],
            [
                'code'             => 'NEWMEMBER',
                'name'             => 'Selamat Datang Member Baru 25%',
                'discount_percent' => 25,
                'quota'            => 30,
                'used_count'       => 0,
                'start_date'       => $today->copy(),
                'end_date'         => $today->copy()->addDays(90),
                'is_active'        => true,
            ],
            [
                'code'             => 'PREMIUM30',
                'name'             => 'Flash Sale Premium 30%',
                'discount_percent' => 30,
                'quota'            => 20,
                'used_count'       => 5,
                'start_date'       => $today->copy()->subDay(),
                'end_date'         => $today->copy()->addDays(7),
                'is_active'        => true,
            ],

            // ─── Voucher BELUM MULAI ────────────────────────────────────────
            [
                'code'             => 'HARNAS50',
                'name'             => 'Spesial Hari Nasional 50%',
                'discount_percent' => 50,
                'quota'            => 25,
                'used_count'       => 0,
                'start_date'       => $today->copy()->addDays(10),
                'end_date'         => $today->copy()->addDays(12),
                'is_active'        => true,
            ],

            // ─── Voucher HABIS KUOTA ────────────────────────────────────────
            [
                'code'             => 'SOLD20',
                'name'             => 'Promo Terbatas (Habis)',
                'discount_percent' => 20,
                'quota'            => 15,
                'used_count'       => 15,
                'start_date'       => $today->copy()->subDays(20),
                'end_date'         => $today->copy()->addDays(5),
                'is_active'        => true,
            ],

            // ─── Voucher KADALUARSA ─────────────────────────────────────────
            [
                'code'             => 'OLDPROMO',
                'name'             => 'Promo Bulan Lalu',
                'discount_percent' => 15,
                'quota'            => 50,
                'used_count'       => 23,
                'start_date'       => $today->copy()->subDays(40),
                'end_date'         => $today->copy()->subDays(5),
                'is_active'        => true,
            ],

            // ─── Voucher NONAKTIF (dimatikan admin) ────────────────────────
            [
                'code'             => 'SUSPEND10',
                'name'             => 'Voucher Ditangguhkan Admin',
                'discount_percent' => 10,
                'quota'            => 100,
                'used_count'       => 2,
                'start_date'       => $today->copy()->subDays(3),
                'end_date'         => $today->copy()->addDays(20),
                'is_active'        => false,
            ],
        ];

        foreach ($vouchers as $data) {
            Voucher::updateOrCreate(
                ['code' => $data['code']],
                $data
            );
        }

        $this->command->info('✅ VoucherSeeder: ' . count($vouchers) . ' voucher berhasil dibuat.');
    }
}

