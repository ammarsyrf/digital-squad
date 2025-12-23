@extends('layouts.dashboard')

@section('title', 'Daftar Pelamar - Digital Skill Passport')

@section('header_title', 'Lihat Pelamar')

@section('sidebar')
    @include('layouts.partials.sidebar-umkm')
@endsection

@section('content')
    <div class="space-y-6">
        <div>
            <h2 class="text-2xl font-bold">Manajemen Pelamar</h2>
            <p class="text-slate-500">Tinjau profil talenta yang melamar ke lowongan Anda.</p>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Pelamar</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Posisi</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 text-center">Status
                        </th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 text-right">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($applicants as $app)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined">person</span>
                                    </div>
                                    <div>
                                        <span
                                            class="font-bold text-slate-900 dark:text-white block">{{ $app->talent->nama_lengkap }}</span>
                                        <span
                                            class="text-[10px] text-slate-500 uppercase font-bold">{{ $app->talent->pekerjaan_saat_ini ?? 'Pelamar' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ $app->lowongan->judul }}</span>
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
                                <div class="flex justify-end" x-data="{ open: false }">
                                    <div class="relative">
                                        <button @click="open = !open" @click.away="open = false"
                                            class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors text-slate-400 group">
                                            <span
                                                class="material-symbols-outlined group-hover:text-primary transition-colors">more_vert</span>
                                        </button>

                                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl z-50 overflow-hidden"
                                            style="display: none;">
                                            <div class="py-2">
                                                <div
                                                    class="px-4 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                                    Navigasi</div>
                                                <a href="{{ route('messages.show', $app->talent->user_id) }}"
                                                    class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors text-sm font-medium text-slate-700 dark:text-slate-300">
                                                    <span class="material-symbols-outlined text-primary text-[20px]">chat</span>
                                                    Kirim Pesan
                                                </a>

                                                <div class="h-px bg-slate-100 dark:bg-slate-700 my-2"></div>
                                                <div
                                                    class="px-4 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                                    Aksi Status</div>

                                                <form action="{{ route('umkm.applicants.status', $app->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Interview">
                                                    <button type="submit"
                                                        class="w-full flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors text-sm font-medium text-blue-600">
                                                        <span class="material-symbols-outlined text-[20px]">event_note</span>
                                                        Jadwalkan Wawancara
                                                    </button>
                                                </form>

                                                <form action="{{ route('umkm.applicants.status', $app->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Diterima">
                                                    <button type="submit"
                                                        class="w-full flex items-center gap-3 px-4 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors text-sm font-medium text-emerald-600">
                                                        <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                                        Terima Pelamar
                                                    </button>
                                                </form>

                                                <form action="{{ route('umkm.applicants.status', $app->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Ditolak">
                                                    <button type="submit"
                                                        class="w-full flex items-center gap-3 px-4 py-2 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors text-sm font-medium text-red-600">
                                                        <span class="material-symbols-outlined text-[20px]">cancel</span>
                                                        Tolak Pelamar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <span class="material-symbols-outlined text-4xl opacity-10 mb-2">group_off</span>
                                <p class="text-slate-500 font-medium">Belum ada pelamar saat ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection