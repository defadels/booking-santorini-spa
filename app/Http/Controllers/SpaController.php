<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Therapist;
use App\Models\Treatment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SpaController extends Controller
{
    /**
     * Display the Santorini Spa Homepage.
     */
    public function index(Request $request)
    {
        $selectedCategory = $request->input('category', 'All');
        $search = $request->input('search');

        $query = Treatment::where('is_available', true);

        if ($selectedCategory !== 'All') {
            $query->where('category', $selectedCategory);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $treatments = $query->orderBy('name')->get();

        // Dynamic category extraction
        $categories = Treatment::where('is_available', true)
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->toArray();

        return view('spa.home', compact('treatments', 'categories', 'selectedCategory', 'search'));
    }

    /**
     * Display a specific Spa Treatment details.
     */
    public function show($slug)
    {
        $treatment = Treatment::where('slug', $slug)->firstOrFail();

        return view('spa.detail', compact('treatment'));
    }

    /**
     * Display the booking form.
     */
    public function bookingForm($slug)
    {
        $treatment = Treatment::where('slug', $slug)
            ->where('is_available', true)
            ->firstOrFail();

        $therapists = Therapist::where('status', 'active')->orderBy('name')->get();

        // 7 days calendar from today
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::today()->addDays($i);
            $dates[] = [
                'value' => $date->format('Y-m-d'),
                'day_name' => $this->translateDayName($date->format('l')),
                'day' => $date->format('d'),
                'month' => $this->translateMonthName($date->format('F')),
            ];
        }

        // Preset slots
        $slots = ['09:00', '10:30', '12:00', '13:30', '15:00', '16:30', '18:00', '19:30'];

        // Get booked slots for active therapists from today onwards
        $existingBookings = Booking::where('booking_date', '>=', Carbon::today()->format('Y-m-d'))
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->select('booking_date', 'therapist_id', 'booking_time')
            ->get()
            ->map(function ($booking) {
                return [
                    'date' => $booking->booking_date,
                    'therapist_id' => $booking->therapist_id,
                    'time' => substr($booking->booking_time, 0, 5),
                ];
            });

        return view('spa.booking', compact('treatment', 'therapists', 'dates', 'slots', 'existingBookings'));
    }

    /**
     * Handle booking submission.
     */
    public function storeBooking(Request $request, $slug)
    {
        $treatment = Treatment::where('slug', $slug)
            ->where('is_available', true)
            ->firstOrFail();

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'therapist_id' => 'required|exists:therapists,id',
            'booking_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'booking_time' => 'required|in:09:00,10:30,12:00,13:30,15:00,16:30,18:00,19:30',
            'notes' => 'nullable|string|max:1000',
        ], [
            'customer_name.required' => 'Nama lengkap wajib diisi.',
            'therapist_id.required' => 'Silakan pilih terapis pilihan Anda.',
            'booking_date.required' => 'Tanggal booking wajib dipilih.',
            'booking_time.required' => 'Jam slot booking wajib dipilih.',
        ]);

        // Server-side double booking checks
        $conflict = Booking::where('booking_date', $request->booking_date)
            ->where('booking_time', $request->booking_time)
            ->where('therapist_id', $request->therapist_id)
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->exists();

        if ($conflict) {
            return back()->withErrors([
                'booking_time' => 'Terapis yang Anda pilih sudah terisi jadwal pada jam tersebut. Mohon pilih waktu atau terapis lain.',
            ])->withInput();
        }

        // Therapist status double check
        $therapist = Therapist::findOrFail($request->therapist_id);
        if ($therapist->status !== 'active') {
            return back()->withErrors([
                'therapist_id' => 'Terapis terpilih sedang tidak aktif bekerja.',
            ])->withInput();
        }

        $bookingCode = 'SANTO-'.strtoupper(Str::random(6));

        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'treatment_id' => $treatment->id,
            'therapist_id' => $therapist->id,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'notes' => $request->notes,
            'status' => 'pending',
            'total_price' => $treatment->price,
        ]);

        // Increment total booking counter for treatment
        $treatment->increment('total_bookings');

        return redirect()->route('booking.confirmation', $bookingCode)->with('success', 'Booking Anda berhasil dibuat!');
    }

    /**
     * Show booking confirmation receipt.
     */
    public function confirmation($booking_code)
    {
        $booking = Booking::with(['treatment', 'therapist'])
            ->where('booking_code', $booking_code)
            ->firstOrFail();

        if ($booking->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat booking ini.');
        }

        return view('spa.confirmation', compact('booking'));
    }

    /**
     * Simple translations for calendar days.
     */
    private function translateDayName($day)
    {
        $translations = [
            'Sunday' => 'Min',
            'Monday' => 'Sen',
            'Tuesday' => 'Sel',
            'Wednesday' => 'Rab',
            'Thursday' => 'Kam',
            'Friday' => 'Jum',
            'Saturday' => 'Sab',
        ];

        return $translations[$day] ?? substr($day, 0, 3);
    }

    /**
     * Simple translations for calendar months.
     */
    private function translateMonthName($month)
    {
        $translations = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];

        return $translations[$month] ?? $month;
    }
}
