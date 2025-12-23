@extends('layouts.guest')

@section('title', 'Masuk - Digital Skill Passport')

@section('content')
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden py-12 px-4 sm:px-6 lg:px-8">
        <!-- Animated Background -->
        <div class="absolute inset-0 -z-10 bg-white dark:bg-slate-900">
            <div
                class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-primary/20 blur-[100px] rounded-full mix-blend-multiply dark:mix-blend-screen opacity-70 animate-blob">
            </div>
            <div
                class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-purple-500/20 blur-[100px] rounded-full mix-blend-multiply dark:mix-blend-screen opacity-70 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute top-[40%] left-[40%] w-[300px] h-[300px] bg-emerald-500/20 blur-[100px] rounded-full mix-blend-multiply dark:mix-blend-screen opacity-70 animate-blob animation-delay-4000">
            </div>
            <div
                class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] dark:bg-[radial-gradient(#1f2937_1px,transparent_1px)] [background-size:16px_16px] opacity-20">
            </div>
        </div>

        <div
            class="w-full max-w-[1100px] grid lg:grid-cols-2 bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl rounded-[2.5rem] shadow-2xl border border-white/50 dark:border-slate-700/50 overflow-hidden relative z-10">

            <!-- Visual Side -->
            <div class="relative hidden lg:flex flex-col justify-end p-12 bg-slate-900 overflow-hidden group">
                <div class="absolute inset-0 opacity-50 transition-transform duration-1000 group-hover:scale-110"
                    style="background-image: url('https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=1000&auto=format&fit=crop'); background-size: cover; background-position: center;">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>

                <div class="relative z-10 text-white space-y-6">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/10 backdrop-blur-md">
                        <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-[10px] font-bold tracking-widest uppercase">Member Area</span>
                    </div>
                    <div>
                        <h2 class="text-4xl font-black leading-tight tracking-tight mb-4">Kembali Berkarya & <br> <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">Terus
                                Bertumbuh</span></h2>
                        <p class="text-slate-300 font-medium text-lg leading-relaxed max-w-sm">
                            Kelola portofolio, akses ribuan lowongan, dan bangun reputasi profesional Anda dalam satu
                            platform terintegrasi.
                        </p>
                    </div>

                    <!-- Decor -->
                    <div class="flex items-center gap-4 pt-4">
                        <div class="flex -space-x-4">
                            @for($i = 1; $i <= 3; $i++)
                                <div
                                    class="w-10 h-10 rounded-full border-2 border-slate-900 bg-slate-800 flex items-center justify-center overflow-hidden">
                                    <img src="https://i.pravatar.cc/150?img={{ $i + 20 }}" alt="User"
                                        class="w-full h-full object-cover">
                                </div>
                            @endfor
                            <div
                                class="w-10 h-10 rounded-full border-2 border-slate-900 bg-slate-800 flex items-center justify-center text-[10px] font-bold">
                                +10k
                            </div>
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Profesional Bergabung</p>
                    </div>
                </div>
            </div>

            <!-- Form Side -->
            <div class="flex flex-col justify-center p-8 sm:p-12 lg:p-16 relative">
                <div class="absolute top-0 right-0 p-8 hidden sm:block">
                    <a href="{{ route('home') }}"
                        class="group flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-primary transition-colors">
                        <span
                            class="material-symbols-outlined text-lg group-hover:-translate-x-1 transition-transform">arrow_back</span>
                        Kembali ke Beranda
                    </a>
                </div>

                <div class="w-full max-w-md mx-auto space-y-8">
                    <div class="text-center sm:text-left space-y-3">
                        <div
                            class="inline-flex sm:hidden items-center justify-center w-12 h-12 rounded-xl bg-primary/10 text-primary mb-4">
                            <span class="material-symbols-outlined text-2xl">verified_user</span>
                        </div>
                        <h1 class="text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tighter">Selamat
                            Datang!</h1>
                        <p class="text-slate-500 dark:text-slate-400 font-medium text-base">Silakan masuk dengan akun yang
                            terdaftar.</p>
                    </div>

                    @if ($errors->any())
                        <div
                            class="bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 p-4 rounded-xl text-sm font-bold border border-red-100 dark:border-red-900/30 flex items-start gap-3 animate-shake">
                            <span class="material-symbols-outlined text-xl shrink-0">error</span>
                            <div>
                                <ul class="list-none space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label
                                class="text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Email</label>
                            <div class="relative flex items-center group">
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full rounded-2xl border-2 border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder:text-slate-400 focus:border-primary focus:ring-4 focus:ring-primary/10 py-4 pl-12 pr-4 text-sm font-bold transition-all outline-none"
                                    placeholder="nama@email.com">
                                <div
                                    class="absolute left-4 text-slate-400 group-focus-within:text-primary transition-colors pointer-events-none flex items-center">
                                    <span class="material-symbols-outlined text-[20px]">mail</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between items-end">
                                <label
                                    class="text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Password</label>
                                <a href="#"
                                    class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline decoration-2 underline-offset-4">Lupa
                                    Password?</a>
                            </div>
                            <div class="relative flex items-center group" x-data="{ show: false }">
                                <input :type="show ? 'text' : 'password'" name="password" required
                                    class="w-full rounded-2xl border-2 border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder:text-slate-400 focus:border-primary focus:ring-4 focus:ring-primary/10 py-4 pl-12 pr-12 text-sm font-bold transition-all outline-none"
                                    placeholder="········">
                                <div
                                    class="absolute left-4 text-slate-400 group-focus-within:text-primary transition-colors pointer-events-none flex items-center">
                                    <span class="material-symbols-outlined text-[20px]">lock_open</span>
                                </div>
                                <button @click="show = !show" type="button"
                                    class="absolute right-4 text-slate-400 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[20px]"
                                        x-text="show ? 'visibility_off' : 'visibility'"></span>
                                </button>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-primary to-blue-600 text-white text-sm font-black uppercase tracking-widest shadow-xl shadow-blue-500/20 hover:shadow-blue-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                            Masuk Sekarang
                        </button>
                    </form>

                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-100 dark:border-slate-700"></div>
                        </div>
                        <div class="relative flex justify-center text-[10px] font-black uppercase tracking-widest">
                            <span class="bg-white dark:bg-slate-800 px-4 text-slate-400">Atau masuk dengan</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <button
                            class="flex items-center justify-center gap-3 py-3.5 px-4 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:border-slate-300 dark:hover:border-slate-600 transition-all group bg-white dark:bg-transparent">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg"
                                class="w-5 h-5 group-hover:scale-110 transition-transform">
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-300">Google</span>
                        </button>
                        <button
                            class="flex items-center justify-center gap-3 py-3.5 px-4 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-200 dark:hover:border-blue-800 transition-all group bg-white dark:bg-transparent">
                            <img src="https://www.svgrepo.com/show/448234/linkedin.svg"
                                class="w-5 h-5 group-hover:scale-110 transition-transform">
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-300">LinkedIn</span>
                        </button>
                    </div>

                    <p class="text-center text-sm font-medium text-slate-500 dark:text-slate-400">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                            class="text-primary font-bold hover:underline decoration-2 underline-offset-4 ml-1">Daftar
                            Gratis</a>
                    </p>
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