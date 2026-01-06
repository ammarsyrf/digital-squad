@extends('layouts.dashboard')

@section('title', $lowongan->judul . ' - Digital Skill Passport')

@section('header_title', 'Detail Pekerjaan')

@section('sidebar')
    @include('layouts.partials.sidebar-talent')
@endsection

@section('content')
    <div class="max-w-5xl mx-auto space-y-8 pb-12">
        <div
            class="bg-white dark:bg-slate-800 rounded-[32px] shadow-2xl shadow-slate-200/50 dark:shadow-none border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-500 hover:shadow-primary/5">
            <!-- Banner/Header with Premium Gradient -->
            <div class="h-48 bg-gradient-to-br from-primary via-blue-600 to-indigo-700 relative overflow-hidden">
                <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_30%_50%,rgba(255,255,255,0.4),transparent)]"></div>
                <div class="absolute -right-20 -top-20 size-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -left-10 -bottom-10 size-48 bg-blue-400/20 rounded-full blur-2xl"></div>
            </div>
            
            <div class="px-8 pb-8 relative">
                <div class="flex flex-col md:flex-row justify-between items-end gap-6">
                    <div class="flex flex-col md:flex-row items-end gap-6">
                        <div
                            class="size-32 rounded-3xl bg-white dark:bg-slate-700 p-2 shadow-2xl border border-slate-100 dark:border-slate-800 transform hover:scale-105 transition-transform duration-300 -mt-16">
                            @if($lowongan->umkm->logo)
                                <img src="{{ asset('storage/' . $lowongan->umkm->logo) }}" alt="Logo"
                                    class="w-full h-full object-cover rounded-2xl">
                            @else
                                <div
                                    class="w-full h-full bg-slate-50 dark:bg-slate-900 flex items-center justify-center rounded-2xl">
                                    <span class="material-symbols-outlined text-5xl text-slate-300">business</span>
                                </div>
                            @endif
                        </div>
                        <div class="pb-2">
                            <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight mb-1">{{ $lowongan->judul }}</h1>
                            <div class="flex items-center gap-2">
                                <p class="text-primary font-bold text-lg">{{ $lowongan->umkm->nama_umkm }}</p>
                                @if($lowongan->umkm->status_verifikasi == 'Terverifikasi')
                                    <span class="px-2 py-0.5 bg-emerald-500 text-white text-[9px] font-black rounded-full flex items-center gap-1 uppercase tracking-tighter">
                                        <span class="material-symbols-outlined text-[12px]">verified</span> Verified
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($hasApplied)
                        <div class="flex flex-col md:flex-row gap-3">
                            <div
                                class="px-8 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-black flex items-center gap-2 cursor-default transition-all">
                                <span class="material-symbols-outlined filled">check_circle</span>
                                Sudah Dilamar
                            </div>
                            <a href="{{ route('messages.show', $lowongan->umkm->user_id) }}"
                                class="px-8 py-4 bg-primary/5 text-primary border-2 border-primary/20 rounded-2xl font-black hover:bg-primary/10 transition-all flex items-center gap-2 active:scale-95">
                                <span class="material-symbols-outlined">chat</span>
                                Tanya Instansi
                            </a>
                        </div>
                    @else
                        <div x-data="{ showApplyModal: {{ $errors->any() ? 'true' : 'false' }}, fileName: null }">
                            <div class="flex flex-col md:flex-row gap-3">
                                <a href="{{ route('messages.show', $lowongan->umkm->user_id) }}"
                                    class="px-8 py-4 border-2 border-primary text-primary rounded-2xl font-black hover:bg-primary/5 transition-all flex items-center gap-2 active:scale-95">
                                    <span class="material-symbols-outlined">chat</span>
                                    Tanya Instansi
                                </a>
                                <button @click="showApplyModal = true"
                                    class="px-10 py-4 bg-primary text-white rounded-2xl font-black hover:bg-blue-600 transition-all shadow-xl shadow-primary/30 flex items-center gap-2 active:scale-95">
                                    <span class="material-symbols-outlined">send</span>
                                    Lamar Sekarang
                                </button>
                            </div>

                            <!-- Apply Modal -->
                            <div x-show="showApplyModal"
                                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0" x-cloak>
                                
                                <div @click.away="showApplyModal = false"
                                    class="bg-white dark:bg-slate-900 rounded-[32px] w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl flex flex-col"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                                    
                                    <!-- Header -->
                                    <div class="p-8 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center sticky top-0 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md z-10">
                                        <div>
                                            <h3 class="text-2xl font-black text-slate-900 dark:text-white">Lamar Pekerjaan</h3>
                                            <p class="text-slate-500 text-sm">Posisi: <span class="text-primary font-bold">{{ $lowongan->judul }}</span></p>
                                        </div>
                                        <button @click="showApplyModal = false" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                                            <span class="material-symbols-outlined">close</span>
                                        </button>
                                    </div>

                                    <!-- Form -->
                                    <form action="{{ route('talent.jobs.apply', $lowongan->id_lowongan) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                                        @csrf
                                        
                                        <!-- Warning Alert -->
                                        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl p-4 flex items-start gap-3">
                                            <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 mt-0.5">warning</span>
                                            <div class="text-sm text-amber-800 dark:text-amber-300">
                                                <p class="font-bold mb-1">Pastikan data diri Anda sudah benar!</p>
                                                <p>Jika terdapat kesalahan data, mohon perbarui terlebih dahulu di <a href="{{ route('talent.profile') }}" class="underline font-bold hover:text-amber-900 dark:hover:text-amber-200">halaman profil saya</a> sebelum mengirim lamaran.</p>
                                            </div>
                                        </div>

                                        <!-- Personal Info (Readonly) -->
                                        <!-- Personal Info (Readonly) -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="space-y-2">
                                                <label class="text-xs font-bold uppercase text-slate-500">Nama Lengkap</label>
                                                <input type="text" value="{{ Auth::user()->name }}" readonly
                                                    class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl font-bold text-slate-700 dark:text-slate-300 cursor-not-allowed focus:ring-0">
                                            </div>
                                            <div class="space-y-2">
                                                <label class="text-xs font-bold uppercase text-slate-500">Email</label>
                                                <input type="email" value="{{ Auth::user()->email }}" readonly
                                                    class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl font-bold text-slate-700 dark:text-slate-300 cursor-not-allowed focus:ring-0">
                                            </div>
                                            <div class="space-y-2 md:col-span-2">
                                                <label class="text-xs font-bold uppercase text-slate-500">Nomor Telepon</label>
                                                <input type="text" value="{{ optional(Auth::user()->talent)->telepon ?? '-' }}" readonly
                                                    class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl font-bold text-slate-700 dark:text-slate-300 cursor-not-allowed focus:ring-0">
                                            </div>
                                        </div>

                                        <!-- CV Upload -->
                                        <div class="space-y-2">
                                            <label class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                                <span class="material-symbols-outlined text-primary">upload_file</span>
                                                Unggah CV / Resume
                                                <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-2xl p-6 hover:border-primary/50 hover:bg-primary/5 transition-all text-center group cursor-pointer"
                                                :class="{'border-primary bg-primary/5': fileName, 'border-red-500 bg-red-50': {{ $errors->has('cv') ? 'true' : 'false' }} }">
                                                <input type="file" name="cv" accept=".pdf,.doc,.docx" required
                                                    @change="fileName = $event.target.files[0] ? $event.target.files[0].name : null"
                                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                                <div class="space-y-2 pointer-events-none">
                                                    <span class="material-symbols-outlined text-4xl text-slate-400 group-hover:text-primary transition-colors"
                                                        :class="{'text-primary': fileName, 'text-red-500': {{ $errors->has('cv') ? 'true' : 'false' }} }">
                                                        cloud_upload
                                                    </span>
                                                    <div>
                                                        <p class="text-sm font-bold text-slate-600 dark:text-slate-400 truncate px-4" x-text="fileName ? fileName : 'Klik untuk upload atau drag & drop'"></p>
                                                        <p class="text-xs text-primary font-bold mt-1" x-show="fileName">File terpilih - Klik untuk ganti</p>
                                                        <p class="text-xs text-slate-400" x-show="!fileName">PDF, DOC, DOCX (Maks. 2MB)</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('cv')
                                                <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Cover Letter -->
                                        <div class="space-y-2">
                                            <label class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                                <span class="material-symbols-outlined text-primary">description</span>
                                                Deskripsi Perkenalan / Cover Letter
                                                <span class="text-red-500">*</span>
                                            </label>
                                            <textarea name="cover_letter" rows="5" required minlength="20"
                                                placeholder="Perkenalkan diri Anda dan jelaskan mengapa Anda cocok untuk posisi ini..."
                                                class="w-full rounded-2xl border-slate-200 dark:border-slate-800 dark:bg-slate-950 focus:ring-primary focus:border-primary @error('cover_letter') border-red-500 focus:border-red-500 @enderror">{{ old('cover_letter') }}</textarea>
                                            <div class="flex justify-between">
                                                @error('cover_letter')
                                                    <p class="text-red-500 text-xs font-bold">{{ $message }}</p>
                                                @else
                                                    <span></span>
                                                @enderror
                                                <p class="text-xs text-slate-400 text-right">Min. 20 karakter</p>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3">
                                            <button type="button" @click="showApplyModal = false"
                                                class="px-6 py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-200 transition-colors">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                class="px-8 py-3 bg-primary text-white rounded-xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-primary/30 flex items-center gap-2">
                                                <span class="material-symbols-outlined">send</span>
                                                Kirim Lamaran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 border-t border-slate-100 dark:border-slate-700">
                <div class="lg:col-span-2 p-10 space-y-10">
                    <div>
                        <h3 class="text-2xl font-black mb-6 flex items-center gap-3">
                            <span class="size-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-xl">description</span>
                            </span>
                            Deskripsi Pekerjaan
                        </h3>
                        <div class="text-slate-600 dark:text-slate-400 leading-relaxed whitespace-pre-line text-lg">
                            {{ $lowongan->deskripsi }}
                        </div>
                    </div>

                    @if($lowongan->fasilitas)
                    <div class="pt-10 border-t border-slate-100 dark:border-slate-700">
                        <h3 class="text-2xl font-black mb-6 flex items-center gap-3">
                            <span class="size-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-xl">redeem</span>
                            </span>
                            Fasilitas & Benefit
                        </h3>
                        <div class="text-slate-600 dark:text-slate-400 leading-relaxed whitespace-pre-line text-lg">
                            {{ $lowongan->fasilitas }}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Glassmorphism Ringkasan Card -->
                <div class="p-10 bg-slate-50/50 dark:bg-slate-800/50 space-y-8 backdrop-blur-sm border-l border-slate-100 dark:border-slate-700">
                    <div>
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Ringkasan Karir</h4>
                        <div class="space-y-6">
                            <div class="flex items-center gap-4 group">
                                <div
                                    class="size-12 bg-white dark:bg-slate-700 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <span class="material-symbols-outlined text-primary">location_on</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Lokasi</p>
                                    <p class="text-base font-black text-slate-900 dark:text-white truncate">{{ $lowongan->lokasi }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 group">
                                <div
                                    class="size-12 bg-white dark:bg-slate-700 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <span class="material-symbols-outlined text-primary">work_history</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Sistem Kerja</p>
                                    <p class="text-base font-black text-slate-900 dark:text-white truncate">{{ $lowongan->sistem_kerja ?? 'WFO' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 group">
                                <div
                                    class="size-12 bg-white dark:bg-slate-700 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <span class="material-symbols-outlined text-primary">schedule</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Tipe Kerja</p>
                                    <p class="text-base font-black text-slate-900 dark:text-white truncate">{{ $lowongan->tipe_pekerjaan }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 group">
                                <div
                                    class="size-12 bg-white dark:bg-slate-700 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <span class="material-symbols-outlined text-primary">payments</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Estimasi Gaji</p>
                                    <p class="text-base font-black text-slate-900 dark:text-white truncate">{{ $lowongan->gaji ?? 'As negotiated' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-10 border-t border-slate-200 dark:border-slate-700 space-y-6">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Tentang Instansi</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-4">
                            {{ $lowongan->umkm->deskripsi ?? 'Instansi ini belum mencantumkan deskripsi profil mereka secara mendalam.' }}</p>
                        <a href="{{ route('talent.umkm.show', $lowongan->umkm->id_umkm) }}" 
                            class="group flex items-center justify-between p-4 bg-primary/5 rounded-2xl border border-primary/10 hover:bg-primary/10 transition-all active:scale-95">
                            <span class="text-sm font-black text-primary">Lihat Profil Instansi</span>
                            <span class="material-symbols-outlined text-primary group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection