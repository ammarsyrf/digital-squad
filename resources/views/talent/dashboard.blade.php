@extends('layouts.dashboard')

@section('title', 'Beranda Talenta Digital - Skill Passport')

@section('header_title', 'Beranda Talenta')

@section('sidebar')
    @include('layouts.partials.sidebar-talent')
@endsection

@section('content')
    <div class="space-y-8 pb-12">
        <!-- Profile Hero Section -->
        <section
            class="bg-gradient-to-br from-primary via-blue-600 to-blue-700 rounded-2xl shadow-xl shadow-blue-500/20 p-8 relative overflow-hidden text-white border-none">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 pointer-events-none">
            </div>
            <div class="flex flex-col md:flex-row gap-8 md:items-center relative z-10">
                <div class="relative group">
                    <div
                        class="w-24 h-24 md:w-32 md:h-32 rounded-full bg-slate-200 flex items-center justify-center border-4 border-white/30 shadow-2xl overflow-hidden">
                        @if (optional($talent)->foto)
                            <img src="{{ asset('storage/' . optional($talent)->foto) }}" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-slate-500 text-5xl">person</span>
                        @endif
                    </div>
                    <a href="{{ route('talent.profile') }}"
                        class="absolute bottom-1 right-1 bg-white p-1.5 rounded-full shadow-lg text-primary hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                    </a>
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-3 mb-2">
                        <h2 class="text-3xl md:text-4xl font-bold">{{ Auth::user()->name ?? 'Talenta Digital' }}</h2>
                        <span
                            class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-bold rounded-full flex items-center gap-1 border border-white/30">
                            <span class="material-symbols-outlined text-[14px]">verified</span> <span>Verified Talent</span>
                        </span>
                    </div>
                    <p class="text-blue-50 font-bold text-lg mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">work</span>
                        {{ optional($talent)->pekerjaan_saat_ini ?? 'Talenta Digital' }}
                        <span class="opacity-50">•</span>
                        <span class="material-symbols-outlined text-sm">location_on</span>
                        {{ optional($talent)->alamat ?? 'Indonesia' }}
                    </p>
                    <!-- Passport Strength -->
                    <div class="max-w-md">
                        <div class="flex justify-between items-end mb-2">
                            <span class="font-bold">Kelengkapan Profil (Badge Strength)</span>
                            <span class="text-sm font-black">{{ $stats['profile_completion'] }}%</span>
                        </div>
                        <div class="w-full bg-white/20 rounded-full h-3 overflow-hidden p-0.5">
                            <div class="bg-white h-full rounded-full shadow-[0_0_10px_rgba(255,255,255,0.5)] transition-all duration-1000"
                                style="width: {{ $stats['profile_completion'] }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-4 min-w-[220px]">
                    <div
                        class="flex items-center justify-between p-4 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                        <span class="text-sm font-bold">Status Kerja</span>
                        <div class="relative inline-block w-10 align-middle select-none">
                            <input type="checkbox" id="work_status" checked
                                class="peer absolute block w-5 h-5 rounded-full bg-white border-2 border-slate-300 appearance-none cursor-pointer transition-all duration-300 checked:translate-x-5 checked:border-green-400">
                            <label for="work_status"
                                class="block overflow-hidden h-5 rounded-full bg-white/20 cursor-pointer"></label>
                        </div>
                    </div>
                    <a href="{{ route('talent.profile') }}"
                        class="py-3 px-4 bg-white text-primary rounded-xl font-bold text-center hover:bg-blue-50 transition-colors shadow-lg">
                        Lihat Detail Profil </a>
                </div>
            </div>
        </section>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="group bg-gradient-to-br from-blue-500 to-primary p-6 rounded-2xl shadow-lg shadow-blue-500/10 flex items-start justify-between text-white border-none transform hover:-translate-y-1 transition-all duration-300">
                <div>
                    <p class="text-blue-50 text-sm font-black mb-1 uppercase tracking-wider">Total Lamaran</p>
                    <h3 class="text-5xl font-black">{{ $stats['total_lamaran'] }}</h3>
                    <div
                        class="bg-white/20 backdrop-blur-md px-2 py-1 rounded-lg mt-3 inline-flex items-center gap-1 text-[10px] font-black">
                        <span class="material-symbols-outlined text-[12px]">trending_up</span> <span>TERKIRIM</span>
                    </div>
                </div>
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-md">
                    <span class="material-symbols-outlined text-2xl">send</span>
                </div>
            </div>
            <div
                class="group bg-gradient-to-br from-indigo-500 to-purple-600 p-6 rounded-2xl shadow-lg shadow-purple-500/10 flex items-start justify-between text-white border-none transform hover:-translate-y-1 transition-all duration-300">
                <div>
                    <p class="text-indigo-50 text-sm font-black mb-1 uppercase tracking-wider">Tes Skill Selesai</p>
                    <h3 class="text-5xl font-black">{{ $stats['total_tes'] }}</h3>
                    <p class="text-indigo-50 text-xs mt-3 font-black">Avg Score: {{ $stats['rata_skor'] }}/100</p>
                </div>
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-md">
                    <span class="material-symbols-outlined text-2xl">quiz</span>
                </div>
            </div>
            <div
                class="group bg-gradient-to-br from-emerald-500 to-teal-600 p-6 rounded-2xl shadow-lg shadow-emerald-500/10 flex items-start justify-between text-white border-none transform hover:-translate-y-1 transition-all duration-300">
                <div>
                    <p class="text-emerald-50 text-sm font-black mb-1 uppercase tracking-wider">Sertifikat</p>
                    <h3 class="text-5xl font-black">{{ $stats['total_sertifikat'] }}</h3>
                    <div
                        class="bg-white/20 backdrop-blur-md px-2 py-1 rounded-lg mt-3 inline-flex items-center gap-1 text-[10px] font-black">
                        <span class="material-symbols-outlined text-[12px]">verified</span> TERVERIFIKASI
                    </div>
                </div>
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-md">
                    <span class="material-symbols-outlined text-2xl">workspace_premium</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Left Column: Skills & Recent Jobs -->
            <div class="xl:col-span-2 space-y-8">
                <!-- Skill Summary -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                        <h3 class="font-bold text-lg">Ringkasan Skill Digital</h3>
                    </div>
                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                            <div class="space-y-6">
                                @forelse($skills_data as $index => $skill)
                                    @php
                                        $grads = ['from-blue-500 to-indigo-600', 'from-purple-500 to-pink-600', 'from-emerald-500 to-teal-600', 'from-orange-500 to-red-600', 'from-cyan-500 to-blue-600'];
                                        $grad = $grads[$index % count($grads)];
                                    @endphp
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <span
                                                class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ $skill->kategori->nama_kategori }}</span>
                                            <span class="text-xs font-black text-primary">{{ round($skill->skor) }}%</span>
                                        </div>
                                        <div
                                            class="w-full bg-slate-100 dark:bg-slate-700/50 rounded-full h-2.5 overflow-hidden">
                                            <div class="bg-gradient-to-r {{ $grad }} h-full rounded-full transition-all duration-1000"
                                                style="width: {{ $skill->skor }}%"></div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <span class="material-symbols-outlined text-slate-300 text-5xl mb-3">analytics</span>
                                        <p class="text-slate-500 text-sm">Belum ada data skill.</p>
                                    </div>
                                @endforelse
                            </div>
                            <div class="h-64 relative">
                                @if(count($skills_data) >= 3)
                                    <canvas id="skillRadarChart"></canvas>
                                @else
                                    <div class="h-full flex flex-col items-center justify-center text-center opacity-30">
                                        <span class="material-symbols-outlined text-7xl">radar</span>
                                        <p class="text-xs mt-2 font-bold uppercase tracking-widest">Minimal 3 Skill</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Applications -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center">
                        <h3 class="font-bold text-lg">Lamaran Terbaru</h3>
                        <a href="{{ route('talent.applications') }}"
                            class="text-primary text-xs font-black hover:underline">Lihat Semua</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead
                                class="bg-slate-50/50 dark:bg-slate-800/50 text-slate-500 font-bold border-b border-slate-100 dark:border-slate-700">
                                <tr>
                                    <th class="px-6 py-4">Perusahaan</th>
                                    <th class="px-6 py-4">Posisi</th>
                                    <th class="px-6 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                                @forelse($recent_lamaran as $lamaran)
                                                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                                            <td class="px-6 py-4">
                                                                <div class="flex items-center gap-3">
                                                                    <div
                                                                        class="size-8 rounded bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">
                                                                        {{ substr($lamaran->lowongan?->umkm?->nama_umkm ?? 'U', 0, 1) }}
                                                                    </div>
                                                                    <span
                                                                        class="font-bold text-slate-700 dark:text-slate-200 line-clamp-1">{{ $lamaran->lowongan?->umkm?->nama_umkm ?? 'Instansi' }}</span>
                                                                </div>
                                                            </td>
                                                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400 font-medium">
                                                                {{ $lamaran->lowongan->judul }}
                                                            </td>
                                                            <td class="px-6 py-4 text-right">
                                                                <span
                                                                    class="px-3 py-1 rounded-full text-[10px] font-black uppercase
                                                                                                                                                                                                                                                    {{ $lamaran->status == 'diterima' ? 'bg-emerald-100 text-emerald-700' :
                                    ($lamaran->status == 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                                                    {{ $lamaran->status ?? 'Review' }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-slate-500">Belum ada lamaran.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Certificates -->
            <div class="space-y-8">
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-lg">Sertifikat Saya</h3>
                        <a href="{{ route('talent.certificates') }}"
                            class="text-primary text-xs font-black hover:underline">Kelola</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recent_sertifikat as $sertifikat)
                            <div
                                class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 group hover:shadow-md transition-all">
                                <div
                                    class="size-12 rounded-lg bg-white dark:bg-slate-700 flex items-center justify-center shadow-sm border border-slate-200 dark:border-slate-600 text-amber-500">
                                    <span class="material-symbols-outlined text-2xl">workspace_premium</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate">
                                        {{ $sertifikat->judul_sertifikat }}
                                    </h4>
                                    <p class="text-[10px] text-slate-500 truncate">{{ $sertifikat->penerbit }}</p>
                                    <div class="flex items-center gap-1 mt-1">
                                        <span class="material-symbols-outlined text-[12px] text-emerald-500">verified</span>
                                        <span class="text-[9px] font-black text-emerald-600 uppercase">Verified</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6">
                                <span class="material-symbols-outlined text-slate-300 text-4xl mb-2">school</span>
                                <p class="text-slate-500 text-xs">Belum ada sertifikat.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Job Fair CTA -->
                <!-- Job Fair CTA -->
                <div x-data="{ registered: false }"
                    class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-8 text-white relative overflow-hidden">
                    <div class="absolute -top-12 -right-12 size-32 bg-primary/20 rounded-full blur-3xl"></div>
                    <div class="absolute top-4 right-4 animate-pulse">
                        <span
                            class="px-2 py-0.5 bg-amber-500 text-[8px] font-black rounded-full text-white uppercase tracking-tighter">Coming
                            Soon</span>
                    </div>
                    <h4 class="text-lg font-black mb-2 relative z-10 uppercase tracking-tighter">Job Fair 2025</h4>
                    <p class="text-xs text-slate-400 mb-6 leading-relaxed relative z-10">Persiapkan diri Anda untuk acara
                        karir terbesar tahun depan. Pendaftaran akan segera dibuka!</p>

                    <template x-if="!registered">
                        <button @click="registered = true"
                            class="w-full justify-center py-3 bg-primary rounded-xl font-black text-sm hover:scale-105 active:scale-95 transition-all relative z-10">Daftar
                            Sekarang</button>
                    </template>

                    <div x-show="registered" x-transition
                        class="p-4 bg-amber-500/10 border border-amber-500/20 rounded-xl relative z-10">
                        <p class="text-[10px] text-amber-400 font-bold leading-tight">
                            Pendaftaran Belum Dibuka!<br>
                            Silakan pantau berkala untuk informasi jadwal terbaru.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(count($skills_data) >= 3)
                const ctx = document.getElementById('skillRadarChart').getContext('2d');
                const isDark = document.documentElement.classList.contains('dark');

                new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: {!! json_encode(collect($skills_data)->map(fn($s) => optional($s->kategori)->nama_kategori)->toArray()) !!},
                        datasets: [{
                            label: 'Skor Skill',
                            data: {!! json_encode(collect($skills_data)->pluck('skor')->toArray()) !!},
                            backgroundColor: 'rgba(19, 127, 236, 0.2)',
                            borderColor: '#137fec',
                            borderWidth: 3,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#137fec',
                            pointHoverRadius: 5,
                            fill: true,
                            tension: 0.1
                        }]
                    },
                    options: {
                        scales: {
                            r: {
                                grid: { color: isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.05)' },
                                angleLines: { color: isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.05)' },
                                pointLabels: {
                                    color: isDark ? '#94a3b8' : '#475569',
                                    font: { family: 'Inter', weight: 'bold' }
                                },
                                ticks: { display: false },
                                min: 0,
                                max: 100
                            }
                        },
                        plugins: {
                            legend: { display: false }
                        },
                        maintainAspectRatio: false
                    }
                });
            @endif
                                    });
    </script>
@endsection