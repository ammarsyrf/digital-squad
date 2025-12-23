@extends('layouts.dashboard')

@section('title', $lowongan->judul . ' - Digital Skill Passport')

@section('header_title', 'Detail Pekerjaan')

@section('sidebar')
    @include('layouts.partials.sidebar-talent')
@endsection

@section('content')
    <div class="max-w-5xl mx-auto space-y-8 pb-12">
        <div
            class="bg-white dark:bg-slate-800 rounded-[32px] shadow-2xl shadow-slate-200/50 dark:shadow-none border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-500 hover:shadow-primary/5">
            <!-- Banner/Header with Premium Gradient -->
            <div class="h-48 bg-gradient-to-br from-primary via-blue-600 to-indigo-700 relative overflow-hidden">
                <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_30%_50%,rgba(255,255,255,0.4),transparent)]"></div>
                <div class="absolute -right-20 -top-20 size-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -left-10 -bottom-10 size-48 bg-blue-400/20 rounded-full blur-2xl"></div>
            </div>
            
            <div class="px-8 pb-8 relative">
                <div class="flex flex-col md:flex-row justify-between items-end gap-6">
                    <div class="flex flex-col md:flex-row items-end gap-6">
                        <div
                            class="size-32 rounded-3xl bg-white dark:bg-slate-700 p-2 shadow-2xl border border-slate-100 dark:border-slate-800 transform hover:scale-105 transition-transform duration-300 -mt-16">
                            @if($lowongan->umkm->logo)
                                <img src="{{ asset('storage/' . $lowongan->umkm->logo) }}" alt="Logo"
                                    class="w-full h-full object-cover rounded-2xl">
                            @else
                                <div
                                    class="w-full h-full bg-slate-50 dark:bg-slate-900 flex items-center justify-center rounded-2xl">
                                    <span class="material-symbols-outlined text-5xl text-slate-300">business</span>
                                </div>
                            @endif
                        </div>
                        <div class="pb-2">
                            <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight mb-1">{{ $lowongan->judul }}</h1>
                            <div class="flex items-center gap-2">
                                <p class="text-primary font-bold text-lg">{{ $lowongan->umkm->nama_umkm }}</p>
                                @if($lowongan->umkm->status_verifikasi == 'Terverifikasi')
                                    <span class="px-2 py-0.5 bg-emerald-500 text-white text-[9px] font-black rounded-full flex items-center gap-1 uppercase tracking-tighter">
                                        <span class="material-symbols-outlined text-[12px]">verified</span> Verified
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($hasApplied)
                        <div class="flex flex-col md:flex-row gap-3">
                            <div
                                class="px-8 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-black flex items-center gap-2 cursor-default transition-all">
                                <span class="material-symbols-outlined filled">check_circle</span>
                                Sudah Dilamar
                            </div>
                            <a href="{{ route('messages.show', $lowongan->umkm->user_id) }}"
                                class="px-8 py-4 bg-primary/5 text-primary border-2 border-primary/20 rounded-2xl font-black hover:bg-primary/10 transition-all flex items-center gap-2 active:scale-95">
                                <span class="material-symbols-outlined">chat</span>
                                Tanya Instansi
                            </a>
                        </div>
                    @else
                        <div class="flex flex-col md:flex-row gap-3">
                            <a href="{{ route('messages.show', $lowongan->umkm->user_id) }}"
                                class="px-8 py-4 border-2 border-primary text-primary rounded-2xl font-black hover:bg-primary/5 transition-all flex items-center gap-2 active:scale-95">
                                <span class="material-symbols-outlined">chat</span>
                                Tanya Instansi
                            </a>
                            <form action="{{ route('talent.jobs.apply', $lowongan->id) }}" method="POST" x-data="{ applying: false }" @submit="applying = true">
                                @csrf
                                <button type="submit"
                                    :disabled="applying"
                                    class="px-10 py-4 bg-primary text-white rounded-2xl font-black hover:bg-blue-600 transition-all shadow-xl shadow-primary/30 flex items-center gap-2 active:scale-95 disabled:opacity-50">
                                    <span class="material-symbols-outlined" x-show="!applying">send</span>
                                    <span class="animate-spin material-symbols-outlined" x-show="applying">progress_activity</span>
                                    <span x-text="applying ? 'Mengirim...' : 'Lamar Sekarang'"></span>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 border-t border-slate-100 dark:border-slate-700">
                <div class="lg:col-span-2 p-10 space-y-10">
                    <div>
                        <h3 class="text-2xl font-black mb-6 flex items-center gap-3">
                            <span class="size-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-xl">description</span>
                            </span>
                            Deskripsi Pekerjaan
                        </h3>
                        <div class="text-slate-600 dark:text-slate-400 leading-relaxed whitespace-pre-line text-lg">
                            {{ $lowongan->deskripsi }}
                        </div>
                    </div>
                </div>

                <!-- Glassmorphism Ringkasan Card -->
                <div class="p-10 bg-slate-50/50 dark:bg-slate-800/50 space-y-8 backdrop-blur-sm border-l border-slate-100 dark:border-slate-700">
                    <div>
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Ringkasan Karir</h4>
                        <div class="space-y-6">
                            <div class="flex items-center gap-4 group">
                                <div
                                    class="size-12 bg-white dark:bg-slate-700 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <span class="material-symbols-outlined text-primary">location_on</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Lokasi</p>
                                    <p class="text-base font-black text-slate-900 dark:text-white truncate">{{ $lowongan->lokasi }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 group">
                                <div
                                    class="size-12 bg-white dark:bg-slate-700 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <span class="material-symbols-outlined text-primary">schedule</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Tipe Kerja</p>
                                    <p class="text-base font-black text-slate-900 dark:text-white truncate">{{ $lowongan->tipe_pekerjaan }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 group">
                                <div
                                    class="size-12 bg-white dark:bg-slate-700 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <span class="material-symbols-outlined text-primary">payments</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Estimasi Gaji</p>
                                    <p class="text-base font-black text-slate-900 dark:text-white truncate">{{ $lowongan->gaji ?? 'As negotiated' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-10 border-t border-slate-200 dark:border-slate-700 space-y-6">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Tentang Instansi</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-4">
                            {{ $lowongan->umkm->deskripsi ?? 'Instansi ini belum mencantumkan deskripsi profil mereka secara mendalam.' }}</p>
                        <a href="{{ route('talent.umkm.show', $lowongan->umkm->id) }}" 
                            class="group flex items-center justify-between p-4 bg-primary/5 rounded-2xl border border-primary/10 hover:bg-primary/10 transition-all active:scale-95">
                            <span class="text-sm font-black text-primary">Lihat Profil Instansi</span>
                            <span class="material-symbols-outlined text-primary group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection