@extends('layouts.dashboard')

@section('title', 'Profil Instansi - ' . $umkm->nama_umkm)

@section('header_title', 'Profil Instansi')

@section('sidebar')
    @include('layouts.partials.sidebar-talent')
@endsection

@section('content')
    <div class="max-w-5xl mx-auto space-y-8 pb-12">
        <!-- Header Section with Premium Gradient -->
        <div
            class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="h-48 bg-gradient-to-r from-primary via-blue-600 to-indigo-700 relative">
                <div
                    class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_50%_120%,rgba(255,255,255,0.4),transparent)]">
                </div>
            </div>
            <div class="px-8 pb-8 relative flex flex-col md:flex-row items-end gap-6">
                <div
                    class="size-32 rounded-3xl bg-white dark:bg-slate-700 p-2 shadow-2xl border border-slate-100 dark:border-slate-800 -mt-16">
                    @if($umkm->logo)
                        <img src="{{ asset('storage/' . $umkm->logo) }}" alt="Logo"
                            class="w-full h-full object-cover rounded-2xl">
                    @else
                        <div
                            class="w-full h-full bg-slate-50 dark:bg-slate-900 flex items-center justify-center rounded-2xl text-slate-300">
                            <span class="material-symbols-outlined text-6xl">business</span>
                        </div>
                    @endif
                </div>
                <div class="flex-1 pb-2">
                    <div class="flex flex-wrap items-center gap-3 mb-1">
                        <h1 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $umkm->nama_umkm }}</h1>
                        @if($umkm->status_verifikasi == 'Terverifikasi')
                            <span
                                class="px-3 py-1 bg-emerald-500 text-white text-[10px] font-black rounded-full flex items-center gap-1 uppercase tracking-tighter">
                                <span class="material-symbols-outlined text-[14px]">verified</span> Terverifikasi
                            </span>
                        @endif
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 flex items-center gap-2 font-medium">
                        <span class="material-symbols-outlined text-sm">location_on</span>
                        {{ $umkm->alamat ?? 'Lokasi tidak tersedia' }}
                    </p>
                </div>
                <div class="pb-2">
                    <a href="{{ route('messages.show', $umkm->user_id) }}"
                        class="px-8 py-3 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/30 hover:bg-blue-600 hover:scale-105 active:scale-95 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined">chat</span>
                        Hubungi Instansi
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Description -->
            <div class="lg:col-span-2 space-y-8">
                <div
                    class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-sm border border-slate-200 dark:border-slate-700">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">info</span>
                        Tentang Instansi
                    </h3>
                    <div class="text-slate-600 dark:text-slate-400 leading-relaxed whitespace-pre-line text-lg">
                        {{ $umkm->deskripsi ?? 'Instansi ini belum menambahkan deskripsi.' }}
                    </div>
                </div>

                <!-- Gallery Section -->
                @if($umkm->galeri && count(json_decode($umkm->galeri)) > 0)
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-sm border border-slate-200 dark:border-slate-700">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">photo_library</span>
                        Galeri & Suasana Kerja
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach(json_decode($umkm->galeri) as $img)
                            <div class="aspect-square rounded-xl overflow-hidden group shadow-sm cursor-pointer">
                                <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar Info (Glassmorphism inspired) -->
            <div class="space-y-6">
                
                <!-- Business Details -->
                <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl p-8 shadow-sm border border-slate-200 dark:border-slate-700">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 dark:border-slate-700 pb-4">Info Bisnis</h4>
                    <div class="space-y-4">
                         <div class="flex justify-between items-center text-sm">
                             <span class="text-slate-500">Kategori</span>
                             <span class="font-bold text-slate-900 dark:text-white">{{ $umkm->kategori ?? '-' }}</span>
                         </div>
                         <div class="flex justify-between items-center text-sm">
                             <span class="text-slate-500">Skala</span>
                             <span class="font-bold text-slate-900 dark:text-white">{{ $umkm->skala_usaha ?? '-' }}</span>
                         </div>
                         <div class="flex justify-between items-center text-sm">
                             <span class="text-slate-500">Tahun Berdiri</span>
                             <span class="font-bold text-slate-900 dark:text-white">{{ $umkm->tahun_berdiri ?? '-' }}</span>
                         </div>
                         <div class="flex justify-between items-center text-sm">
                             <span class="text-slate-500">Karyawan</span>
                             <span class="font-bold text-slate-900 dark:text-white">{{ $umkm->jumlah_karyawan ?? '-' }} Orang</span>
                         </div>
                    </div>
                </div>

                <!-- Social Media -->
                 @if($umkm->instagram || $umkm->tiktok || $umkm->whatsapp)
                <div class="grid grid-cols-3 gap-3">
                    @if($umkm->instagram)
                        <a href="{{ $umkm->instagram }}" target="_blank"
                            class="py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl flex items-center justify-center hover:border-pink-500 hover:text-pink-500 transition-all shadow-sm group">
                            <i class="fa-brands fa-instagram text-xl group-hover:scale-110 transition-transform"></i>
                             <!-- Fallback Icon if FA not loaded -->
                             <span class="sr-only">Instagram</span>
                             <span class="material-symbols-outlined text-pink-500" style="font-family: 'Material Symbols Outlined';">photo_camera</span>
                        </a>
                    @endif
                    @if($umkm->tiktok)
                        <a href="{{ $umkm->tiktok }}" target="_blank"
                            class="py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl flex items-center justify-center hover:border-black dark:hover:border-white hover:text-black dark:hover:text-white transition-all shadow-sm group">
                            <i class="fa-brands fa-tiktok text-xl group-hover:scale-110 transition-transform"></i>
                            <span class="sr-only">TikTok</span>
                             <span class="material-symbols-outlined" style="font-family: 'Material Symbols Outlined';">music_note</span>
                        </a>
                    @endif
                    @if($umkm->whatsapp)
                        <a href="{{ $umkm->whatsapp }}" target="_blank"
                            class="py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl flex items-center justify-center hover:border-emerald-500 hover:text-emerald-500 transition-all shadow-sm group">
                            <i class="fa-brands fa-whatsapp text-xl group-hover:scale-110 transition-transform"></i>
                            <span class="sr-only">WhatsApp</span>
                             <span class="material-symbols-outlined text-emerald-500" style="font-family: 'Material Symbols Outlined';">chat</span>
                        </a>
                    @endif
                </div>
                @endif

                <div
                    class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl p-8 shadow-sm border border-slate-200 dark:border-slate-700">
                    <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6 text-center">Informasi
                        Kontak</h4>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4 group">
                            <div
                                class="size-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110">
                                <span class="material-symbols-outlined">public</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-tighter">Website</p>
                                @if($umkm->website)
                                    <a href="{{ $umkm->website }}" target="_blank"
                                        class="text-sm font-bold text-primary truncate block hover:underline">{{ parse_url($umkm->website, PHP_URL_HOST) }}</a>
                                @else
                                    <p class="text-sm font-bold text-slate-500 italic">Tidak tersedia</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-4 group">
                            <div
                                class="size-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110">
                                <span class="material-symbols-outlined">mail</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-tighter">Email Instansi</p>
                                <p class="text-sm font-bold text-slate-900 dark:text-white truncate">
                                    {{ $umkm->email_instansi ?? 'Tidak dicantumkan' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 group">
                            <div
                                class="size-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110">
                                <span class="material-symbols-outlined">call</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-tighter">Telepon Kerja</p>
                                <p class="text-sm font-bold text-slate-900 dark:text-white">
                                    {{ $umkm->telepon ?? 'Tidak ada kontak' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('talent.jobs') }}"
                    class="w-full py-4 bg-slate-900 dark:bg-slate-700 text-white rounded-2xl font-bold flex items-center justify-center gap-2 hover:bg-slate-800 transition-all shadow-xl">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Kembali ke Lowongan
                </a>
            </div>
        </div>
    </div>
@endsection