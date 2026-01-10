@extends('layouts.dashboard')

@section('title', 'Manajemen Tes Skill - Digital Skill Passport')

@section('header_title', 'Manajemen Tes Skill')

@section('sidebar')
    @include('layouts.partials.sidebar-admin')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold">Bank Soal Tes Skill</h2>
                <p class="text-slate-500">Kelola kategori dan butir soal tes kemampuan talenta.</p>
            </div>
            <a href="{{ route('admin.skill-tests.create') }}"
                class="px-6 py-3 bg-primary text-white rounded-xl font-bold shadow-lg shadow-primary/30 flex items-center gap-2 hover:bg-primary-dark transition-colors">
                <span class="material-symbols-outlined">add</span>
                Tambah Soal
            </a>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6 no-print">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-indigo-100 dark:border-indigo-900/30 shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-6xl text-indigo-600">quiz</span>
                </div>
                <div class="flex items-center justify-between mb-4 relative z-10">
                    <h3 class="text-sm font-bold text-indigo-900 dark:text-indigo-100 uppercase tracking-wider">Total Soal</h3>
                    <div class="p-2 bg-indigo-50 dark:bg-indigo-900/50 rounded-lg">
                        <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400">quiz</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 relative z-10">
                    <span class="text-3xl font-black text-slate-900 dark:text-white">{{ number_format($totalSoal) }}</span>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-pink-100 dark:border-pink-900/30 shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-6xl text-pink-600">category</span>
                </div>
                <div class="flex items-center justify-between mb-4 relative z-10">
                    <h3 class="text-sm font-bold text-pink-900 dark:text-pink-100 uppercase tracking-wider">Kategori</h3>
                    <div class="p-2 bg-pink-50 dark:bg-pink-900/50 rounded-lg">
                        <span class="material-symbols-outlined text-pink-600 dark:text-pink-400">category</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 relative z-10">
                    <span class="text-3xl font-black text-slate-900 dark:text-white">{{ number_format($totalKategori) }}</span>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-teal-100 dark:border-teal-900/30 shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-6xl text-teal-600">check_circle</span>
                </div>
                <div class="flex items-center justify-between mb-4 relative z-10">
                    <h3 class="text-sm font-bold text-teal-900 dark:text-teal-100 uppercase tracking-wider">Soal Aktif</h3>
                    <div class="p-2 bg-teal-50 dark:bg-teal-900/50 rounded-lg">
                        <span class="material-symbols-outlined text-teal-600 dark:text-teal-400">check_circle</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 relative z-10">
                    <span class="text-3xl font-black text-slate-900 dark:text-white">{{ number_format($activeSoal) }}</span>
                    <span class="text-sm font-medium text-teal-600 dark:text-teal-400">Ready</span>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition.duration.500ms class="p-4 rounded-lg bg-green-100 text-green-700 border border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800" role="alert">
                <span class="font-medium">Sukses!</span> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <form action="{{ route('admin.skill-tests.bulk-status') }}" method="POST" id="bulk-form">
                @csrf
                <!-- Bulk Actions Toolbar -->
                <div class="p-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <select name="status" class="rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-sm focus:ring-primary focus:border-primary">
                            <option value="" disabled selected>Pilih Aksi Massal</option>
                            <option value="aktif">Set Status: Aktif</option>
                            <option value="nonaktif">Set Status: Non-Aktif</option>
                        </select>
                        <button type="submit" class="px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-600 dark:hover:bg-slate-700 transition-colors">
                            Terapkan
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Kategori & Soal</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 text-right">Jumlah Soal</th>
                            </tr>
                        </thead>
                        @forelse($categories as $category)
                            <tbody x-data="{ expanded: false }" class="border-b border-slate-100 dark:border-slate-800">
                                <!-- Category Row -->
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors cursor-pointer group" @click="expanded = !expanded">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 bg-slate-100 dark:bg-slate-800 rounded-lg text-slate-500 group-hover:text-primary transition-colors">
                                                <span class="material-symbols-outlined transition-transform duration-300" :class="expanded ? 'rotate-180' : ''">expand_more</span>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-900 dark:text-white text-base">{{ $category->nama_kategori }}</h4>
                                                <p class="text-xs text-primary font-bold mt-1" x-show="expanded" x-transition>Menampilkan daftar soal</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                            {{ $category->soal_count }} Soal
                                        </span>
                                    </td>
                                </tr>
                                
                                <!-- Internal Questions Row -->
                                <tr x-show="expanded" x-collapse style="display: none;">
                                    <td colspan="2" class="p-0 bg-slate-50/50 dark:bg-slate-800/20 shadow-inner">
                                        <div class="px-4 py-4 sm:px-14">
                                            <table class="w-full text-left">
                                                <thead>
                                                    <tr class="border-b border-slate-200 dark:border-slate-700">
                                                        <th class="px-4 py-3 w-4">
                                                            <input type="checkbox" @change="$el.closest('tbody').querySelectorAll('.bulk-item').forEach(c => c.checked = $el.checked)" class="rounded border-slate-300 text-primary focus:ring-primary w-4 h-4">
                                                        </th>
                                                        <th class="px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-slate-500">Pertanyaan</th>
                                                        <th class="px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-slate-500">Tipe</th>
                                                        <th class="px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-slate-500">Kesulitan</th>
                                                        <th class="px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-slate-500">Status</th>
                                                        <th class="px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-slate-500 text-right">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                                                    @forelse($category->soal as $soal)
                                                        <tr class="hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                                            <td class="px-4 py-3">
                                                                <input type="checkbox" name="ids[]" value="{{ $soal->id_soal_skill }}" class="bulk-item rounded border-slate-300 text-primary focus:ring-primary w-4 h-4">
                                                            </td>
                                                            <td class="px-4 py-3">
                                                                <p class="text-sm font-medium text-slate-900 dark:text-white line-clamp-2" title="{{ $soal->pertanyaan }}">{{ $soal->pertanyaan }}</p>
                                                            </td>
                                                            <td class="px-4 py-3 text-xs text-slate-500">
                                                                {{ ucwords(str_replace('_', ' ', $soal->tipe_soal)) }}
                                                            </td>
                                                            <td class="px-4 py-3">
                                                                @php
                                                                    $badgeClass = match($soal->kesulitan) {
                                                                        'mudah' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                                                        'sedang' => 'bg-amber-100 text-amber-700 border-amber-200',
                                                                        'sulit' => 'bg-rose-100 text-rose-700 border-rose-200',
                                                                        default => 'bg-slate-100 text-slate-700 border-slate-200'
                                                                    };
                                                                @endphp
                                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase border {{ $badgeClass }}">
                                                                    {{ $soal->kesulitan }}
                                                                </span>
                                                            </td>
                                                            <td class="px-4 py-3">
                                                                @if($soal->status == 'aktif')
                                                                    <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-600">
                                                                        <div class="size-1.5 rounded-full bg-emerald-500"></div>
                                                                        Aktif
                                                                    </div>
                                                                @else
                                                                    <div class="flex items-center gap-1.5 text-xs font-bold text-slate-400">
                                                                        <div class="size-1.5 rounded-full bg-slate-400"></div>
                                                                        Non-Aktif
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td class="px-4 py-3 text-right">
                                                                <div class="flex items-center justify-end gap-2">
                                                                    <a href="{{ route('admin.skill-tests.edit', $soal->id_soal_skill) }}" class="p-1 rounded hover:bg-slate-200 text-slate-400 hover:text-primary transition-colors">
                                                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                                                    </a>
                                                                    <button type="button" onclick="confirmDelete('{{ route('admin.skill-tests.delete', $soal->id_soal_skill) }}')" class="p-1 rounded hover:bg-slate-200 text-slate-400 hover:text-red-600 transition-colors">
                                                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="px-4 py-6 text-center text-slate-500 italic">
                                                                <div class="flex flex-col items-center">
                                                                    <span class="material-symbols-outlined text-silver-300 text-3xl mb-1">sentiment_dissatisfied</span>
                                                                    <span class="text-xs">Belum ada soal di kategori ini.</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        @empty
                            <tbody>
                                <tr>
                                    <td colspan="2" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-full mb-3">
                                                <span class="material-symbols-outlined text-4xl text-slate-400">search_off</span>
                                            </div>
                                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Tidak Ada Data</h3>
                                            <p class="text-sm">Belum ada kategori soal yang ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        @endforelse
                    </table>
                </div>
            </form>
            <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                {{ $categories->links() }}
            </div>
        </div>

        {{-- Hidden Delete Form to be submitted via JS --}}
        <form id="delete-form" action="" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        <script>
            // Delete Confirmation Logic
            function confirmDelete(url) {
                if (confirm('Hapus soal ini?')) {
                    const form = document.getElementById('delete-form');
                    form.action = url;
                    form.submit();
                }
            }
        </script>
    </div>
@endsection
