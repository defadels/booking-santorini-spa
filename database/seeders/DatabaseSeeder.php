<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Therapist;
use App\Models\Treatment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@santorinispa.com'],
            [
                'name' => 'Admin Santorini',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Seed Treatments
        $treatmentsData = [
            [
                'name' => 'Volcanic Stone Massage',
                'slug' => 'volcanic-stone-massage',
                'description' => 'Pijat relaksasi mendalam menggunakan batu basal hangat dari gunung berapi Santorini untuk melepaskan ketegangan otot dan meningkatkan sirkulasi darah.',
                'duration' => 90,
                'price' => 350000.00,
                'category' => 'Massage',
                'image' => 'https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?auto=format&fit=crop&w=600&q=80',
                'is_available' => true,
                'total_bookings' => 24,
            ],
            [
                'name' => 'Aegean Sea Salt Glow',
                'slug' => 'aegean-sea-salt-glow',
                'description' => 'Eksfoliasi tubuh dengan garam laut Aegean murni dicampur minyak esensial citrus untuk mengangkat sel kulit mati dan mencerahkan kulit secara alami.',
                'duration' => 60,
                'price' => 280000.00,
                'category' => 'Body Scrub',
                'image' => 'https://images.unsplash.com/photo-1519699047748-de8e457a634e?auto=format&fit=crop&w=600&q=80',
                'is_available' => true,
                'total_bookings' => 18,
            ],
            [
                'name' => 'Santorini Royal Facial',
                'slug' => 'santorini-royal-facial',
                'description' => 'Perawatan wajah mewah dengan ekstrak ganggang laut dan masker kolagen untuk hidrasi mendalam, memberikan tampilan segar dan bercahaya seketika.',
                'duration' => 75,
                'price' => 400000.00,
                'category' => 'Facial',
                'image' => 'https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?auto=format&fit=crop&w=600&q=80',
                'is_available' => true,
                'total_bookings' => 15,
            ],
            [
                'name' => 'Caldera Sunset Package',
                'slug' => 'caldera-sunset-package',
                'description' => 'Paket relaksasi lengkap terinspirasi oleh keindahan matahari terbenam Caldera: Pijat aromaterapi 90 menit, lulur tubuh 30 menit, dan mandi susu kelopak bunga 30 menit.',
                'duration' => 150,
                'price' => 650000.00,
                'category' => 'Spa Package',
                'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=600&q=80',
                'is_available' => true,
                'total_bookings' => 30,
            ],
            [
                'name' => 'Deep Tissue Therapy',
                'slug' => 'deep-tissue-therapy',
                'description' => 'Terapi pijat dengan tekanan kuat yang menargetkan lapisan terdalam otot untuk meredakan nyeri kronis dan memulihkan fleksibilitas tubuh.',
                'duration' => 75,
                'price' => 320000.00,
                'category' => 'Massage',
                'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=600&q=80',
                'is_available' => true,
                'total_bookings' => 12,
            ],
            [
                'name' => 'Oia Whitening Mask',
                'slug' => 'oia-whitening-mask',
                'description' => 'Masker tubuh lulur bengkoang alami khas Santorini untuk kulit yang halus, lembut, bercahaya, dan tampak lebih cerah.',
                'duration' => 60,
                'price' => 290000.00,
                'category' => 'Body Scrub',
                'image' => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?auto=format&fit=crop&w=600&q=80',
                'is_available' => false,
                'total_bookings' => 8,
            ],
        ];

        $createdTreatments = [];
        foreach ($treatmentsData as $treatment) {
            $createdTreatments[] = Treatment::updateOrCreate(['slug' => $treatment['slug']], $treatment);
        }

        // 3. Seed Therapists
        $therapistsData = [
            [
                'name' => 'Eleni',
                'specialization' => 'Volcanic Massage & Facial',
                'rating' => 4.90,
                'status' => 'active',
                'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=80',
            ],
            [
                'name' => 'Dimitris',
                'specialization' => 'Deep Tissue & Sports Therapy',
                'rating' => 4.80,
                'status' => 'active',
                'image' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=300&q=80',
            ],
            [
                'name' => 'Chloe',
                'specialization' => 'Body Scrub & Aromatherapy',
                'rating' => 4.70,
                'status' => 'active',
                'image' => 'https://images.unsplash.com/photo-1567532939604-b6b5b0db2604?auto=format&fit=crop&w=300&q=80',
            ],
            [
                'name' => 'Sofia',
                'specialization' => 'All Treatment Specialist',
                'rating' => 5.00,
                'status' => 'active',
                'image' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=300&q=80',
            ],
            [
                'name' => 'Nikolaos',
                'specialization' => 'Traditional Massage',
                'rating' => 4.60,
                'status' => 'holiday',
                'image' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=300&q=80',
            ],
        ];

        $createdTherapists = [];
        foreach ($therapistsData as $therapist) {
            $createdTherapists[] = Therapist::updateOrCreate(['name' => $therapist['name']], $therapist);
        }

        // 4. Seed Mock Bookings spread over the last 7 days and today
        $activeTherapists = array_filter($createdTherapists, function ($t) {
            return $t->status === 'active';
        });
        $activeTherapists = array_values($activeTherapists);

        $customerNames = ['Budi Santoso', 'Siti Rahma', 'Aditya Pratama', 'Dewi Lestari', 'Rian Hidayat', 'Lina Marlina', 'Andi Wijaya', 'Sari Indah', 'Jessica Wong', 'Michael Tan'];
        $timeSlots = ['09:00', '10:30', '12:00', '13:30', '15:00', '16:30', '18:00', '19:30'];

        for ($i = 0; $i < 25; $i++) {
            $treatment = $createdTreatments[array_rand($createdTreatments)];
            $therapist = $activeTherapists[array_rand($activeTherapists)];
            $customerName = $customerNames[array_rand($customerNames)];

            $daysAgo = rand(0, 7);
            $bookingDate = Carbon::today()->subDays($daysAgo)->format('Y-m-d');
            $bookingTime = $timeSlots[array_rand($timeSlots)];

            if ($daysAgo > 0) {
                $status = rand(1, 10) > 2 ? 'completed' : 'cancelled';
            } else {
                $status = rand(1, 10) > 5 ? 'confirmed' : 'pending';
            }

            Booking::create([
                'booking_code' => 'SANTO-'.strtoupper(Str::random(6)),
                'customer_name' => $customerName,
                'treatment_id' => $treatment->id,
                'therapist_id' => $therapist->id,
                'booking_date' => $bookingDate,
                'booking_time' => $bookingTime,
                'notes' => rand(1, 10) > 6 ? 'Saya ingin terapis menekan lebih lembut di bagian pundak.' : null,
                'status' => $status,
                'total_price' => $treatment->price,
                'created_at' => Carbon::parse($bookingDate.' '.$bookingTime)->subHours(rand(1, 24)),
            ]);
        }
    }
}
