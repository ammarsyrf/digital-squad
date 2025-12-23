@extends('layouts.dashboard')

@section('title', 'Pengaturan Akun - Digital Skill Passport')

@section('header_title', 'Pengaturan')

@section('sidebar')
    @include('layouts.partials.sidebar-umkm')
@endsection

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Account & Display Settings -->
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div
                class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">manage_accounts</span>
                <h3 class="font-bold">Keamanan & Tampilan</h3>
            </div>
            <div class="p-8 space-y-8">
                <!-- Email & Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h4 class="font-bold flex items-center gap-2 text-sm text-slate-900 dark:text-white">
                            <span class="material-symbols-outlined text-primary text-xl">mail</span>
                            Alamat Email
                        </h4>
                        <p class="text-sm text-slate-500">Email Utama: <span
                                class="font-bold text-slate-900 dark:text-white">{{ Auth::user()->email }}</span></p>
                        <button type="button"
                            class="px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">Ubah
                            Email</button>
                    </div>
                    <div class="space-y-4">
                        <h4 class="font-bold flex items-center gap-2 text-sm text-slate-900 dark:text-white">
                            <span class="material-symbols-outlined text-primary text-xl">lock</span>
                            Kata Sandi
                        </h4>
                        <p class="text-sm text-slate-500">Amankan akun Anda secara berkala</p>
                        <button type="button"
                            class="px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">Ganti
                            Kata Sandi</button>
                    </div>
                </div>

                <hr class="border-slate-100 dark:border-slate-700">

                <!-- Preferences -->
                <div class="space-y-6">
                    <h4 class="font-bold flex items-center gap-2 text-sm text-slate-900 dark:text-white">
                        <span class="material-symbols-outlined text-primary text-xl">palette</span>
                        Preferensi Tampilan
                    </h4>
                    <div class="flex gap-4">
                        <button type="button" onclick="setTheme('light')"
                            class="flex items-center gap-3 px-6 py-3 bg-slate-100 dark:bg-slate-800 rounded-xl border-2 border-transparent hover:border-primary transition-all">
                            <span class="material-symbols-outlined">light_mode</span>
                            <span class="font-bold text-sm">Terang</span>
                        </button>
                        <button type="button" onclick="setTheme('dark')"
                            class="flex items-center gap-3 px-6 py-3 bg-slate-900 text-white rounded-xl border-2 border-transparent hover:border-primary transition-all">
                            <span class="material-symbols-outlined text-white">dark_mode</span>
                            <span class="font-bold text-sm">Gelap</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function setTheme(theme) {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
            } else {
                document.documentElement.classList.add('light');
                document.documentElement.classList.remove('dark');
            }
            localStorage.setItem('theme', theme);
        }
    </script>
@endsection