@extends('layouts.dashboard')

@section('title', 'Profil Instansi - Digital Skill Passport')

@section('header_title', 'Profil Instansi')

@section('sidebar')
    @include('layouts.partials.sidebar-umkm')
@endsection

@section('content')
    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('umkm.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Profile Header -->
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-800 flex flex-col md:flex-row gap-6 items-center">
                <div class="relative group">
                    <div
                        class="size-24 rounded-2xl overflow-hidden border-4 border-slate-50 dark:border-slate-800 shadow-lg">
                        <img id="logo-preview"
                            src="{{ (isset($umkm) && $umkm->logo) ? asset('storage/' . $umkm->logo) : 'https://ui-avatars.com/api/?name=' . urlencode(optional($umkm)->nama_umkm ?? 'Instansi') . '&color=7F9CF5&background=EBF4FF&size=128&bold=true' }}"
                            alt="Logo Instansi" class="w-full h-full object-cover">
                    </div>
                    <label for="logo"
                        class="absolute inset-0 bg-black/40 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                        <span class="material-symbols-outlined text-white">photo_camera</span>
                    </label>
                    <input type="file" name="logo" id="logo" class="hidden" onchange="previewLogo(this)">
                </div>
                <div class="text-center md:text-left flex-1">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">{{ optional($umkm)->nama_umkm }}</h2>
                    <div class="flex items-center justify-center md:justify-start gap-2 mt-1">
                        <span
                            class="text-xs font-bold uppercase tracking-widest text-primary">{{ optional($umkm)->status_verifikasi ?? 'Belum Terverifikasi' }}</span>
                        @if(optional($umkm)->status_verifikasi == 'Terverifikasi')
                            <span class="material-symbols-outlined text-primary text-sm filled">verified</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Instansi Info -->
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div
                    class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">business</span>
                    <h3 class="font-bold">Informasi Instansi</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Instansi/UMKM</label>
                        <input type="text" name="nama_instansi"
                            value="{{ old('nama_instansi', optional($umkm)->nama_instansi ?? optional($umkm)->nama_umkm) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Email Instansi</label>
                        <input type="email" name="email_instansi"
                            value="{{ old('email_instansi', optional($umkm)->email_instansi) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Nomor Telepon</label>
                        <input type="tel" name="telepon" value="{{ old('telepon', optional($umkm)->telepon) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Website</label>
                        <input type="url" name="website" value="{{ old('website', optional($umkm)->website) }}"
                            placeholder="https://..."
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="md:col-span-2 space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">{{ old('alamat', optional($umkm)->alamat) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div
                    class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">description</span>
                    <h3 class="font-bold">Deskripsi Instansi</h3>
                </div>
                <div class="p-6">
                    <textarea name="deskripsi" rows="5" placeholder="Ceritakan latar belakang instansi Anda..."
                        class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">{{ old('deskripsi', optional($umkm)->deskripsi) }}</textarea>
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
        function previewLogo(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('logo-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection