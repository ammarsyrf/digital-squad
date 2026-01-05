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

                <div x-data="{
                    questions: {{ json_encode(old('questions', [['tipe_soal' => 'pilihan_ganda', 'pertanyaan' => '', 'opsi_a' => '', 'opsi_b' => '', 'opsi_c' => '', 'opsi_d' => '', 'jawaban_benar' => '', 'kunci_jawaban_essay' => '']])) }},
                    errors: {{ json_encode($errors->toArray()) }},
                    addQuestion() {
                        this.questions.push({
                            tipe_soal: 'pilihan_ganda',
                            pertanyaan: '',
                            opsi_a: '',
                            opsi_b: '',
                            opsi_c: '',
                            opsi_d: '',
                            jawaban_benar: '',
                            kunci_jawaban_essay: ''
                        });
                    },
                    removeQuestion(index) {
                        if (this.questions.length > 1) {
                            this.questions.splice(index, 1);
                        }
                    },
                    getError(index, field) {
                        const key = `questions.${index}.${field}`;
                        return this.errors[key] ? this.errors[key][0] : null;
                    }
                }" class="space-y-8">
                
                    <!-- Pengaturan Umum -->
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-6 border border-slate-200 dark:border-slate-700">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                            <span class="material-symbols-outlined mr-2">settings</span>
                            Pengaturan Umum
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="kategori_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kategori Skill</label>
                                <select name="kategori_id" id="kategori_id" required
                                    class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('kategori_id') == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="kesulitan" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tingkat Kesulitan</label>
                                <select name="kesulitan" id="kesulitan" required
                                    class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                    <option value="mudah" {{ old('kesulitan') == 'mudah' ? 'selected' : '' }}>Mudah</option>
                                    <option value="sedang" {{ old('kesulitan') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="sulit" {{ old('kesulitan') == 'sulit' ? 'selected' : '' }}>Sulit</option>
                                </select>
                                @error('kesulitan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Status Soal</label>
                                <select name="status" id="status" required
                                    class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Pertanyaan -->
                    <div class="space-y-6">
                        <template x-for="(question, index) in questions" :key="index">
                            <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-700 relative shadow-sm">
                                <div class="flex justify-between items-center mb-4 pb-4 border-b border-slate-100 dark:border-slate-800">
                                    <h4 class="text-md font-bold text-slate-800 dark:text-slate-200" x-text="'Soal #' + (index + 1)"></h4>
                                    <button type="button" @click="removeQuestion(index)" x-show="questions.length > 1" 
                                        class="text-red-500 hover:text-red-700 text-sm font-medium flex items-center">
                                        <span class="material-symbols-outlined text-sm mr-1">delete</span> Hapus
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 gap-6">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                        <div class="md:col-span-1">
                                            <label :for="'tipe_soal_'+index" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tipe Soal</label>
                                            <select :name="'questions['+index+'][tipe_soal]'" :id="'tipe_soal_'+index" x-model="question.tipe_soal" required
                                                class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                                <option value="pilihan_ganda">Pilihan Ganda</option>
                                                <option value="essay">Essay</option>
                                            </select>
                                        </div>
                                        <div class="md:col-span-3">
                                            <label :for="'pertanyaan_'+index" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Pertanyaan</label>
                                            <textarea :name="'questions['+index+'][pertanyaan]'" :id="'pertanyaan_'+index" rows="2" x-model="question.pertanyaan" required
                                                class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm" placeholder="Tulis pertanyaan disini..."></textarea>
                                            <p x-show="getError(index, 'pertanyaan')" x-text="getError(index, 'pertanyaan')" class="mt-1 text-sm text-red-600"></p>
                                        </div>
                                    </div>

                                    <!-- Section Pilihan Ganda -->
                                    <div x-show="question.tipe_soal === 'pilihan_ganda'" class="space-y-4 pt-2 border-t border-slate-100 dark:border-slate-800">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label :for="'opsi_a_'+index" class="block text-xs font-medium text-slate-500 uppercase mb-1">Opsi A</label>
                                                <input type="text" :name="'questions['+index+'][opsi_a]'" :id="'opsi_a_'+index" x-model="question.opsi_a" :required="question.tipe_soal === 'pilihan_ganda'"
                                                    class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                                <p x-show="getError(index, 'opsi_a')" x-text="getError(index, 'opsi_a')" class="mt-1 text-sm text-red-600"></p>
                                            </div>
                                            <div>
                                                <label :for="'opsi_b_'+index" class="block text-xs font-medium text-slate-500 uppercase mb-1">Opsi B</label>
                                                <input type="text" :name="'questions['+index+'][opsi_b]'" :id="'opsi_b_'+index" x-model="question.opsi_b" :required="question.tipe_soal === 'pilihan_ganda'"
                                                    class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                                <p x-show="getError(index, 'opsi_b')" x-text="getError(index, 'opsi_b')" class="mt-1 text-sm text-red-600"></p>
                                            </div>
                                            <div>
                                                <label :for="'opsi_c_'+index" class="block text-xs font-medium text-slate-500 uppercase mb-1">Opsi C</label>
                                                <input type="text" :name="'questions['+index+'][opsi_c]'" :id="'opsi_c_'+index" x-model="question.opsi_c" :required="question.tipe_soal === 'pilihan_ganda'"
                                                    class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                                <p x-show="getError(index, 'opsi_c')" x-text="getError(index, 'opsi_c')" class="mt-1 text-sm text-red-600"></p>
                                            </div>
                                            <div>
                                                <label :for="'opsi_d_'+index" class="block text-xs font-medium text-slate-500 uppercase mb-1">Opsi D</label>
                                                <input type="text" :name="'questions['+index+'][opsi_d]'" :id="'opsi_d_'+index" x-model="question.opsi_d" :required="question.tipe_soal === 'pilihan_ganda'"
                                                    class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                                <p x-show="getError(index, 'opsi_d')" x-text="getError(index, 'opsi_d')" class="mt-1 text-sm text-red-600"></p>
                                            </div>
                                        </div>
                                        <div>
                                            <label :for="'jawaban_benar_'+index" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kunci Jawaban</label>
                                            <select :name="'questions['+index+'][jawaban_benar]'" :id="'jawaban_benar_'+index" x-model="question.jawaban_benar" :required="question.tipe_soal === 'pilihan_ganda'"
                                                class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                                                <option value="">Pilih Jawaban Benar</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                            </select>
                                            <p x-show="getError(index, 'jawaban_benar')" x-text="getError(index, 'jawaban_benar')" class="mt-1 text-sm text-red-600"></p>
                                        </div>
                                    </div>

                                    <!-- Section Essay -->
                                    <div x-show="question.tipe_soal === 'essay'" class="pt-2 border-t border-slate-100 dark:border-slate-800">
                                        <label :for="'kunci_jawaban_essay_'+index" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kunci Jawaban / Kata Kunci</label>
                                        <textarea :name="'questions['+index+'][kunci_jawaban_essay]'" :id="'kunci_jawaban_essay_'+index" rows="3" x-model="question.kunci_jawaban_essay" :required="question.tipe_soal === 'essay'"
                                            class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm"
                                            placeholder="Masukkan jawaban benar atau poin-poin penting..."></textarea>
                                        <p x-show="getError(index, 'kunci_jawaban_essay')" x-text="getError(index, 'kunci_jawaban_essay')" class="mt-1 text-sm text-red-600"></p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="flex justify-between items-center pt-4">
                         <button type="button" @click="addQuestion()"
                            class="px-4 py-2 text-sm font-medium text-primary bg-primary/10 border border-primary/20 rounded-lg hover:bg-primary/20 transition-colors flex items-center">
                            <span class="material-symbols-outlined mr-2">add_circle</span> Tambah Soal Lain
                        </button>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.skill-tests') }}"
                                class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-600 dark:hover:bg-slate-700">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-dark focus:ring-4 focus:ring-primary/20 shadow-lg shadow-primary/30">
                                Simpan Semua Soal
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection