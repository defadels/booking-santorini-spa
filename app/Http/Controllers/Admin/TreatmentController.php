<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TreatmentController extends Controller
{
    /**
     * Display a listing of all treatments.
     */
    public function index()
    {
        $treatments = Treatment::orderBy('category')->orderBy('name')->get();

        return view('admin.treatments.index', compact('treatments'));
    }

    /**
     * Store a newly created treatment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'duration' => 'required|integer|min:15',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|url|max:500',
        ], [
            'name.required' => 'Nama treatment wajib diisi.',
            'description.required' => 'Deskripsi treatment wajib diisi.',
            'duration.required' => 'Durasi treatment wajib diisi.',
            'price.required' => 'Harga treatment wajib diisi.',
            'category.required' => 'Kategori treatment wajib dipilih.',
            'image.url' => 'Format foto harus berupa link URL gambar yang valid.',
        ]);

        // Unique slug generator
        $slug = Str::slug($request->name);
        $count = Treatment::where('slug', 'like', $slug.'%')->count();
        if ($count > 0) {
            $slug = $slug.'-'.($count + 1);
        }

        // Set default spa image if not provided
        $image = $request->image ?: 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=600&q=80';

        Treatment::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'duration' => $request->duration,
            'price' => $request->price,
            'category' => $request->category,
            'image' => $image,
            'is_available' => true,
            'total_bookings' => 0,
        ]);

        return back()->with('success', "Treatment {$request->name} berhasil ditambahkan!");
    }

    /**
     * Update the specified treatment.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'duration' => 'required|integer|min:15',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|url|max:500',
            'is_available' => 'required|boolean',
        ], [
            'name.required' => 'Nama treatment wajib diisi.',
            'description.required' => 'Deskripsi treatment wajib diisi.',
            'duration.required' => 'Durasi treatment wajib diisi.',
            'price.required' => 'Harga treatment wajib diisi.',
            'category.required' => 'Kategori treatment wajib dipilih.',
            'image.url' => 'Format foto harus berupa link URL gambar yang valid.',
            'is_available.required' => 'Status ketersediaan wajib diisi.',
        ]);

        $treatment = Treatment::findOrFail($id);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'price' => $request->price,
            'category' => $request->category,
            'image' => $request->image ?: $treatment->image,
            'is_available' => $request->is_available,
        ];

        // If name changes, regenerate slug
        if ($treatment->name !== $request->name) {
            $slug = Str::slug($request->name);
            $count = Treatment::where('slug', 'like', $slug.'%')->where('id', '!=', $id)->count();
            if ($count > 0) {
                $slug = $slug.'-'.($count + 1);
            }
            $data['slug'] = $slug;
        }

        $treatment->update($data);

        return back()->with('success', "Treatment {$treatment->name} berhasil diperbarui!");
    }
}
