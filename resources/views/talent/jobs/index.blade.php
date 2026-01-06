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
                <a href="{{ route('talent.jobs.show', $job->id_lowongan) }}"
                    class="block bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
                    
                    <div class="absolute top-0 right-0 p-4 opacity-50">
                        <span class="material-symbols-outlined text-6xl text-slate-100 dark:text-slate-700 transform rotate-12 group-hover:rotate-0 transition-transform duration-500">work</span>
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="size-14 rounded-2xl bg-white dark:bg-slate-700 flex items-center justify-center shrink-0 overflow-hidden shadow-sm border border-slate-100 dark:border-slate-600">
                                    @if($job->umkm->logo)
                                        <img src="{{ asset('storage/' . $job->umkm->logo) }}" alt="Logo" class="w-full h-full object-cover">
                                    @else
                                        <span class="material-symbols-outlined text-slate-400 text-2xl">business</span>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg text-slate-900 dark:text-white group-hover:text-primary transition-colors line-clamp-1">
                                        {{ $job->judul }}</h3>
                                    <p class="text-sm font-medium text-slate-500 line-clamp-1">{{ $job->umkm->nama_umkm }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-2.5 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg text-xs font-bold border border-blue-100 dark:border-blue-800">
                                {{ $job->tipe_pekerjaan }}
                            </span>
                             @if($job->sistem_kerja)
                            <span class="px-2.5 py-1 bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 rounded-lg text-xs font-bold border border-purple-100 dark:border-purple-800">
                                {{ $job->sistem_kerja }}
                            </span>
                            @endif
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-slate-500 text-sm">
                                <span class="material-symbols-outlined text-[18px]">location_on</span>
                                <span class="truncate">{{ $job->lokasi }}</span>
                            </div>
                             <div class="flex items-center gap-2 text-slate-500 text-sm">
                                <span class="material-symbols-outlined text-[18px]">payments</span>
                                <span class="truncate font-medium text-slate-700 dark:text-slate-300">{{ $job->gaji ?? 'Kompetitif' }}</span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between text-xs text-slate-400">
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                {{ $job->created_at->diffForHumans() }}
                            </span>
                            <span class="group-hover:translate-x-1 transition-transform text-primary font-bold">Lihat Detail →</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-16 text-center bg-white dark:bg-slate-800 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-700">
                    <div class="inline-flex p-4 bg-slate-50 dark:bg-slate-700/50 rounded-full mb-4">
                         <span class="material-symbols-outlined text-4xl text-slate-400">search_off</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">Belum ada lowongan</h3>
                    <p class="text-slate-500">Coba ubah filter atau kata kunci pencarian Anda.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection