<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Tampilkan daftar semua voucher.
     */
    public function index()
    {
        $vouchers = Voucher::withCount('bookings')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.vouchers.index', compact('vouchers'));
    }

    /**
     * Simpan voucher baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'             => 'required|string|max:50|unique:vouchers,code',
            'name'             => 'required|string|max:255',
            'discount_percent' => 'required|integer|min:1|max:100',
            'quota'            => 'required|integer|min:1',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'is_active'        => 'boolean',
        ], [
            'code.required'             => 'Kode voucher wajib diisi.',
            'code.unique'               => 'Kode voucher ini sudah digunakan.',
            'name.required'             => 'Nama voucher wajib diisi.',
            'discount_percent.required' => 'Persentase diskon wajib diisi.',
            'discount_percent.min'      => 'Persentase diskon minimal 1%.',
            'discount_percent.max'      => 'Persentase diskon maksimal 100%.',
            'quota.required'            => 'Kuota voucher wajib diisi.',
            'quota.min'                 => 'Kuota minimal 1.',
            'start_date.required'       => 'Tanggal mulai berlaku wajib diisi.',
            'end_date.required'         => 'Tanggal akhir berlaku wajib diisi.',
            'end_date.after_or_equal'   => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',
        ]);

        Voucher::create([
            'code'             => strtoupper($request->code),
            'name'             => $request->name,
            'discount_percent' => $request->discount_percent,
            'quota'            => $request->quota,
            'used_count'       => 0,
            'start_date'       => $request->start_date,
            'end_date'         => $request->end_date,
            'is_active'        => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher "' . strtoupper($request->code) . '" berhasil dibuat!');
    }

    /**
     * Update voucher yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'code'             => 'required|string|max:50|unique:vouchers,code,' . $id,
            'name'             => 'required|string|max:255',
            'discount_percent' => 'required|integer|min:1|max:100',
            'quota'            => 'required|integer|min:' . $voucher->used_count,
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'is_active'        => 'boolean',
        ], [
            'code.unique'             => 'Kode voucher ini sudah digunakan.',
            'quota.min'               => 'Kuota tidak boleh kurang dari jumlah pemakaian saat ini (' . $voucher->used_count . ').',
            'end_date.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',
        ]);

        $voucher->update([
            'code'             => strtoupper($request->code),
            'name'             => $request->name,
            'discount_percent' => $request->discount_percent,
            'quota'            => $request->quota,
            'start_date'       => $request->start_date,
            'end_date'         => $request->end_date,
            'is_active'        => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher "' . $voucher->code . '" berhasil diperbarui!');
    }

    /**
     * Hapus voucher.
     */
    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $code = $voucher->code;
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher "' . $code . '" berhasil dihapus.');
    }

    /**
     * Tracking pemakaian voucher tertentu.
     */
    public function usages($id)
    {
        $voucher = Voucher::findOrFail($id);

        $usages = Booking::with(['user', 'treatment', 'therapist'])
            ->where('voucher_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.vouchers.usages', compact('voucher', 'usages'));
    }
}
