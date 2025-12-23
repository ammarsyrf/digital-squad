@extends('layouts.dashboard')

@section('title', 'Cari Lowongan - Digital Skill Passport')

@section('header_title', 'Cari Pekerjaan')

@section('sidebar')
    @include('layouts.partials.sidebar-talent')
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Search Bar -->
        <div
            class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <span
                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input type="text" placeholder="Cari posisi atau kata kunci..."
                    class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-xl focus:ring-2 focus:ring-primary">
            </div>
            <div class="flex-1 relative md:max-w-[200px]">
                <span
                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">location_on</span>
                <input type="text" placeholder="Lokasi"
                    class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-xl focus:ring-2 focus:ring-primary">
            </div>
            <button
                class="px-8 py-3 bg-primary text-white rounded-xl font-bold shadow-lg shadow-primary/30 hover:bg-blue-600 transition-all">
                Cari
            </button>
        </div>

        <!-- Job Feed -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($jobs as $job)
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-md transition-all group">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="size-12 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center shrink-0 overflow-hidden">
                            @if($job->umkm->logo)
                                <img src="{{ asset('storage/' . $job->umkm->logo) }}" alt="Logo" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-slate-400">business</span>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                                {{ $job->judul }}</h3>
                            <p class="text-xs text-slate-500">{{ $job->umkm->nama_umkm }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 mb-6">
                        <span
                            class="px-2 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded text-[10px] font-bold">{{ $job->tipe_pekerjaan }}</span>
                        <span
                            class="px-2 py-1 bg-slate-50 dark:bg-slate-900/50 text-slate-500 rounded text-[10px] font-bold">{{ $job->lokasi }}</span>
                    </div>

                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 line-clamp-2">{{ $job->deskripsi }}</p>

                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-100 dark:border-slate-700">
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-200">{{ $job->gaji ?? 'Gaji Rahasia' }}</p>
                        <a href="{{ route('talent.jobs.show', $job->id) }}"
                            class="text-xs font-bold text-primary hover:underline">Detail →</a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <p class="text-slate-500">Belum ada lowongan yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection