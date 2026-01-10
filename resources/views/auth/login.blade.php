@extends('layouts.guest')

@section('title', 'Masuk - Digital Skill Passport')

@section('content')
    <!-- Main Container with Animated Mesh Gradient -->
    <div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-slate-50 dark:bg-[#0B1120]">

        <!-- Vivid Gradient Background -->
        <div class="absolute inset-0 w-full h-full">
            <div class="absolute top-[-20%] left-[-10%] w-[70vw] h-[70vw] bg-blue-500/30 rounded-full mix-blend-multiply filter blur-[80px] opacity-70 animate-blob"></div>
            <div class="absolute top-[-10%] right-[-10%] w-[60vw] h-[60vw] bg-purple-500/30 rounded-full mix-blend-multiply filter blur-[80px] opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-[-20%] left-[20%] w-[60vw] h-[60vw] bg-pink-500/30 rounded-full mix-blend-multiply filter blur-[80px] opacity-70 animate-blob animation-delay-4000"></div>
             <!-- Noise Overlay for Texture -->
            <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noiseFilter%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.65%22 numOctaves=%223%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noiseFilter)%22/%3E%3C/svg%3E');"></div>
        </div>

        <!-- Content Layout -->
        <div class="relative w-full max-w-[1200px] h-[600px] sm:h-[700px] lg:h-[800px] mx-4 grid lg:grid-cols-12 rounded-[3rem] bg-white dark:bg-slate-900 shadow-[0_25px_50px_-12px_rgba(0,0,0,0.25)] overflow-hidden border border-white/20 dark:border-slate-800">
            
            <!-- Left: Visual & Brand (7 cols) -->
            <div class="hidden lg:flex lg:col-span-7 relative flex-col justify-between p-12 overflow-hidden text-white">
                 <!-- Image Background with unique curve -->
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?q=80&w=2574&auto=format&fit=crop" class="w-full h-full object-cover" alt="Creative Workspace">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 to-purple-900/80 mix-blend-multiply"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                </div>

                <!-- Floating Elements on Image -->
                <div class="absolute top-1/4 right-10 w-20 h-20 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-2xl animate-float flex items-center justify-center transform rotate-12">
                     <span class="material-symbols-outlined text-4xl">rocket_launch</span>
                </div>
                <div class="absolute bottom-1/3 left-10 w-16 h-16 bg-white/10 backdrop-blur-md rounded-full border border-white/20 shadow-2xl animate-float animation-delay-2000 flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">verified</span>
                </div>

                <!-- Header Content -->
                <div class="relative z-10 flex items-center gap-3">
                    <div class="w-10 h-10 bg-white text-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="material-symbols-outlined">fingerprint</span>
                    </div>
                    <span class="font-black tracking-widest uppercase text-sm">Digital Squad</span>
                </div>

                <!-- Footer Content -->
                 <div class="relative z-10 space-y-6">
                    <h1 class="text-5xl font-black leading-tight tracking-tight">
                        Platform Karir <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-white">Masa Depan.</span>
                    </h1>
                    <p class="text-blue-100 text-lg max-w-md leading-relaxed">
                        Bergabunglah dengan ribuan profesional yang telah menemukan peluang emas mereka bersama kami.
                    </p>
                    
                    <div class="flex items-center gap-4 pt-4">
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-white/30" src="https://i.pravatar.cc/100?img=1" alt="">
                            <img class="w-10 h-10 rounded-full border-2 border-white/30" src="https://i.pravatar.cc/100?img=5" alt="">
                            <img class="w-10 h-10 rounded-full border-2 border-white/30" src="https://i.pravatar.cc/100?img=8" alt="">
                            <div class="w-10 h-10 rounded-full border-2 border-white/30 bg-white/20 flex items-center justify-center text-xs font-bold">+2k</div>
                        </div>
                        <div class="text-xs font-bold uppercase tracking-wider text-blue-200">
                             Community <br> Members
                        </div>
                    </div>
                </div>
                
                <!-- Abstract Lines -->
                <svg class="absolute bottom-0 right-0 w-1/2 h-full opacity-20 pointer-events-none" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 C 30 50 70 80 100 0 L 100 100 Z" fill="url(#grad1)" />
                    <defs>
                        <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" style="stop-color:white;stop-opacity:0" />
                            <stop offset="100%" style="stop-color:white;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>

            <!-- Right: Login Form (5 cols) -->
            <div class="col-span-12 lg:col-span-5 p-8 sm:p-12 xl:p-16 flex flex-col justify-center bg-gradient-to-br from-blue-50 to-white dark:bg-slate-900 relative">
                <!-- Mobile Only Header -->
                <div class="lg:hidden mb-8 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 rounded-xl mb-4 shadow-lg shadow-blue-500/30">
                        <span class="material-symbols-outlined text-white text-2xl">verified_user</span>
                    </div>
                </div>

                <div class="w-full max-w-sm mx-auto space-y-8">
                    <!-- Heading -->
                    <div>
                        <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-2">Welcome Back!</h2>
                        <p class="text-slate-500 dark:text-slate-400 font-medium">Masukan kredensial anda untuk mengakses akun.</p>
                    </div>
                    
                    @if ($errors->any())
                        <div class="p-4 rounded-xl bg-red-50 dark:bg-red-900/10 border-l-4 border-red-500 text-red-700 dark:text-red-400 text-sm font-medium animate-shake">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="material-symbols-outlined text-base">error</span>
                                <span class="font-bold">Login Error</span>
                            </div>
                            <ul class="list-disc list-inside text-xs opacity-90">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" class="space-y-6" x-data="{ showPass: false }">
                         @csrf
                        
                        <!-- Floating Input: Email -->
                        <div class="relative group">
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder=" " 
                                class="peer w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-800 border-2 border-transparent focus:border-blue-500 rounded-xl text-slate-900 dark:text-white font-semibold outline-none transition-all placeholder-shown:border-slate-100 dark:placeholder-shown:border-slate-700">
                            <label for="email" 
                                class="absolute left-4 top-[-8px] bg-white dark:bg-slate-900 px-1 text-[10px] font-bold text-blue-500 uppercase tracking-widest transition-all 
                                peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-slate-400 peer-placeholder-shown:normal-case peer-placeholder-shown:font-medium peer-placeholder-shown:bg-transparent
                                peer-focus:top-[-8px] peer-focus:text-[10px] peer-focus:text-blue-500 peer-focus:font-bold peer-focus:uppercase peer-focus:bg-white dark:peer-focus:bg-slate-900">
                                Email Address
                            </label>
                            <span class="material-symbols-outlined absolute right-4 top-3.5 text-slate-300 peer-focus:text-blue-500 transition-colors pointer-events-none">mail</span>
                        </div>

                        <!-- Floating Input: Password -->
                        <div class="relative group">
                             <input :type="showPass ? 'text' : 'password'" name="password" id="password" required placeholder=" " 
                                class="peer w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-800 border-2 border-transparent focus:border-blue-500 rounded-xl text-slate-900 dark:text-white font-semibold outline-none transition-all placeholder-shown:border-slate-100 dark:placeholder-shown:border-slate-700">
                             <label for="password" 
                                class="absolute left-4 top-[-8px] bg-white dark:bg-slate-900 px-1 text-[10px] font-bold text-blue-500 uppercase tracking-widest transition-all 
                                peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-slate-400 peer-placeholder-shown:normal-case peer-placeholder-shown:font-medium peer-placeholder-shown:bg-transparent
                                peer-focus:top-[-8px] peer-focus:text-[10px] peer-focus:text-blue-500 peer-focus:font-bold peer-focus:uppercase peer-focus:bg-white dark:peer-focus:bg-slate-900">
                                Password
                            </label>
                            <button type="button" @click="showPass = !showPass" class="absolute right-4 top-3.5 text-slate-300 hover:text-blue-500 transition-colors">
                                <span class="material-symbols-outlined" x-text="showPass ? 'visibility_off' : 'visibility'"></span>
                            </button>
                        </div>

                        <div class="flex justify-end">
                             <a href="#" class="text-xs font-bold text-slate-500 hover:text-blue-600 transition-colors">Lupa Password?</a>
                        </div>

                        <button type="submit" 
                            class="w-full py-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm uppercase tracking-widest shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:scale-[1.02] active:scale-95 transition-all duration-200">
                            Masuk
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="relative flex py-2 items-center">
                        <div class="flex-grow border-t border-slate-100 dark:border-slate-800"></div>
                        <span class="flex-shrink-0 mx-4 text-xs font-bold text-slate-400 dark:text-slate-600 uppercase">Atau Lanjut Dengan</span>
                        <div class="flex-grow border-t border-slate-100 dark:border-slate-800"></div>
                    </div>

                    <!-- Socials -->
                    <div class="flex gap-4">
                        <button class="flex-1 py-3 px-4 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center gap-3 hover:bg-slate-50 dark:hover:bg-slate-700/80 transition-all group">
                             <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5 group-hover:scale-110 transition-transform">
                             <span class="text-sm font-bold text-slate-600 dark:text-slate-300">Google</span>
                        </button>
                         <button class="flex-1 py-3 px-4 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center gap-3 hover:bg-slate-50 dark:hover:bg-slate-700/80 transition-all group">
                             <img src="https://www.svgrepo.com/show/448234/linkedin.svg" class="w-5 h-5 group-hover:scale-110 transition-transform">
                             <span class="text-sm font-bold text-slate-600 dark:text-slate-300">LinkedIn</span>
                        </button>
                    </div>

                    <p class="text-center text-sm font-medium text-slate-500 dark:text-slate-400">
                        Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Daftar Sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
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

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .animate-float {
            animation: float 6s infinite ease-in-out;
        }

        @keyframes shake {
             10%, 90% { transform: translate3d(-1px, 0, 0); }
             20%, 80% { transform: translate3d(2px, 0, 0); }
             30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
             40%, 60% { transform: translate3d(4px, 0, 0); }
        }
        .animate-shake {
             animation: shake 0.82s cubic-bezier(.36,.07,.19,.97) both;
        }
    </style>
@endpush