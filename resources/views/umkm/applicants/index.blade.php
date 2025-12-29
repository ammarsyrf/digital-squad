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
                            <td class="px-6 py-4 text-right" x-data="{ open: false, showDetailModal: false, showInterviewModal: false }">
                                <div class="flex justify-end">
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
                                            class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl z-30 overflow-hidden"
                                            style="display: none;">
                                            <div class="py-2">
                                                <div
                                                    class="px-4 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                                    Navigasi</div>
                                                <button @click="showDetailModal = true; open = false"
                                                    class="w-full flex items-center gap-3 px-4 py-2 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors text-sm font-medium text-slate-700 dark:text-slate-300">
                                                    <span class="material-symbols-outlined text-primary text-[20px]">visibility</span>
                                                    Lihat Detail & CV
                                                </button>
                                                <a href="{{ route('messages.show', $app->talent->user_id) }}"
                                                    class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors text-sm font-medium text-slate-700 dark:text-slate-300">
                                                    <span class="material-symbols-outlined text-primary text-[20px]">chat</span>
                                                    Kirim Pesan
                                                </a>

                                                <div class="h-px bg-slate-100 dark:bg-slate-700 my-2"></div>
                                                <div
                                                    class="px-4 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                                    Aksi Status</div>

                                                <button @click="showInterviewModal = true; open = false"
                                                    class="w-full flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors text-sm font-medium text-blue-600">
                                                    <span class="material-symbols-outlined text-[20px]">event_note</span>
                                                    Jadwalkan Wawancara
                                                </button>

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

                                <!-- Detail Modal -->
                                <div x-show="showDetailModal" ...>
                                    <!-- (Existing Detail Modal Content - truncated for brevity in instruction but I will keep it in reality, wait, replace_file_content replaces the whole block. I need to be careful not to delete the existing modal. I will reuse the previous block and append the new modal.) -->
                                </div>

                                <!-- Detail Modal -->
                                <div x-show="showDetailModal"
                                    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm text-left"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    style="display: none;" x-cloak>
                                    
                                    <div @click.away="showDetailModal = false"
                                        class="bg-white dark:bg-slate-900 rounded-[32px] w-full max-w-4xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                                        
                                        <!-- Header -->
                                        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-white/80 dark:bg-slate-900/80 backdrop-blur-md z-10">
                                            <div>
                                                <h3 class="text-xl font-black text-slate-900 dark:text-white">Detail Pelamar</h3>
                                                <p class="text-slate-500 text-sm">Review data lengkap dan CV pelamar.</p>
                                            </div>
                                            <button @click="showDetailModal = false" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                                                <span class="material-symbols-outlined">close</span>
                                            </button>
                                        </div>

                                        <div class="flex-1 overflow-y-auto p-6 md:p-8 space-y-8">
                                            <!-- Profile Summary -->
                                            <div class="flex gap-6 items-start">
                                                <div class="size-20 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0">
                                                    <span class="material-symbols-outlined text-4xl text-slate-400">person</span>
                                                </div>
                                                <div class="space-y-1">
                                                    <h4 class="text-2xl font-black text-slate-900 dark:text-white">{{ $app->talent->nama_lengkap }}</h4>
                                                    <p class="text-slate-500 dark:text-slate-400">{{ $app->talent->pekerjaan_saat_ini ?? 'Tidak ada judul' }}</p>
                                                    <div class="flex flex-wrap gap-4 mt-2 text-sm text-slate-600 dark:text-slate-400">
                                                        <div class="flex items-center gap-1.5">
                                                            <span class="material-symbols-outlined text-lg text-primary">email</span>
                                                            {{ $app->talent->user->email }}
                                                        </div>
                                                        <div class="flex items-center gap-1.5">
                                                            <span class="material-symbols-outlined text-lg text-primary">call</span>
                                                            {{ $app->talent->telepon ?? '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Cover Letter -->
                                            <div>
                                                <h5 class="font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-primary">description</span>
                                                    Cover Letter
                                                </h5>
                                                <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-2xl text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line text-sm">
                                                    {{ $app->cover_letter }}
                                                </div>
                                            </div>

                                            <!-- CV Viewer -->
                                            <div>
                                                <div class="flex items-center justify-between mb-3">
                                                    <h5 class="font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                                        <span class="material-symbols-outlined text-primary">picture_as_pdf</span>
                                                        CV / Resume
                                                    </h5>
                                                    @if($app->cv_path)
                                                        <a href="{{ asset('storage/' . $app->cv_path) }}" target="_blank" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                                                            Buka di Tab Baru <span class="material-symbols-outlined text-sm">open_in_new</span>
                                                        </a>
                                                    @endif
                                                </div>
                                                
                                                @if($app->cv_path)
                                                    <div class="bg-slate-100 dark:bg-slate-800 rounded-2xl overflow-hidden h-[500px] border border-slate-200 dark:border-slate-700">
                                                        <iframe src="{{ asset('storage/' . $app->cv_path) }}" class="w-full h-full" frameborder="0"></iframe>
                                                    </div>
                                                @else
                                                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl h-32 flex flex-col items-center justify-center text-slate-400 border-2 border-dashed border-slate-200 dark:border-slate-700">
                                                        <span class="material-symbols-outlined text-3xl mb-1">sentiment_dissatisfied</span>
                                                        <p class="text-sm font-bold">Pelamar tidak menyertakan CV</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Interview Modal -->
                                <div x-show="showInterviewModal"
                                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm text-left"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     style="display: none;" x-cloak>
                                    
                                    <div @click.away="showInterviewModal = false"
                                        class="bg-white dark:bg-slate-900 rounded-[32px] w-full max-w-lg shadow-2xl flex flex-col"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                                        
                                        <!-- Header -->
                                        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-white/80 dark:bg-slate-900/80 backdrop-blur-md z-10 rounded-t-[32px]">
                                            <div>
                                                <h3 class="text-xl font-black text-slate-900 dark:text-white">Jadwalkan Wawancara</h3>
                                                <p class="text-slate-500 text-sm">Pelamar: <span class="font-bold text-primary">{{ $app->talent->nama_lengkap }}</span></p>
                                            </div>
                                            <button @click="showInterviewModal = false" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                                                <span class="material-symbols-outlined">close</span>
                                            </button>
                                        </div>

                                        <!-- Form -->
                                        <form action="{{ route('umkm.applicants.schedule', $app->id) }}" method="POST" class="p-6 md:p-8 space-y-6">
                                            @csrf
                                            
                                            <div class="grid grid-cols-2 gap-6">
                                                <div class="space-y-2">
                                                    <label class="text-xs font-bold uppercase text-slate-500">Tanggal</label>
                                                    <input type="date" name="tanggal" required min="{{ date('Y-m-d') }}"
                                                        class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl font-bold text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-primary">
                                                </div>
                                                <div class="space-y-2">
                                                    <label class="text-xs font-bold uppercase text-slate-500">Jam</label>
                                                    <input type="time" name="jam" required
                                                        class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl font-bold text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-primary">
                                                </div>
                                            </div>

                                            <div class="space-y-2">
                                                <label class="text-xs font-bold uppercase text-slate-500">Lokasi / Link Meeting</label>
                                                <input type="text" name="lokasi" required placeholder="Contoh: Kantor Pusat Lt. 2 / Google Meet Link"
                                                    class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl font-bold text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-primary">
                                            </div>

                                            <div class="space-y-2">
                                                <label class="text-xs font-bold uppercase text-slate-500">Catatan / Deskripsi</label>
                                                <textarea name="deskripsi" rows="3" required placeholder="Bawa CV fisik dan berpakaian rapi..."
                                                    class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl font-medium text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-primary"></textarea>
                                            </div>

                                            <div class="pt-2 flex justify-end gap-3">
                                                <button type="button" @click="showInterviewModal = false"
                                                    class="px-6 py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-200 transition-colors">
                                                    Batal
                                                </button>
                                                <button type="submit"
                                                    class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/30 flex items-center gap-2">
                                                    <span class="material-symbols-outlined">send</span>
                                                    Kirim Undangan
                                                </button>
                                            </div>
                                        </form>
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