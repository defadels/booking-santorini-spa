<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Therapist;
use App\Models\Treatment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function index()
    {
        $today = Carbon::today()->format('Y-m-d');

        // Statistics
        $todayBookingsCount = Booking::whereDate('booking_date', $today)->count();

        $todayRevenue = Booking::whereDate('booking_date', $today)
            ->whereIn('status', ['confirmed', 'completed'])
            ->sum('total_price');

        $activeTherapistsCount = Therapist::where('status', 'active')->count();

        $pendingBookingsCount = Booking::where('status', 'pending')->count();

        // Recent bookings list (last 8)
        $recentBookings = Booking::with(['treatment', 'therapist'])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Chart Data 1: Bookings per day (last 7 days including today)
        $chartBookingsLabels = [];
        $chartBookingsData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartBookingsLabels[] = $this->translateDayMonth($date);
            $chartBookingsData[] = Booking::whereDate('booking_date', $date->format('Y-m-d'))->count();
        }

        // Chart Data 2: Most Popular Treatments (top 5 by total_bookings)
        $popularTreatments = Treatment::orderBy('total_bookings', 'desc')
            ->take(5)
            ->get();

        $chartPopularLabels = $popularTreatments->pluck('name')->toArray();
        $chartPopularData = $popularTreatments->pluck('total_bookings')->toArray();

        return view('dashboard', compact(
            'todayBookingsCount',
            'todayRevenue',
            'activeTherapistsCount',
            'pendingBookingsCount',
            'recentBookings',
            'chartBookingsLabels',
            'chartBookingsData',
            'chartPopularLabels',
            'chartPopularData'
        ));
    }

    /**
     * Local translation helper for chart labels (e.g. "07 Jun").
     */
    private function translateDayMonth($date)
    {
        $day = $date->format('d');
        $month = $date->format('M');
        $translations = [
            'Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr',
            'May' => 'Mei', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Agt',
            'Sep' => 'Sep', 'Oct' => 'Okt', 'Nov' => 'Nov', 'Dec' => 'Des',
        ];

        return $day.' '.($translations[$month] ?? $month);
    }
}
