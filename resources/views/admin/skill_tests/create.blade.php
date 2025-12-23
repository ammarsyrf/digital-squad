@extends('layouts.dashboard')

@section('title', 'Tambah Soal Tes Skill - Digital Skill Passport')

@section('sidebar')
    @include('layouts.partials.sidebar-admin')
@endsection

@section('content')
    <div class="max-w-7xl mx-auto w-full">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary">
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-slate-400 text-sm mx-1">chevron_right</span>
                        <a href="{{ route('admin.skill-tests') }}"
                            class="ml-1 text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary md:ml-2">Bank
                            Soal</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-slate-400 text-sm mx-1">chevron_right</span>
                        <span class="ml-1 text-sm font-medium text-slate-900 dark:text-white md:ml-2">Tambah Soal</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Tambah Soal Skill</h2>
            <p class="mt-2 text-slate-600 dark:text-slate-400">Buat pertanyaan baru untuk tes kompetensi.</p>
        </div>

        <!-- Form -->
        <div
            class="bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-xl shadow-sm p-6">
            <form action="{{ route('admin.skill-tests.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <!-- Kategori & Kesulitan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="kategori_id"
                                class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kategori
                                Skill</label>
                            <select name="kategori_id" id="kategori_id" required
                                class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('kategori_id') == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="kesulitan"
                                class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tingkat
                                Kesulitan</label>
                            <select name="kesulitan" id="kesulitan" required
                                class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                <option value="mudah" {{ old('kesulitan') == 'mudah' ? 'selected' : '' }}>Mudah</option>
                                <option value="sedang" {{ old('kesulitan') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="sulit" {{ old('kesulitan') == 'sulit' ? 'selected' : '' }}>Sulit</option>
                            </select>
                            @error('kesulitan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Pertanyaan -->
                    <div>
                        <label for="pertanyaan"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Pertanyaan</label>
                        <textarea name="pertanyaan" id="pertanyaan" rows="3" required
                            class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">{{ old('pertanyaan') }}</textarea>
                        @error('pertanyaan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Opsi Jawaban -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="opsi_a"
                                class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Opsi A</label>
                            <input type="text" name="opsi_a" id="opsi_a" value="{{ old('opsi_a') }}" required
                                class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                        </div>
                        <div>
                            <label for="opsi_b"
                                class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Opsi B</label>
                            <input type="text" name="opsi_b" id="opsi_b" value="{{ old('opsi_b') }}" required
                                class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                        </div>
                        <div>
                            <label for="opsi_c"
                                class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Opsi C</label>
                            <input type="text" name="opsi_c" id="opsi_c" value="{{ old('opsi_c') }}" required
                                class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                        </div>
                        <div>
                            <label for="opsi_d"
                                class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Opsi D</label>
                            <input type="text" name="opsi_d" id="opsi_d" value="{{ old('opsi_d') }}" required
                                class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                        </div>
                    </div>

                    <!-- Jawaban Benar & Status -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="jawaban_benar"
                                class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kunci
                                Jawaban</label>
                            <select name="jawaban_benar" id="jawaban_benar" required
                                class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                <option value="A" {{ old('jawaban_benar') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('jawaban_benar') == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ old('jawaban_benar') == 'C' ? 'selected' : '' }}>C</option>
                                <option value="D" {{ old('jawaban_benar') == 'D' ? 'selected' : '' }}>D</option>
                            </select>
                            @error('jawaban_benar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="status"
                                class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Status
                                Soal</label>
                            <select name="status" id="status" required
                                class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif
                                </option>
                            </select>
                            @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('admin.skill-tests') }}"
                            class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-600 dark:hover:bg-slate-700">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-dark focus:ring-4 focus:ring-primary/20">
                            Simpan Soal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection