@extends('layouts.dashboard')

@section('title', 'Beranda UMKM - Digital Skill Passport')

@section('header_title', 'Beranda UMKM')

@section('sidebar')
    @include('layouts.partials.sidebar-umkm')
@endsection

@section('content')
    <div class="space-y-8 pb-12">
        <!-- Page Heading -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Selamat Datang,
                    {{ $umkm->nama_umkm ?? 'UMKM / Instansi' }}
                </h2>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Berikut adalah ringkasan aktivitas rekrutmen dan status
                    akun Anda hari ini.</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('umkm.applicants') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 font-bold text-sm hover:bg-slate-50 dark:hover:bg-slate-700 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 group">
                    <span
                        class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">person_search</span>
                    Cari Talenta
                </a>
                <a href="{{ route('umkm.jobs.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-white font-bold text-sm hover:bg-blue-600 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-blue-500/25 transition-all duration-300 group">
                    <span
                        class="material-symbols-outlined text-[20px] group-hover:rotate-90 transition-transform">add</span>
                    Pasang Lowongan
                </a>
            </div>
        </div>

        <!-- Verification Banner -->
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden flex flex-col md:flex-row">
            <div class="p-8 flex-1 flex flex-col justify-center gap-4">
                <div class="flex items-center gap-3">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">
                        <span class="material-symbols-outlined text-sm font-bold">check</span>
                    </span>
                    <span
                        class="text-emerald-700 dark:text-emerald-400 font-black text-[10px] bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded border border-emerald-200 dark:border-emerald-800 uppercase tracking-widest">TERVERIFIKASI</span>
                    <span class="h-4 w-[1px] bg-slate-300 dark:bg-slate-700"></span>
                    <div class="flex items-center gap-1.5 text-slate-500 dark:text-slate-400 text-xs font-bold">
                        <span class="material-symbols-outlined text-[16px]">location_on</span>
                        {{ $umkm->alamat ?? 'Indonesia' }}
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Akun Instansi Anda Aktif</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed max-w-xl">
                        Akses penuh diberikan. Anda dapat mengelola lowongan pekerjaan tanpa batas dan menjangkau ribuan talenta digital berbakat di platform kami.
                    </p>
                </div>
            </div>
            <div class="h-40 md:h-auto md:w-1/3 bg-slate-50 dark:bg-slate-800/50 relative overflow-hidden group">
                <div class="absolute inset-0 opacity-20 group-hover:opacity-30 transition-opacity"
                    style="background-image: radial-gradient(#137fec 1px, transparent 1px); background-size: 20px 20px;">
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div
                        class="h-20 w-20 bg-white dark:bg-slate-900 rounded-full shadow-2xl flex items-center justify-center text-primary z-10 transform group-hover:scale-110 transition-transform duration-500">
                        <span class="material-symbols-outlined text-4xl fill">verified_user</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                class="group bg-gradient-to-br from-blue-500 to-primary p-6 rounded-2xl shadow-lg shadow-blue-500/10 flex flex-col justify-between text-white border-none transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-start justify-between mb-8">
                    <div class="h-10 w-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30">
                        <span class="material-symbols-outlined">campaign</span>
                    </div>
                </div>
                <div>
                    <p class="text-blue-100 text-xs font-black uppercase tracking-widest">Lowongan Aktif</p>
                    <h3 class="text-4xl font-black mt-1">{{ $stats['total_lowongan'] }}</h3>
                </div>
            </div>
            <div
                class="group bg-gradient-to-br from-indigo-500 to-purple-600 p-6 rounded-2xl shadow-lg shadow-purple-500/10 flex flex-col justify-between text-white border-none transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-start justify-between mb-8">
                    <div class="h-10 w-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30">
                        <span class="material-symbols-outlined">group</span>
                    </div>
                </div>
                <div>
                    <p class="text-indigo-100 text-xs font-black uppercase tracking-widest">Total Pelamar</p>
                    <h3 class="text-4xl font-black mt-1">{{ $stats['total_pelamar'] }}</h3>
                </div>
            </div>
            <div
                class="group bg-gradient-to-br from-orange-400 to-rose-500 p-6 rounded-2xl shadow-lg shadow-orange-500/10 flex flex-col justify-between text-white border-none transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-start justify-between mb-8">
                    <div class="h-10 w-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                </div>
                <div>
                    <p class="text-orange-100 text-xs font-black uppercase tracking-widest">Review</p>
                    <h3 class="text-4xl font-black mt-1">{{ $stats['total_review'] }}</h3>
                </div>
            </div>
            <div
                class="group bg-gradient-to-br from-emerald-500 to-teal-600 p-6 rounded-2xl shadow-lg shadow-emerald-500/10 flex flex-col justify-between text-white border-none transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-start justify-between mb-8">
                    <div class="h-10 w-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30">
                        <span class="material-symbols-outlined">how_to_reg</span>
                    </div>
                </div>
                <div>
                    <p class="text-emerald-100 text-xs font-black uppercase tracking-widest">Wawancara</p>
                    <h3 class="text-4xl font-black mt-1">{{ $stats['total_wawancara'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Jobs & Pipeline -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Jobs -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Postingan Terbaru</h3>
                    <a href="{{ route('umkm.jobs') }}" class="text-primary text-xs font-bold hover:underline">Kelola Semua</a>
                </div>
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 font-bold border-b border-slate-100 dark:border-slate-800">
                                <tr>
                                    <th class="px-6 py-4">Posisi</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Pelamar</th>
                                    <th class="px-6 py-4">Dibuat</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                                @forelse($recent_lowongan as $job)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-slate-900 dark:text-white">{{ $job->judul }}</p>
                                            <p class="text-[10px] text-slate-500 uppercase font-bold">{{ $job->tipe_pekerjaan }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase
                                                {{ $job->status == 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                                <span class="h-1.5 w-1.5 rounded-full {{ $job->status == 'aktif' ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                                {{ $job->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <div class="flex -space-x-2">
                                                    @for($i=0; $i<min($job->lamaran_count, 3); $i++)
                                                        <div class="size-6 rounded-full border-2 border-white dark:border-slate-900 bg-slate-200 flex items-center justify-center text-[8px] font-bold overflow-hidden">
                                                            <span class="material-symbols-outlined text-[12px]">person</span>
                                                        </div>
                                                    @endfor
                                                </div>
                                                <span class="text-xs font-bold text-slate-600 dark:text-slate-400">{{ $job->lamaran_count }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-xs text-slate-400">
                                            {{ $job->created_at->format('d M Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">Belum ada postingan lowongan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pipeline -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Pipeline Rekrutmen</h3>
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-8 space-y-8">
                    @php
                        $max = max($stats['total_pelamar'], 1);
                        $pipeline = [
                            ['label' => 'Total Pelamar', 'val' => $stats['total_pelamar'], 'color' => 'bg-primary'],
                            ['label' => 'Menunggu Review', 'val' => $stats['total_review'], 'color' => 'bg-orange-400'],
                            ['label' => 'Wawancara', 'val' => $stats['total_wawancara'], 'color' => 'bg-indigo-500'],
                            ['label' => 'Diterima', 'val' => $stats['total_diterima'], 'color' => 'bg-emerald-500'],
                        ];
                    @endphp

                    @foreach($pipeline as $item)
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs font-bold uppercase tracking-widest">
                                <span class="text-slate-500">{{ $item['label'] }}</span>
                                <span class="text-slate-900 dark:text-white">{{ $item['val'] }}</span>
                            </div>
                            <div class="h-2.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                <div class="{{ $item['color'] }} h-full rounded-full transition-all duration-1000" style="width: {{ ($item['val'] / $max) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach

                    <div class="pt-6 border-t border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center flex-shrink-0 text-amber-600">
                                <span class="material-symbols-outlined">lightbulb</span>
                            </div>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed italic">
                                <b>Tips:</b> Segera proses lamaran yang masih berstatus "Review" untuk menjaga reputasi instansi Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
