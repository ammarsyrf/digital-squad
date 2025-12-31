@extends('layouts.dashboard')

@section('title', 'Edit Soal Tes Skill - Digital Skill Passport')

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
                        <span class="ml-1 text-sm font-medium text-slate-900 dark:text-white md:ml-2">Edit Soal</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Edit Soal Skill</h2>
            <p class="mt-2 text-slate-600 dark:text-slate-400">Perbarui data soal tes kompetensi.</p>
        </div>

        <!-- Form -->
        <div
            class="bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-xl shadow-sm p-6">
            <form action="{{ route('admin.skill-tests.update', $soal->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6" x-data="{ tipeSoal: '{{ old('tipe_soal', $soal->tipe_soal ?? 'pilihan_ganda') }}' }">
                    <!-- Kategori & Kesulitan -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="kategori_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kategori Skill</label>
                            <select name="kategori_id" id="kategori_id" required
                                class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('kategori_id', $soal->kategori_id) == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="kesulitan" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tingkat Kesulitan</label>
                            <select name="kesulitan" id="kesulitan" required
                                class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                <option value="mudah" {{ old('kesulitan', $soal->kesulitan) == 'mudah' ? 'selected' : '' }}>Mudah</option>
                                <option value="sedang" {{ old('kesulitan', $soal->kesulitan) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="sulit" {{ old('kesulitan', $soal->kesulitan) == 'sulit' ? 'selected' : '' }}>Sulit</option>
                            </select>
                            @error('kesulitan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="tipe_soal"
                                class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tipe Soal</label>
                            <select name="tipe_soal" id="tipe_soal" x-model="tipeSoal" required
                                class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                <option value="pilihan_ganda">Pilihan Ganda</option>
                                <option value="essay">Essay</option>
                            </select>
                        </div>
                    </div>

                    <!-- Pertanyaan -->
                    <div>
                        <label for="pertanyaan"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Pertanyaan</label>
                        <textarea name="pertanyaan" id="pertanyaan" rows="3" required
                            class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">{{ old('pertanyaan', $soal->pertanyaan) }}</textarea>
                        @error('pertanyaan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Opsi Jawaban (Pilihan Ganda) -->
                    <div x-show="tipeSoal === 'pilihan_ganda'" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="opsi_a" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Opsi A</label>
                                <input type="text" name="opsi_a" id="opsi_a" value="{{ old('opsi_a', $soal->opsi_a) }}" :required="tipeSoal === 'pilihan_ganda'"
                                    class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                            </div>
                            <div>
                                <label for="opsi_b" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Opsi B</label>
                                <input type="text" name="opsi_b" id="opsi_b" value="{{ old('opsi_b', $soal->opsi_b) }}" :required="tipeSoal === 'pilihan_ganda'"
                                    class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                            </div>
                            <div>
                                <label for="opsi_c" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Opsi C</label>
                                <input type="text" name="opsi_c" id="opsi_c" value="{{ old('opsi_c', $soal->opsi_c) }}" :required="tipeSoal === 'pilihan_ganda'"
                                    class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                            </div>
                            <div>
                                <label for="opsi_d" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Opsi D</label>
                                <input type="text" name="opsi_d" id="opsi_d" value="{{ old('opsi_d', $soal->opsi_d) }}" :required="tipeSoal === 'pilihan_ganda'"
                                    class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                            </div>
                        </div>

                         <!-- Jawaban Benar (PG) -->
                        <div>
                            <label for="jawaban_benar" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kunci Jawaban (Pilihan Ganda)</label>
                            <select name="jawaban_benar" id="jawaban_benar" :required="tipeSoal === 'pilihan_ganda'"
                                class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                <option value="A" {{ old('jawaban_benar', $soal->jawaban_benar) == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('jawaban_benar', $soal->jawaban_benar) == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ old('jawaban_benar', $soal->jawaban_benar) == 'C' ? 'selected' : '' }}>C</option>
                                <option value="D" {{ old('jawaban_benar', $soal->jawaban_benar) == 'D' ? 'selected' : '' }}>D</option>
                            </select>
                            @error('jawaban_benar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Essay Section -->
                     <div x-show="tipeSoal === 'essay'" class="space-y-6">
                        <div>
                            <label for="kunci_jawaban_essay" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kunci Jawaban / Kata Kunci (Essay)</label>
                            <textarea name="kunci_jawaban_essay" id="kunci_jawaban_essay" rows="4" :required="tipeSoal === 'essay'"
                                class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm"
                                placeholder="Masukkan jawaban yang benar atau poin-poin penting...">{{ old('kunci_jawaban_essay', $soal->kunci_jawaban_essay) }}</textarea>
                            @error('kunci_jawaban_essay') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>


                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Status Soal</label>
                        <select name="status" id="status" required
                            class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                            <option value="aktif" {{ old('status', $soal->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $soal->status) == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('admin.skill-tests') }}"
                            class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-600 dark:hover:bg-slate-700">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-dark focus:ring-4 focus:ring-primary/20">
                            Perbarui Soal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection