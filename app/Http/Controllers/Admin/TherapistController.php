<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Therapist;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TherapistController extends Controller
{
    /**
     * Display a listing of all therapists.
     */
    public function index()
    {
        $today = Carbon::today()->format('Y-m-d');

        // Fetch therapists with count of bookings today that are confirmed or completed
        $therapists = Therapist::withCount(['bookings as sessions_today' => function ($q) use ($today) {
            $q->whereDate('booking_date', $today)
                ->whereIn('status', ['confirmed', 'completed']);
        }])->orderBy('name')->get();

        return view('admin.therapists.index', compact('therapists'));
    }

    /**
     * Update therapist details.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'rating' => 'required|numeric|between:1.00,5.00',
            'status' => 'required|in:active,holiday,inactive',
        ], [
            'name.required' => 'Nama terapis wajib diisi.',
            'specialization.required' => 'Spesialisasi terapis wajib diisi.',
            'rating.required' => 'Rating terapis wajib diisi.',
            'status.required' => 'Status terapis wajib dipilih.',
        ]);

        $therapist = Therapist::findOrFail($id);
        $therapist->update([
            'name' => $request->name,
            'specialization' => $request->specialization,
            'rating' => $request->rating,
            'status' => $request->status,
        ]);

        return back()->with('success', "Data terapis {$therapist->name} berhasil diperbarui!");
    }
}
