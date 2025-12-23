@extends('layouts.dashboard')

@section('title', 'Profil Saya - Digital Skill Passport')

@section('header_title', 'Profil Saya')

@section('sidebar')
    @include('layouts.partials.sidebar-talent')
@endsection

@section('content')
    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('talent.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Profile Header -->
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col md:flex-row gap-6 items-center">
                <div class="relative group">
                    <div
                        class="size-24 rounded-full overflow-hidden border-4 border-slate-50 dark:border-slate-700 shadow-lg">
                        <img id="profile-preview"
                            src="{{ (isset($talent) && $talent->foto) ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(optional($talent)->nama_lengkap ?? 'User') . '&color=7F9CF5&background=EBF4FF' }}"
                            alt="Foto Profil" class="w-full h-full object-cover">
                    </div>
                    <label for="foto"
                        class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                        <span class="material-symbols-outlined text-white">photo_camera</span>
                    </label>
                    <input type="file" name="foto" id="foto" class="hidden" onchange="previewImage(this)">
                </div>
                <div class="text-center md:text-left">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">{{ optional($talent)->nama_lengkap }}</h2>
                    <p class="text-slate-500 dark:text-slate-400 font-medium">
                        {{ optional($talent)->pekerjaan_saat_ini ?? 'Talenta Digital' }}
                    </p>
                </div>
            </div>

            <!-- Basic Info -->
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div
                    class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person</span>
                    <h3 class="font-bold">Informasi Dasar</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap"
                            value="{{ old('nama_lengkap', optional($talent)->nama_lengkap) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                        @error('nama_lengkap') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Pekerjaan Saat Ini</label>
                        <input type="text" name="pekerjaan_saat_ini"
                            value="{{ old('pekerjaan_saat_ini', optional($talent)->pekerjaan_saat_ini) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Nomor Telepon</label>
                        <input type="tel" name="telepon" value="{{ old('telepon', optional($talent)->telepon) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', optional($talent)->tanggal_lahir) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="md:col-span-2 space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Alamat</label>
                        <textarea name="alamat" rows="2"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">{{ old('alamat', optional($talent)->alamat) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Bio -->
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div
                    class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">description</span>
                    <h3 class="font-bold">Tentang Saya</h3>
                </div>
                <div class="p-6">
                    <textarea name="deskripsi" rows="4" placeholder="Ceritakan tentang Anda..."
                        class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">{{ old('deskripsi', optional($talent)->deskripsi) }}</textarea>
                </div>
            </div>

            <!-- Additional Info -->
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div
                    class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">psychology</span>
                    <h3 class="font-bold">Keahlian & Pendidikan</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Skill (Pisahkan dengan
                            koma)</label>
                        <input type="text" name="skill" value="{{ old('skill', optional($talent)->skill) }}"
                            placeholder="PHP, Laravel, JavaScript"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan_terakhir"
                            value="{{ old('pendidikan_terakhir', optional($talent)->pendidikan_terakhir) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">LinkedIn URL</label>
                        <input type="url" name="linkedin" value="{{ old('linkedin', optional($talent)->linkedin) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Portfolio URL</label>
                        <input type="url" name="portfolio" value="{{ old('portfolio', optional($talent)->portfolio) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end pb-12">
                <button type="submit"
                    class="px-8 py-3 bg-primary text-white rounded-xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-primary/30 flex items-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profile-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection