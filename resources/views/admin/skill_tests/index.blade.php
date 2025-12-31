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
            <div class="p-4 rounded-lg bg-green-100 text-green-700 border border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800" role="alert">
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

                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                            <th class="px-6 py-4 w-4">
                                <input type="checkbox" id="select-all" class="rounded border-slate-300 text-primary focus:ring-primary w-4 h-4">
                            </th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Pertanyaan</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Kategori</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Tipe</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Status</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($tests as $test)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="ids[]" value="{{ $test->id }}" class="bulk-item rounded border-slate-300 text-primary focus:ring-primary w-4 h-4">
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-slate-900 dark:text-white line-clamp-1" title="{{ $test->pertanyaan }}">{{ Str::limit($test->pertanyaan, 80) }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                    {{ $test->kategori->nama_kategori }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                    {{ ucwords(str_replace('_', ' ', $test->tipe_soal)) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                    @if($test->status == 'aktif')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Aktif</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.skill-tests.edit', $test->id) }}" class="text-slate-400 hover:text-primary transition-colors">
                                            <span class="material-symbols-outlined">edit</span>
                                        </a>
                                        {{-- Delete Button (separate form to avoid conflict with bulk form) --}}
                                        <button type="button" onclick="confirmDelete('{{ route('admin.skill-tests.delete', $test->id) }}')" class="text-slate-400 hover:text-red-600 transition-colors">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                    Belum ada soal yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>
            <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                {{ $tests->links() }}
            </div>
        </div>

        {{-- Hidden Delete Form to be submitted via JS --}}
        <form id="delete-form" action="" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        <script>
            // Select All Logic
            document.getElementById('select-all').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.bulk-item');
                checkboxes.forEach(cb => cb.checked = this.checked);
            });

            // Delete Confirmation Logic for individual items inside bulk form (to prevent nested forms)
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
