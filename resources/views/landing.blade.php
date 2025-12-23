@extends('layouts.guest')

@section('title', 'Digital Skill Passport - Masa Depan Karier Digital Anda')

@section('content')
    <div class="relative flex h-auto w-full flex-col overflow-x-hidden">
        <!-- Hero Section -->
        <section class="relative flex flex-col items-center justify-center py-20 lg:py-32 overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
                <div
                    class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-primary/20 blur-[120px] rounded-full mix-blend-multiply dark:mix-blend-screen opacity-70 animate-blob">
                </div>
                <div
                    class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] bg-purple-500/20 blur-[120px] rounded-full mix-blend-multiply dark:mix-blend-screen opacity-70 animate-blob animation-delay-2000">
                </div>
            </div>

            <div class="mx-auto max-w-[1200px] px-6 relative z-10">
                <div class="grid gap-12 lg:grid-cols-2 lg:gap-20 items-center">
                    <!-- Hero Content -->
                    <div class="flex flex-col gap-8 text-center lg:text-left fade-in-up">
                        <div class="space-y-6">
                            <div
                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800 self-center lg:self-start">
                                <span class="flex h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                                <span class="text-xs font-bold text-primary tracking-wide uppercase">Official Platform
                                    Digital Squad</span>
                            </div>
                            <h1
                                class="text-5xl font-black leading-tight tracking-tighter text-slate-900 dark:text-white sm:text-6xl lg:text-7xl uppercase drop-shadow-sm">
                                Digital Skill <br> <span
                                    class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-purple-600">Passport</span>
                            </h1>
                            <p
                                class="text-lg font-medium leading-relaxed text-slate-600 dark:text-slate-300 max-w-xl mx-auto lg:mx-0">
                                Validasi keahlian digital Anda dengan standar industri. Bangun portofolio terverifikasi yang
                                diakui oleh ribuan perusahaan dan UMKM di seluruh Indonesia.
                            </p>
                        </div>
                        <div class="flex flex-wrap items-center justify-center gap-4 lg:justify-start">
                            <a href="{{ route('register') }}"
                                class="inline-flex h-14 items-center justify-center rounded-2xl bg-gradient-to-r from-primary to-blue-600 px-8 text-sm font-black uppercase tracking-widest text-white shadow-xl shadow-blue-500/30 transition-all hover:shadow-blue-500/50 hover:scale-105 active:scale-95">
                                Daftar Sekarang
                            </a>
                            <a href="#fitur"
                                class="inline-flex h-14 items-center justify-center rounded-2xl border-2 border-slate-200 bg-white/50 backdrop-blur-sm px-8 text-sm font-black uppercase tracking-widest text-slate-700 shadow-sm transition-all hover:bg-white hover:border-primary hover:text-primary dark:border-slate-700 dark:bg-slate-800/50 dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-white hover:-translate-y-1">
                                Pelajari Lebih Lanjut
                            </a>
                        </div>

                        <!-- Trust Badge -->
                        <div class="flex items-center justify-center lg:justify-start gap-4 pt-6">
                            <div class="flex -space-x-4">
                                @for($i = 1; $i <= 4; $i++)
                                    <div
                                        class="w-12 h-12 rounded-full border-4 border-white dark:border-slate-900 bg-slate-200 flex items-center justify-center overflow-hidden shadow-md">
                                        <img src="https://i.pravatar.cc/150?img={{ $i + 10 }}" alt="User"
                                            class="w-full h-full object-cover">
                                    </div>
                                @endfor
                            </div>
                            <div class="flex flex-col text-left">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-yellow-400 text-sm filled">star</span>
                                    <span class="text-sm font-black text-slate-900 dark:text-white">4.9/5.0</span>
                                </div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">
                                    Trusted by 10k+ Users</p>
                            </div>
                        </div>
                    </div>

                    <!-- Hero Image Carousel -->
                    <div class="relative mx-auto w-full max-w-[500px] lg:max-w-none perspective-1000" x-data="{ 
                            activeSlide: 0, 
                            slides: [
                                'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=1000&auto=format&fit=crop',
                                'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1000&auto=format&fit=crop', 
                                'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&w=1000&auto=format&fit=crop'
                            ],
                            timer: null,
                            next() {
                                this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                            },
                            init() {
                                this.timer = setInterval(() => this.next(), 3000);
                            }
                        }">
                        <div
                            class="aspect-[4/5] lg:aspect-square overflow-hidden rounded-[2.5rem] bg-slate-100 dark:bg-slate-800 shadow-2xl shadow-primary/20 border-8 border-white dark:border-slate-800 relative group">
                            <!-- Slides -->
                            <template x-for="(slide, index) in slides" :key="index">
                                <img :src="slide"
                                    class="absolute inset-0 w-full h-full object-cover transition-all duration-700 ease-in-out transform"
                                    :class="{ 'opacity-100 scale-100': activeSlide === index, 'opacity-0 scale-110': activeSlide !== index }"
                                    alt="Hero Image">
                            </template>

                            <!-- Overlay Gradient -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60">
                            </div>

                            <!-- Carousel Indicators -->
                            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                                <template x-for="(slide, index) in slides" :key="index">
                                    <button
                                        @click="activeSlide = index; clearInterval(timer); timer = setInterval(() => next(), 5000);"
                                        class="h-1.5 rounded-full transition-all duration-300"
                                        :class="activeSlide === index ? 'w-8 bg-white' : 'w-2 bg-white/50 hover:bg-white/80'"></button>
                                </template>
                            </div>
                        </div>

                        <!-- Floating Badge Element -->
                        <div
                            class="absolute top-10 -right-8 hidden md:flex items-center gap-3 rounded-2xl bg-white/90 backdrop-blur-md p-4 shadow-xl dark:bg-slate-800/90 dark:border dark:border-slate-700 animate-float-slow z-20 border border-white/50">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                                <span class="material-symbols-outlined text-xl filled">verified</span>
                            </div>
                            <div>
                                <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Status Akun</p>
                                <p class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-tighter">
                                    Terverifikasi</p>
                            </div>
                        </div>

                        <div
                            class="absolute -bottom-6 -left-8 hidden md:flex items-center gap-3 rounded-2xl bg-white/90 backdrop-blur-md p-4 shadow-xl dark:bg-slate-800/90 dark:border dark:border-slate-700 animate-float-reverse z-20 border border-white/50">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                <span class="material-symbols-outlined text-xl">workspace_premium</span>
                            </div>
                            <div>
                                <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">Sertifikasi</p>
                                <p class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-tighter">
                                    Kompeten</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Feature Section -->
        <section id="fitur" class="flex flex-col py-24 bg-white dark:bg-slate-900 relative">
            <div
                class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] dark:bg-[radial-gradient(#1f2937_1px,transparent_1px)] [background-size:16px_16px] opacity-20">
            </div>

            <div class="mx-auto max-w-[1200px] px-6 relative z-10">
                <div class="flex flex-col gap-16">
                    <div class="flex flex-col gap-4 text-center items-center">
                        <span
                            class="inline-block px-4 py-1.5 rounded-full bg-primary/10 text-primary font-black uppercase tracking-[0.2em] text-xs">Fitur
                            Unggulan</span>
                        <h2
                            class="text-4xl font-black leading-tight text-slate-900 dark:text-white sm:text-5xl uppercase tracking-tighter max-w-2xl">
                            Solusi Cerdas untuk <br /><span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-500">Masa Depan
                                Karier</span>
                        </h2>
                    </div>
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                        <!-- Feature 1 -->
                        <div
                            class="group flex flex-col gap-6 rounded-[2rem] border border-slate-100 bg-white p-8 shadow-lg shadow-slate-200/50 hover:shadow-2xl hover:shadow-primary/10 hovery:-translate-y-2 transition-all duration-500 dark:border-slate-700 dark:bg-slate-800 dark:shadow-none relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-24 h-24 bg-blue-500/5 rounded-bl-[4rem] transition-all group-hover:scale-150">
                            </div>
                            <div
                                class="flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm border border-blue-100 dark:border-blue-800">
                                <span class="material-symbols-outlined text-4xl">workspace_premium</span>
                            </div>
                            <div class="flex flex-col gap-3 relative z-10">
                                <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                                    Sertifikat Digital</h3>
                                <p class="text-sm leading-relaxed text-slate-500 dark:text-slate-400 font-medium">
                                    Simpan dan kelola semua sertifikat prestasi Anda secara digital dengan keamanan
                                    blockchain.
                                </p>
                            </div>
                        </div>
                        <!-- Feature 2 -->
                        <div
                            class="group flex flex-col gap-6 rounded-[2rem] border border-slate-100 bg-white p-8 shadow-lg shadow-slate-200/50 hover:shadow-2xl hover:shadow-purple-500/10 hovery:-translate-y-2 transition-all duration-500 dark:border-slate-700 dark:bg-slate-800 dark:shadow-none relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 rounded-bl-[4rem] transition-all group-hover:scale-150">
                            </div>
                            <div
                                class="flex h-16 w-16 items-center justify-center rounded-2xl bg-purple-50 text-purple-600 dark:bg-purple-900/20 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm border border-purple-100 dark:border-purple-800">
                                <span class="material-symbols-outlined text-4xl">quiz</span>
                            </div>
                            <div class="flex flex-col gap-3 relative z-10">
                                <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Tes
                                    Kompetensi</h3>
                                <p class="text-sm leading-relaxed text-slate-500 dark:text-slate-400 font-medium">
                                    Validasi skill melalui tes terstandarisasi yang dirancang oleh pakar industri.
                                </p>
                            </div>
                        </div>
                        <!-- Feature 3 -->
                        <div
                            class="group flex flex-col gap-6 rounded-[2rem] border border-slate-100 bg-white p-8 shadow-lg shadow-slate-200/50 hover:shadow-2xl hover:shadow-emerald-500/10 hovery:-translate-y-2 transition-all duration-500 dark:border-slate-700 dark:bg-slate-800 dark:shadow-none relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/5 rounded-bl-[4rem] transition-all group-hover:scale-150">
                            </div>
                            <div
                                class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm border border-emerald-100 dark:border-emerald-800">
                                <span class="material-symbols-outlined text-4xl">qr_code_Scanner</span>
                            </div>
                            <div class="flex flex-col gap-3 relative z-10">
                                <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                                    Verifikasi Instan</h3>
                                <p class="text-sm leading-relaxed text-slate-500 dark:text-slate-400 font-medium">
                                    Bagikan profil profesional Anda dengan QR Code yang dapat diverifikasi secara real-time.
                                </p>
                            </div>
                        </div>
                        <!-- Feature 4 -->
                        <div
                            class="group flex flex-col gap-6 rounded-[2rem] border border-slate-100 bg-white p-8 shadow-lg shadow-slate-200/50 hover:shadow-2xl hover:shadow-orange-500/10 hovery:-translate-y-2 transition-all duration-500 dark:border-slate-700 dark:bg-slate-800 dark:shadow-none relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-24 h-24 bg-orange-500/5 rounded-bl-[4rem] transition-all group-hover:scale-150">
                            </div>
                            <div
                                class="flex h-16 w-16 items-center justify-center rounded-2xl bg-orange-50 text-orange-600 dark:bg-orange-900/20 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm border border-orange-100 dark:border-orange-800">
                                <span class="material-symbols-outlined text-4xl">rocket_launch</span>
                            </div>
                            <div class="flex flex-col gap-3 relative z-10">
                                <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                                    Karir Impian</h3>
                                <p class="text-sm leading-relaxed text-slate-500 dark:text-slate-400 font-medium">
                                    Terhubung langsung dengan ribuan lowongan kerja eksklusif dari mitra perusahaan kami.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section for Employers -->
        <section class="py-24 relative overflow-hidden">
            <!-- Decorative Blobs -->
            <div
                class="absolute top-1/2 left-0 -translate-y-1/2 w-[500px] h-[500px] bg-primary/20 blur-[100px] rounded-full opacity-30">
            </div>
            <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-blue-500/20 blur-[100px] rounded-full opacity-30">
            </div>

            <div class="mx-auto max-w-[1200px] px-6 relative z-10">
                <div
                    class="relative overflow-hidden rounded-[3rem] bg-slate-900 px-8 py-20 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.3)] sm:px-16 sm:py-24 group">
                    <div class="absolute inset-0 opacity-20"
                        style="background-image: radial-gradient(#137fec 1px, transparent 1px); background-size: 32px 32px;">
                    </div>
                    <div
                        class="absolute -top-24 -right-24 w-96 h-96 bg-primary/30 blur-[100px] rounded-full group-hover:bg-primary/50 transition-colors duration-1000">
                    </div>

                    <div class="relative flex flex-col items-center gap-10 text-center">
                        <div class="space-y-6 max-w-3xl">
                            <span
                                class="inline-block px-4 py-1.5 rounded-full bg-white/10 text-white/90 font-bold uppercase tracking-widest text-xs backdrop-blur-sm border border-white/10">Khusus
                                Mitra UMKM & Perusahaan</span>
                            <h2 class="text-4xl font-black text-white sm:text-6xl uppercase tracking-tighter">
                                Temukan Talenta Digital <br> <span
                                    class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">Siap
                                    Kerja</span>
                            </h2>
                            <p class="max-w-2xl mx-auto text-lg text-slate-300 font-medium leading-relaxed">
                                Hemat waktu dan biaya rekrutmen. Akses database talenta yang telah terverifikasi skill dan
                                kompetensinya secara objektif oleh platform kami.
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-4 justify-center">
                            <a href="{{ route('register') }}"
                                class="inline-flex h-16 items-center justify-center rounded-2xl bg-white px-10 text-sm font-black uppercase tracking-widest text-slate-900 shadow-2xl transition-all hover:scale-105 active:scale-95 group hover:bg-slate-50">
                                Mulai Rekrutmen Gratis
                                <span
                                    class="material-symbols-outlined ml-2 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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

        @keyframes float-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-float-slow {
            animation: float-slow 4s ease-in-out infinite;
        }

        @keyframes float-reverse {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(10px);
            }
        }

        .animate-float-reverse {
            animation: float-reverse 5s ease-in-out infinite;
        }

        .perspective-1000 {
            perspective: 1000px;
        }
    </style>
@endpush