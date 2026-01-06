@extends('layouts.dashboard')

@section('title', 'Riwayat Lamaran - Digital Skill Passport')

@section('header_title', 'Riwayat Lamaran')

@section('sidebar')
    @include('layouts.partials.sidebar-talent')
@endsection

@section('content')
    <div class="space-y-6">
        <div>
            <h2 class="text-2xl font-bold">Status Lamaran</h2>
            <p class="text-slate-500">Pantau perkembangan lamaran kerja yang telah Anda kirimkan.</p>
        </div>

        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Pekerjaan</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Instansi</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 text-center">Status
                        </th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 text-right">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($applications as $app)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-900 dark:text-white">{{ $app->lowongan->judul }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="text-sm text-slate-600 dark:text-slate-400">{{ $app->lowongan?->umkm?->nama_umkm ?? 'Instansi' }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ $app->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    @php
                                        $statusClasses = [
                                            'Pending' => 'bg-amber-100 text-amber-700',
                                            'Diterima' => 'bg-emerald-100 text-emerald-700',
                                            'Ditolak' => 'bg-red-100 text-red-700',
                                            'Interview' => 'bg-blue-100 text-blue-700',
                                        ];
                                        $class = $statusClasses[$app->status] ?? 'bg-slate-100 text-slate-700';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $class }}">
                                        {{ $app->status }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('talent.jobs.show', $app->lowongan->id_lowongan) }}"
                                    class="text-primary hover:underline text-sm font-bold">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <span class="material-symbols-outlined text-4xl opacity-10 mb-2">history</span>
                                <p class="text-slate-500">Belum ada riwayat lamaran.</p>
                                <a href="{{ route('talent.jobs') }}"
                                    class="text-primary font-bold hover:underline mt-2 inline-block text-sm">Cari pekerjaan
                                    sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection