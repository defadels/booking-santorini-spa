<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerController extends Controller
{
    /**
     * Display the customer portal / dashboard.
     */
    public function dashboard(Request $request)
    {
        $user = auth()->user();
        $bookings = Booking::with(['treatment', 'therapist'])
            ->where('user_id', $user->id)
            ->orderBy('booking_date', 'desc')
            ->orderBy('booking_time', 'desc')
            ->get();

        return view('customer.dashboard', compact('user', 'bookings'));
    }

    /**
     * Update customer profile info.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini sudah terdaftar di sistem.',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('customer.dashboard', ['tab' => 'profile'])->with('success', 'Profil Anda berhasil diperbarui!');
    }

    /**
     * Update customer password.
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini salah.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('customer.dashboard', ['tab' => 'profile'])->with('success', 'Password Anda berhasil diperbarui!');
    }

    /**
     * Cancel a pending or confirmed booking.
     */
    public function cancelBooking($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return redirect()->route('customer.dashboard')->with('error', 'Booking ini tidak dapat dibatalkan.');
        }

        $booking->update([
            'status' => 'cancelled'
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Reservasi ' . $booking->booking_code . ' berhasil dibatalkan.');
    }
}
