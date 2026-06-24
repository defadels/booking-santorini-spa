<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Therapist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     * Store a newly created therapist.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'rating' => 'required|numeric|between:1.00,5.00',
            'status' => 'required|in:active,holiday,inactive',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url|max:500',
        ], [
            'name.required' => 'Nama terapis wajib diisi.',
            'specialization.required' => 'Spesialisasi terapis wajib diisi.',
            'rating.required' => 'Rating terapis wajib diisi.',
            'rating.numeric' => 'Rating terapis harus berupa angka.',
            'rating.between' => 'Rating terapis harus di antara 1.00 dan 5.00.',
            'status.required' => 'Status terapis wajib dipilih.',
            'image_file.image' => 'File harus berupa gambar.',
            'image_file.max' => 'Ukuran file gambar tidak boleh melebihi 2MB.',
            'image_url.url' => 'Format URL foto harus berupa link URL gambar yang valid.',
        ]);

        $imagePath = null;

        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('therapists', 'public');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        Therapist::create([
            'name' => $request->name,
            'specialization' => $request->specialization,
            'rating' => $request->rating,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        return back()->with('success', "Terapis {$request->name} berhasil ditambahkan!");
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
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url|max:500',
        ], [
            'name.required' => 'Nama terapis wajib diisi.',
            'specialization.required' => 'Spesialisasi terapis wajib diisi.',
            'rating.required' => 'Rating terapis wajib diisi.',
            'rating.numeric' => 'Rating terapis harus berupa angka.',
            'rating.between' => 'Rating terapis harus di antara 1.00 dan 5.00.',
            'status.required' => 'Status terapis wajib dipilih.',
            'image_file.image' => 'File harus berupa gambar.',
            'image_file.max' => 'Ukuran file gambar tidak boleh melebihi 2MB.',
            'image_url.url' => 'Format URL foto harus berupa link URL gambar yang valid.',
        ]);

        $therapist = Therapist::findOrFail($id);
        $imagePath = $therapist->getRawOriginal('image');

        if ($request->hasFile('image_file')) {
            // Delete old file if exists and is not a URL
            if ($imagePath && !filter_var($imagePath, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image_file')->store('therapists', 'public');
        } elseif ($request->filled('image_url')) {
            // Delete old file if exists and is not a URL
            if ($imagePath && !filter_var($imagePath, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->image_url;
        }

        $therapist->update([
            'name' => $request->name,
            'specialization' => $request->specialization,
            'rating' => $request->rating,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        return back()->with('success', "Data terapis {$therapist->name} berhasil diperbarui!");
    }

    /**
     * Delete a therapist.
     */
    public function destroy($id)
    {
        $therapist = Therapist::findOrFail($id);
        $imagePath = $therapist->getRawOriginal('image');

        // Delete local image file if it exists
        if ($imagePath && !filter_var($imagePath, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($imagePath);
        }

        $therapist->delete();

        return back()->with('success', "Terapis {$therapist->name} berhasil dihapus!");
    }
}
