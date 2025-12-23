@extends('layouts.dashboard')

@section('title', 'Kategori Skill - Digital Skill Passport')

@section('sidebar')
    @include('layouts.partials.sidebar-admin')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold dark:text-white">Kategori Skill</h2>
                <p class="text-slate-500 dark:text-slate-400">Kelola kategori untuk pengelompokan soal tes.</p>
            </div>
            <a href="{{ route('admin.skill-categories.create') }}"
                class="px-6 py-3 bg-primary text-white rounded-xl font-bold shadow-lg shadow-primary/30 flex items-center gap-2 hover:bg-primary-dark transition-colors">
                <span class="material-symbols-outlined">add</span>
                Tambah Kategori
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-lg bg-green-100 text-green-700 border border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800"
                role="alert">
                <span class="font-medium">Sukses!</span> {{ session('success') }}
            </div>
        @endif

        <!-- Search Form -->
        <form action="{{ route('admin.skill-categories') }}" method="GET" class="relative">
            <label for="search" class="sr-only">Cari Kategori</label>
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-slate-400">search</span>
            </div>
            <input type="text" name="q" id="search" value="{{ request('q') }}"
                class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 dark:border-slate-700 rounded-lg leading-5 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary sm:text-sm shadow-sm"
                placeholder="Cari nama kategori..." autocomplete="off">
        </form>

        <div
            class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th
                            class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Nama Kategori</th>
                        <th
                            class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Jumlah Soal</th>
                        <th
                            class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 text-right">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">
                                {{ $category->nama_kategori }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                {{ $category->soal->count() }} Soal
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.skill-categories.edit', $category->id) }}"
                                        class="text-slate-400 hover:text-primary transition-colors" title="Edit">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <form action="{{ route('admin.skill-categories.delete', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus kategori ini? Kategori yang memiliki soal mungkin akan menyebabkan error tampilan jika tidak ditangani.');"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors"
                                            title="Hapus">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                Belum ada kategori yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection