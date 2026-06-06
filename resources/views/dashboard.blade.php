<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Santorini Spa') }}
        </h2>
    </x-slot>

    <!-- ApexCharts CDN for premium interactive charts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Session Alert Success -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- 1. Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Today's Booking -->
                <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Booking Hari Ini</span>
                        <span class="text-3xl font-extrabold text-slate-800 block">{{ $todayBookingsCount }}</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 text-[#0D5C75] flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <!-- Today's Revenue -->
                <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Pendapatan Hari Ini</span>
                        <span class="text-2xl font-extrabold text-slate-800 block">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Active Therapists -->
                <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Terapis Aktif</span>
                        <span class="text-3xl font-extrabold text-slate-800 block">{{ $activeTherapistsCount }}</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Pending Bookings -->
                <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Pending Booking</span>
                        <span class="text-3xl font-extrabold text-slate-800 block">{{ $pendingBookingsCount }}</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- 2. Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Bookings Per Day Area Chart -->
                <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm">
                    <h3 class="font-bold text-slate-800 text-sm mb-4 uppercase tracking-wider text-slate-500">Statistik Booking (7 Hari Terakhir)</h3>
                    <div id="bookings-line-chart" class="w-full"></div>
                </div>

                <!-- Popular Treatments Bar Chart -->
                <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm">
                    <h3 class="font-bold text-slate-800 text-sm mb-4 uppercase tracking-wider text-slate-500">Treatment Terpopuler (Total Booking)</h3>
                    <div id="treatments-bar-chart" class="w-full"></div>
                </div>
            </div>

            <!-- 3. Recent Bookings Table -->
            <div class="bg-white rounded-3xl border border-sky-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-sky-50 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-slate-800 text-base leading-snug">Daftar Booking Terbaru</h3>
                        <p class="text-xs text-slate-400 mt-1">Menampilkan transaksi reservasi paling baru masuk ke sistem</p>
                    </div>
                    <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 text-xs font-semibold text-[#0D5C75] bg-sky-50 rounded-xl hover:bg-sky-100 transition-colors">
                        Kelola Semua Booking
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 uppercase tracking-wider font-semibold border-b border-sky-50 text-[10px]">
                                <th class="p-4 pl-6">Kode Booking</th>
                                <th class="p-4">Customer</th>
                                <th class="p-4">Treatment</th>
                                <th class="p-4">Terapis</th>
                                <th class="p-4">Jadwal Booking</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 text-right pr-6">Biaya</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sky-50">
                            @forelse($recentBookings as $booking)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4 pl-6 font-bold text-[#0D5C75]">{{ $booking->booking_code }}</td>
                                    <td class="p-4 font-semibold text-slate-800">{{ $booking->customer_name }}</td>
                                    <td class="p-4 text-slate-600 font-medium">{{ $booking->treatment->name }}</td>
                                    <td class="p-4 text-slate-600">{{ $booking->therapist->name }}</td>
                                    <td class="p-4 font-medium text-slate-600">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                                        <span class="text-slate-400 text-[10px] ml-1">{{ substr($booking->booking_time, 0, 5) }}</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        @if($booking->status === 'pending')
                                            <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider bg-amber-50 text-amber-600 rounded-full border border-amber-200">Pending</span>
                                        @elseif($booking->status === 'confirmed')
                                            <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider bg-sky-50 text-[#0D5C75] rounded-full border border-sky-200">Konfirmasi</span>
                                        @elseif($booking->status === 'completed')
                                            <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 rounded-full border border-emerald-200">Selesai</span>
                                        @else
                                            <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider bg-rose-50 text-rose-500 rounded-full border border-rose-200">Batal</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right pr-6 font-bold text-slate-800">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-slate-400 font-medium">Belum ada transaksi booking masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Charts Render Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Line Chart setup (Bookings per Day)
            var bookingsOptions = {
                chart: {
                    type: 'area',
                    height: 280,
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                series: [{
                    name: 'Jumlah Booking',
                    data: {!! json_encode($chartBookingsData) !!}
                }],
                colors: ['#0D5C75'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.45,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                xaxis: {
                    categories: {!! json_encode($chartBookingsLabels) !!},
                    labels: { style: { colors: '#94a3b8', fontSize: '10px', fontWeight: 600 } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    min: 0,
                    tickAmount: 5,
                    labels: { style: { colors: '#94a3b8', fontSize: '10px' } }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: true } }
                }
            };
            var bookingsChart = new ApexCharts(document.querySelector("#bookings-line-chart"), bookingsOptions);
            bookingsChart.render();

            // Bar Chart setup (Popular Treatments)
            var treatmentsOptions = {
                chart: {
                    type: 'bar',
                    height: 280,
                    toolbar: { show: false }
                },
                series: [{
                    name: 'Total Reservasi',
                    data: {!! json_encode($chartPopularData) !!}
                }],
                colors: ['#C5A880'],
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 6,
                        barHeight: '45%'
                    }
                },
                dataLabels: { enabled: false },
                xaxis: {
                    categories: {!! json_encode($chartPopularLabels) !!},
                    labels: { style: { colors: '#94a3b8', fontSize: '9px', fontWeight: 600 } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: { style: { colors: '#475569', fontSize: '10px', fontWeight: 600 } }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4
                }
            };
            var treatmentsChart = new ApexCharts(document.querySelector("#treatments-bar-chart"), treatmentsOptions);
            treatmentsChart.render();
        });
    </script>
</x-app-layout>
