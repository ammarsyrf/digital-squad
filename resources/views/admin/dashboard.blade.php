@extends('layouts.dashboard')

@section('title', 'Beranda Admin - Digital Skill Passport')

@section('header_title', 'Beranda Admin')

@section('sidebar')
    @include('layouts.partials.sidebar-admin')
@endsection

@section('content')
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            <!-- Stat Card 1 -->
            <div
                class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Total Talenta</p>
                        <h3 class="text-3xl font-bold text-slate-800 dark:text-white">
                            {{ number_format($stats['total_talent']) }}
                        </h3>
                    </div>
                    <div class="p-2 bg-primary/10 text-primary rounded-lg">
                        <span class="material-symbols-outlined">group</span>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-emerald-600 font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">trending_up</span> +5%
                    </span>
                    <span class="text-slate-400 ml-2">bulan ini</span>
                </div>
            </div>
            <!-- Stat Card 2 -->
            <div
                class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-l-4 border-l-orange-500 border-y-slate-200 border-r-slate-200 dark:border-y-slate-700 dark:border-r-slate-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Sertifikat Pending</p>
                        <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $stats['pending_sertifikat'] }}
                        </h3>
                    </div>
                    <div class="p-2 bg-orange-100 text-orange-600 dark:bg-orange-900/20 dark:text-orange-400 rounded-lg">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span
                        class="text-orange-600 font-medium text-xs bg-orange-100 dark:bg-orange-900/30 px-2 py-0.5 rounded-full">Butuh
                        Tindakan</span>
                    <span class="text-slate-400 ml-auto text-xs">Baru saja</span>
                </div>
            </div>
            <!-- Stat Card 3 -->
            <div
                class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-l-4 border-l-blue-500 border-y-slate-200 border-r-slate-200 dark:border-y-slate-700 dark:border-r-slate-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Verifikasi UMKM</p>
                        <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $stats['total_umkm'] }}</h3>
                    </div>
                    <div class="p-2 bg-blue-100 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400 rounded-lg">
                        <span class="material-symbols-outlined">store</span>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-emerald-600 font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">trending_up</span> +2%
                    </span>
                    <span class="text-slate-400 ml-2">bulan ini</span>
                </div>
            </div>
            <!-- Stat Card 4 -->
            <div
                class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Lowongan Aktif</p>
                        <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $stats['total_lowongan'] }}</h3>
                    </div>
                    <div class="p-2 bg-indigo-100 text-indigo-600 dark:bg-indigo-900/20 dark:text-indigo-400 rounded-lg">
                        <span class="material-symbols-outlined">work</span>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-emerald-600 font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">trending_up</span> +8%
                    </span>
                    <span class="text-slate-400 ml-2">minggu ini</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="space-y-4">
                    <h2 class="text-xl font-bold text-slate-800 dark:text-white tracking-tight">Aksi Cepat</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div
                            class="relative group cursor-pointer overflow-hidden rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 p-6 text-white shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 transition-all hover:-translate-y-1">
                            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                                <span class="material-symbols-outlined text-8xl">verified</span>
                            </div>
                            <div class="relative z-10 flex flex-col h-full justify-between gap-4">
                                <div
                                    class="size-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                    <span class="material-symbols-outlined">approval_delegation</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg">Verifikasi Sertifikat</h3>
                                    <p class="text-blue-100 text-sm mt-1">15 permintaan menunggu</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="relative group cursor-pointer overflow-hidden rounded-xl bg-white dark:bg-surface-dark border border-slate-200 dark:border-slate-700 p-6 shadow-sm hover:shadow-md hover:border-blue-300 dark:hover:border-blue-700 transition-all">
                            <div class="flex flex-col h-full justify-between gap-4">
                                <div
                                    class="size-10 bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined">storefront</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg text-slate-800 dark:text-white">Verifikasi Akun UMKM</h3>
                                    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Review 5 pendaftaran baru</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Analytic Chart Placeholder -->
                <div
                    class="bg-surface-light dark:bg-surface-dark rounded-xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-lg text-slate-800 dark:text-white">Statistik Verifikasi</h3>
                        <select
                            class="text-sm bg-slate-50 dark:bg-slate-800 border-none rounded-lg text-slate-600 dark:text-slate-300 focus:ring-0 cursor-pointer">
                            <option>7 Hari Terakhir</option>
                            <option>30 Hari Terakhir</option>
                        </select>
                    </div>
                    <div class="h-64 w-full flex items-end justify-between gap-2 px-2">
                        <div class="w-full bg-primary/20 rounded-t-sm h-[40%]"></div>
                        <div class="w-full bg-primary/40 rounded-t-sm h-[60%]"></div>
                        <div class="w-full bg-primary/30 rounded-t-sm h-[30%]"></div>
                        <div class="w-full bg-primary/60 rounded-t-sm h-[75%]"></div>
                        <div class="w-full bg-primary/50 rounded-t-sm h-[50%]"></div>
                        <div class="w-full bg-primary/80 rounded-t-sm h-[85%]"></div>
                        <div class="w-full bg-primary rounded-t-sm h-[65%]"></div>
                    </div>
                    <div class="flex justify-between mt-2 text-xs text-slate-400 px-2">
                        <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span>
                    </div>
                </div>
            </div>
            <!-- Right Column: Activity -->
            <div class="lg:col-span-1">
                <div
                    class="bg-surface-light dark:bg-surface-dark rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm h-full flex flex-col">
                    <div class="p-5 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center">
                        <h3 class="font-bold text-lg text-slate-800 dark:text-white">Aktivitas Terbaru</h3>
                        <span class="material-symbols-outlined text-slate-400">history</span>
                    </div>
                    <div class="flex-1 overflow-y-auto p-2">
                        <div
                            class="p-3 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors flex gap-3">
                            <div
                                class="mt-1 size-8 shrink-0 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm">upload_file</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Ahmad S. mengunggah
                                    sertifikat</p>
                                <p class="text-xs text-slate-500 mt-1">5 menit yang lalu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection