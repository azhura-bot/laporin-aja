@extends('layouts.dashboard.index')

@section('dashboard-content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Laporan Saya</h1>
        <a href="{{ route('laporan.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
            <i class="fas fa-plus mr-2"></i>Buat Laporan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($laporans->isEmpty())
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <i class="fas fa-file-alt text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">Belum ada laporan yang dibuat</p>
            <a href="{{ route('laporan.create') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                Buat laporan pertama Anda
            </a>
        </div>
    @else
        <div class="grid gap-4">
            @foreach($laporans as $laporan)
            <a href="{{ route('laporan.show', $laporan->id) }}" class="group block bg-white rounded-lg shadow p-4 hover:shadow-md transition hover:-translate-y-0.5">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">
                                {{ $laporan->judul_laporan }}
                            </h3>
                            {!! $laporan->status_badge !!}
                        </div>
                        <p class="text-gray-600 text-sm mb-2">
                            <i class="fas fa-map-marker-alt mr-1"></i> {{ $laporan->lokasi }}
                        </p>
                        <p class="text-gray-500 text-sm">
                            <i class="fas fa-calendar mr-1"></i> {{ $laporan->tanggal_kejadian->format('d/m/Y') }}
                        </p>
                    </div>
                    <span class="text-blue-600 opacity-0 group-hover:opacity-100 transition-all duration-300 flex-shrink-0">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $laporans->links() }}
        </div>
    @endif
</div>
@endsection