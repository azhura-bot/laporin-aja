@extends('layouts.admin')

@section('page-title', 'Data & Analisis')
@section('page-description', 'Analisis data laporan dan statistik sistem')

@section('admin-content')
<div class="space-y-6">
    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Laporan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalLaporan }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-bar text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Warga</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalWarga }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Rata-rata per Hari</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $rataRataPerHari }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-day text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Monthly Trend -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Trend Laporan Bulanan</h3>
            <canvas id="monthlyChart" class="w-full h-64"></canvas>
        </div>

        <!-- Status Distribution -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Status</h3>
            <canvas id="statusChart" class="w-full h-64"></canvas>
        </div>
    </div>

    <!-- Category Analysis -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Categories -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Kategori Terpopuler</h3>
            <div class="space-y-3">
                @foreach($topKategori as $kategori)
                <div class="flex items-center justify-between">
                    <span class="text-gray-700">{{ $kategori->kategori }}</span>
                    <div class="flex items-center gap-2">
                        <div class="w-20 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $totalLaporan > 0 ? ($kategori->total / $totalLaporan) * 100 : 0 }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-600">{{ $kategori->total }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Category Breakdown -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Breakdown Kategori</h3>
            <canvas id="categoryChart" class="w-full h-64"></canvas>
        </div>
    </div>

    <!-- Detailed Statistics Table -->
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Detail</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2 font-medium text-gray-700">Kategori</th>
                        <th class="text-center py-2 font-medium text-gray-700">Total</th>
                        <th class="text-center py-2 font-medium text-gray-700">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statistikKategori as $stat)
                    <tr class="border-b">
                        <td class="py-2 text-gray-900">{{ $stat->kategori }}</td>
                        <td class="py-2 text-center text-gray-900">{{ $stat->total }}</td>
                        <td class="py-2 text-center text-gray-600">{{ $totalLaporan > 0 ? round(($stat->total / $totalLaporan) * 100, 1) : 0 }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: @json($bulanLabels),
            datasets: [{
                label: 'Laporan per Bulan',
                data: @json($bulanData),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusData = @json($statistikStatus->pluck('total')->toArray());
    const statusLabels = @json($statistikStatus->pluck('status')->toArray());
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: statusLabels.map(s => s.charAt(0).toUpperCase() + s.slice(1)),
            datasets: [{
                data: statusData,
                backgroundColor: ['#f59e0b', '#3b82f6', '#10b981'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryData = @json($statistikKategori->pluck('total')->toArray());
    const categoryLabels = @json($statistikKategori->pluck('kategori')->toArray());
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: categoryLabels,
            datasets: [{
                label: 'Jumlah Laporan',
                data: categoryData,
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: '#3b82f6',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endsection