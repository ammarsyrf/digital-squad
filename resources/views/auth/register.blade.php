@extends('layouts.guest')

@section('title', 'Daftar - Digital Skill Passport')

@section('content')
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden py-12 px-4 sm:px-6 lg:px-8">
        <!-- Animated Background -->
        <div class="absolute inset-0 -z-10 bg-white dark:bg-slate-900">
            <div
                class="absolute top-[-10%] right-[-10%] w-[600px] h-[600px] bg-blue-500/20 blur-[100px] rounded-full mix-blend-multiply dark:mix-blend-screen opacity-70 animate-blob">
            </div>
            <div
                class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] bg-emerald-500/20 blur-[100px] rounded-full mix-blend-multiply dark:mix-blend-screen opacity-70 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute top-[40%] right-[40%] w-[400px] h-[400px] bg-purple-500/20 blur-[100px] rounded-full mix-blend-multiply dark:mix-blend-screen opacity-70 animate-blob animation-delay-4000">
            </div>
            <div
                class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] dark:bg-[radial-gradient(#1f2937_1px,transparent_1px)] [background-size:16px_16px] opacity-20">
            </div>
        </div>

        <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-12 items-center relative z-10">

            <!-- Welcome Content Side -->
            <div class="hidden lg:flex flex-col gap-8 pr-8">
                <div class="space-y-6">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/50 dark:bg-slate-800/50 border border-white/20 backdrop-blur-md shadow-sm">
                        <span class="flex h-2.5 w-2.5 rounded-full bg-primary animate-pulse"></span>
                        <span class="text-xs font-bold tracking-widest uppercase text-primary">Open Registration 2026</span>
                    </div>
                    <h1
                        class="text-5xl lg:text-6xl font-black leading-tight tracking-tight text-slate-900 dark:text-white drop-shadow-sm">
                        Mulai Perjalanan <br> <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-purple-600">Profesional
                            Anda</span>
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-300 leading-relaxed font-medium max-w-lg">
                        Bergabung dengan ekosistem digital terbesar yang menghubungkan talenta terbaik dengan peluang tanpa
                        batas.
                    </p>
                </div>

                <!-- Feature Cards -->
                <div class="grid gap-4">
                    <div
                        class="group flex items-center gap-5 p-5 rounded-2xl bg-white/60 dark:bg-slate-800/60 border border-white/50 dark:border-slate-700/50 backdrop-blur-md shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                        <div
                            class="h-14 w-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30 group-hover:rotate-6 transition-transform">
                            <span class="material-symbols-outlined text-3xl">workspace_premium</span>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 dark:text-white text-lg">Paspor Digital Resmi</h3>
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Verifikasi skill dengan
                                standar industri.</p>
                        </div>
                    </div>

                    <div
                        class="group flex items-center gap-5 p-5 rounded-2xl bg-white/60 dark:bg-slate-800/60 border border-white/50 dark:border-slate-700/50 backdrop-blur-md shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-300 delay-100">
                        <div
                            class="h-14 w-14 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center text-white shadow-lg shadow-purple-500/30 group-hover:rotate-6 transition-transform">
                            <span class="material-symbols-outlined text-3xl">rocket_launch</span>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 dark:text-white text-lg">Akselerasi Karir</h3>
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Terhubung langsung dengan
                                rekruter.</p>
                        </div>
                    </div>
                </div>

                <!-- Trust Indicator -->
                <div class="flex items-center gap-4 mt-4">
                    <div class="flex -space-x-3">
                        @for($i = 1; $i <= 4; $i++)
                            <div class="w-10 h-10 rounded-full border-2 border-white dark:border-slate-800 bg-slate-200"></div>
                        @endfor
                    </div>
                    <div class="h-10 border-l border-slate-300 dark:border-slate-700"></div>
                    <div class="flex flex-col">
                        <span class="text-sm font-black text-slate-900 dark:text-white">10.000+</span>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">User Terdaftar</span>
                    </div>
                </div>
            </div>

            <!-- Registration Form Card -->
            <div class="w-full max-w-lg mx-auto lg:ml-auto">
                <div
                    class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-[2.5rem] shadow-2xl border border-white/50 dark:border-slate-700/50 p-8 sm:p-10 relative overflow-hidden">
                    <!-- Glow Effect -->
                    <div
                        class="absolute -top-24 -right-24 w-48 h-48 bg-primary/20 blur-[80px] rounded-full pointer-events-none">
                    </div>

                    <div class="mb-8 relative z-10">
                        <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-2 uppercase tracking-tighter">Buat
                            Akun Baru</h2>
                        <p class="text-slate-500 dark:text-slate-400 font-bold">Gratis dan hanya butuh 1 menit.</p>
                    </div>

                    @if ($errors->any())
                        <div
                            class="bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 p-4 rounded-xl mb-6 text-sm font-bold border border-red-100 dark:border-red-900/30 flex items-center gap-3 animate-shake">
                            <span class="material-symbols-outlined">error</span>
                            <ul class="list-none">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="flex flex-col gap-5 relative z-10" method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Role Selection -->
                        <div class="space-y-3">
                            <label
                                class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Saya
                                mendaftar sebagai</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer relative group">
                                    <input checked class="peer sr-only" name="role" value="talent" type="radio" />
                                    <div
                                        class="h-full rounded-2xl border-2 border-slate-200 dark:border-slate-600 p-4 group-hover:border-primary/50 peer-checked:border-primary peer-checked:bg-blue-50/50 dark:peer-checked:bg-blue-900/20 transition-all flex flex-col items-center justify-center text-center gap-3 relative overflow-hidden">
                                        <div
                                            class="absolute inset-0 bg-primary/0 peer-checked:bg-primary/5 transition-colors">
                                        </div>
                                        <div
                                            class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center peer-checked:bg-primary peer-checked:text-white text-slate-500 transition-all duration-300 shadow-sm">
                                            <span class="material-symbols-outlined text-2xl">person</span>
                                        </div>
                                        <span
                                            class="text-[10px] font-black tracking-widest text-slate-600 dark:text-slate-300 uppercase peer-checked:text-primary">Talenta
                                            Digital</span>
                                    </div>
                                    <div
                                        class="absolute top-3 right-3 text-primary opacity-0 peer-checked:opacity-100 transition-opacity scale-0 peer-checked:scale-100 duration-300">
                                        <span class="material-symbols-outlined filled text-xl">check_circle</span>
                                    </div>
                                </label>

                                <label class="cursor-pointer relative group">
                                    <input class="peer sr-only" name="role" value="umkm" type="radio" />
                                    <div
                                        class="h-full rounded-2xl border-2 border-slate-200 dark:border-slate-600 p-4 group-hover:border-primary/50 peer-checked:border-primary peer-checked:bg-blue-50/50 dark:peer-checked:bg-blue-900/20 transition-all flex flex-col items-center justify-center text-center gap-3 relative overflow-hidden">
                                        <div
                                            class="absolute inset-0 bg-primary/0 peer-checked:bg-primary/5 transition-colors">
                                        </div>
                                        <div
                                            class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center peer-checked:bg-primary peer-checked:text-white text-slate-500 transition-all duration-300 shadow-sm">
                                            <span class="material-symbols-outlined text-2xl">storefront</span>
                                        </div>
                                        <span
                                            class="text-[10px] font-black tracking-widest text-slate-600 dark:text-slate-300 uppercase peer-checked:text-primary">UMKM
                                            / Instansi</span>
                                    </div>
                                    <div
                                        class="absolute top-3 right-3 text-primary opacity-0 peer-checked:opacity-100 transition-opacity scale-0 peer-checked:scale-100 duration-300">
                                        <span class="material-symbols-outlined filled text-xl">check_circle</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Name & Email -->
                        <div class="space-y-4">
                            <div class="relative flex items-center group">
                                <input type="text" name="nama" value="{{ old('nama') }}" required
                                    class="w-full rounded-2xl border-2 border-slate-100 dark:border-slate-700 bg-white/50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder:text-slate-400 focus:border-primary focus:ring-4 focus:ring-primary/10 py-3.5 pl-12 pr-4 text-sm font-bold transition-all outline-none"
                                    placeholder="Nama Lengkap">
                                <div
                                    class="absolute left-4 text-slate-400 group-focus-within:text-primary transition-colors pointer-events-none flex items-center">
                                    <span class="material-symbols-outlined text-[20px]">person</span>
                                </div>
                            </div>

                            <div class="relative flex items-center group">
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full rounded-2xl border-2 border-slate-100 dark:border-slate-700 bg-white/50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder:text-slate-400 focus:border-primary focus:ring-4 focus:ring-primary/10 py-3.5 pl-12 pr-4 text-sm font-bold transition-all outline-none"
                                    placeholder="Alamat Email">
                                <div
                                    class="absolute left-4 text-slate-400 group-focus-within:text-primary transition-colors pointer-events-none flex items-center">
                                    <span class="material-symbols-outlined text-[20px]">mail</span>
                                </div>
                            </div>
                        </div>

                        <!-- Password Fields -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="relative flex items-center group" x-data="{ show: false }">
                                <input :type="show ? 'text' : 'password'" name="password" required
                                    class="w-full rounded-2xl border-2 border-slate-100 dark:border-slate-700 bg-white/50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder:text-slate-400 focus:border-primary focus:ring-4 focus:ring-primary/10 py-3.5 pl-10 pr-10 text-sm font-bold transition-all outline-none"
                                    placeholder="Password">
                                <div
                                    class="absolute left-3 text-slate-400 group-focus-within:text-primary transition-colors pointer-events-none flex items-center">
                                    <span class="material-symbols-outlined text-[18px]">lock</span>
                                </div>
                                <button @click="show = !show" type="button"
                                    class="absolute right-3 text-slate-400 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[18px]"
                                        x-text="show ? 'visibility_off' : 'visibility'"></span>
                                </button>
                            </div>

                            <div class="relative flex items-center group" x-data="{ show: false }">
                                <input :type="show ? 'text' : 'password'" name="password_confirmation" required
                                    class="w-full rounded-2xl border-2 border-slate-100 dark:border-slate-700 bg-white/50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder:text-slate-400 focus:border-primary focus:ring-4 focus:ring-primary/10 py-3.5 pl-10 pr-10 text-sm font-bold transition-all outline-none"
                                    placeholder="Ulangi Password">
                                <div
                                    class="absolute left-3 text-slate-400 group-focus-within:text-primary transition-colors pointer-events-none flex items-center">
                                    <span class="material-symbols-outlined text-[18px]">lock_reset</span>
                                </div>
                                <button @click="show = !show" type="button"
                                    class="absolute right-3 text-slate-400 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[18px]"
                                        x-text="show ? 'visibility_off' : 'visibility'"></span>
                                </button>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full mt-2 py-4 px-6 rounded-2xl bg-gradient-to-r from-primary to-blue-600 text-white text-sm font-black uppercase tracking-widest shadow-xl shadow-blue-500/20 hover:shadow-blue-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                            Buat Akun Sekarang
                        </button>

                        <p class="text-center text-sm font-medium text-slate-500 dark:text-slate-400 mt-2">
                            Sudah punya akun?
                            <a href="{{ route('login') }}"
                                class="text-primary font-bold hover:underline decoration-2 underline-offset-4 ml-1">Masuk
                                disini</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-4px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(4px);
            }
        }

        .animate-shake {
            animation: shake 0.5s cubic-bezier(.36, .07, .19, .97) both;
        }
    </style>
@endpush