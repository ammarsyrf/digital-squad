@extends('layouts.dashboard')

@section('title', 'Daftar Pelamar - Digital Skill Passport')

@section('header_title', 'Lihat Pelamar')

@section('sidebar')
    @include('layouts.partials.sidebar-umkm')
@endsection

@section('content')
    <div class="space-y-6">
        <div>
            <h2 class="text-2xl font-bold">Manajemen Pelamar</h2>
            <p class="text-slate-500">Tinjau profil talenta yang melamar ke lowongan Anda.</p>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Pelamar</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Posisi</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 text-center">Status
                        </th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 text-right">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($applicants as $app)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined">person</span>
                                    </div>
                                    <div>
                                        <span
                                            class="font-bold text-slate-900 dark:text-white block">{{ $app->talent->nama_lengkap }}</span>
                                        <span
                                            class="text-[10px] text-slate-500 uppercase font-bold">{{ $app->talent->pekerjaan_saat_ini ?? 'Pelamar' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ $app->lowongan->judul }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ $app->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    @php
                                        $statusClasses = [
                                            'Pending' => 'bg-amber-100 text-amber-700',
                                            'Diterima' => 'bg-emerald-100 text-emerald-700',
                                            'Ditolak' => 'bg-red-100 text-red-700',
                                            'Interview' => 'bg-blue-100 text-blue-700',
                                        ];
                                        $class = $statusClasses[$app->status] ?? 'bg-slate-100 text-slate-700';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $class }}">
                                        {{ $app->status }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right" x-data="{ open: false, showDetailModal: false, showInterviewModal: false }">
                                <div class="flex justify-end">
                                    <div class="relative">
                                        <button @click="open = !open" @click.away="open = false"
                                            class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors text-slate-400 group">
                                            <span
                                                class="material-symbols-outlined group-hover:text-primary transition-colors">more_vert</span>
                                        </button>

                                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl z-30 overflow-hidden"
                                            style="display: none;">
                                            <div class="py-2">
                                                <div
                                                    class="px-4 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                                    Navigasi</div>
                                                <button @click="showDetailModal = true; open = false"
                                                    class="w-full flex items-center gap-3 px-4 py-2 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors text-sm font-medium text-slate-700 dark:text-slate-300">
                                                    <span class="material-symbols-outlined text-primary text-[20px]">visibility</span>
                                                    Lihat Detail & CV
                                                </button>
                                                <a href="{{ route('messages.show', $app->talent->user_id) }}"
                                                    class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors text-sm font-medium text-slate-700 dark:text-slate-300">
                                                    <span class="material-symbols-outlined text-primary text-[20px]">chat</span>
                                                    Kirim Pesan
                                                </a>

                                                <div class="h-px bg-slate-100 dark:bg-slate-700 my-2"></div>
                                                <div
                                                    class="px-4 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                                    Aksi Status</div>

                                                <button @click="showInterviewModal = true; open = false"
                                                    class="w-full flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors text-sm font-medium text-blue-600">
                                                    <span class="material-symbols-outlined text-[20px]">event_note</span>
                                                    Jadwalkan Wawancara
                                                </button>

                                                <form action="{{ route('umkm.applicants.status', $app->id_lamaran) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Diterima">
                                                    <button type="submit"
                                                        class="w-full flex items-center gap-3 px-4 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors text-sm font-medium text-emerald-600">
                                                        <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                                        Terima Pelamar
                                                    </button>
                                                </form>

                                                <form action="{{ route('umkm.applicants.status', $app->id_lamaran) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Ditolak">
                                                    <button type="submit"
                                                        class="w-full flex items-center gap-3 px-4 py-2 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors text-sm font-medium text-red-600">
                                                        <span class="material-symbols-outlined text-[20px]">cancel</span>
                                                        Tolak Pelamar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail Modal -->
                                <div x-show="showDetailModal" ...>
                                    <!-- (Existing Detail Modal Content - truncated for brevity in instruction but I will keep it in reality, wait, replace_file_content replaces the whole block. I need to be careful not to delete the existing modal. I will reuse the previous block and append the new modal.) -->
                                </div>

                                <!-- Detail Modal -->
                                <div x-show="showDetailModal"
                                    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm text-left"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    style="display: none;" x-cloak>
                                    
                                    <div @click.away="showDetailModal = false"
                                        class="bg-white dark:bg-slate-900 rounded-[32px] w-full max-w-4xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                                        
                                        <!-- Header -->
                                        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-white/80 dark:bg-slate-900/80 backdrop-blur-md z-10">
                                            <div>
                                                <h3 class="text-xl font-black text-slate-900 dark:text-white">Detail Pelamar</h3>
                                                <p class="text-slate-500 text-sm">Review data lengkap dan CV pelamar.</p>
                                            </div>
                                            <button @click="showDetailModal = false" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                                                <span class="material-symbols-outlined">close</span>
                                            </button>
                                        </div>

                                        <div class="flex-1 overflow-y-auto p-6 md:p-8 space-y-8">
                                            <!-- Profile Summary -->
                                            <div class="flex gap-6 items-start">
                                                <div class="size-20 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0 overflow-hidden">
                                                    @if($app->talent->foto)
                                                        <img src="{{ asset('storage/' . $app->talent->foto) }}" alt="{{ $app->talent->nama_lengkap }}" class="w-full h-full object-cover">
                                                    @else
                                                        <span class="material-symbols-outlined text-4xl text-slate-400">person</span>
                                                    @endif
                                                </div>
                                                <div class="space-y-1 flex-1">
                                                    <h4 class="text-2xl font-black text-slate-900 dark:text-white">{{ $app->talent->nama_lengkap }}</h4>
                                                    <p class="text-slate-500 dark:text-slate-400 font-medium">{{ $app->talent->pekerjaan_saat_ini ?? 'Belum ada posisi' }}</p>
                                                    
                                                    <div class="flex flex-wrap gap-4 mt-3 text-sm text-slate-600 dark:text-slate-400">
                                                        <div class="flex items-center gap-1.5 bg-slate-50 dark:bg-slate-800 px-3 py-1 rounded-lg">
                                                            <span class="material-symbols-outlined text-lg text-primary">email</span>
                                                            {{ $app->talent->user?->email }}
                                                        </div>
                                                        <div class="flex items-center gap-1.5 bg-slate-50 dark:bg-slate-800 px-3 py-1 rounded-lg">
                                                            <span class="material-symbols-outlined text-lg text-primary">call</span>
                                                            {{ $app->talent->telepon ?? '-' }}
                                                        </div>
                                                        @if($app->talent->umur)
                                                        <div class="flex items-center gap-1.5 bg-slate-50 dark:bg-slate-800 px-3 py-1 rounded-lg">
                                                            <span class="material-symbols-outlined text-lg text-primary">cake</span>
                                                            {{ $app->talent->umur }} Tahun
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Personal Details Grid -->
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                                                    <p class="text-[10px] font-bold uppercase text-slate-400 mb-1">Jenis Kelamin</p>
                                                    <p class="font-bold text-slate-700 dark:text-slate-200">{{ $app->talent->jenis_kelamin ?? '-' }}</p>
                                                </div>
                                                <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                                                    <p class="text-[10px] font-bold uppercase text-slate-400 mb-1">Status Pernikahan</p>
                                                    <p class="font-bold text-slate-700 dark:text-slate-200">{{ $app->talent->status_pernikahan ?? '-' }}</p>
                                                </div>
                                                <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                                                    <p class="text-[10px] font-bold uppercase text-slate-400 mb-1">Lokasi</p>
                                                    <p class="font-bold text-slate-700 dark:text-slate-200">{{ Str::limit($app->talent->alamat, 30) ?? '-' }}</p>
                                                </div>
                                            </div>

                                            <!-- About & Skills -->
                                            <div class="space-y-6">
                                                @if($app->talent->deskripsi)
                                                <div>
                                                    <h5 class="font-bold text-slate-900 dark:text-white mb-2 flex items-center gap-2">
                                                        <span class="material-symbols-outlined text-primary text-lg">info</span>
                                                        Tentang Saya
                                                    </h5>
                                                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">{{ $app->talent->deskripsi }}</p>
                                                </div>
                                                @endif

                                                @if($app->talent->skill)
                                                <div>
                                                    <h5 class="font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                                                        <span class="material-symbols-outlined text-primary text-lg">stars</span>
                                                        Keahlian / Skills
                                                    </h5>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach(explode(';', $app->talent->skill) as $skill)
                                                            @if(trim($skill))
                                                                <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-bold border border-blue-100 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800">
                                                                    {{ trim($skill) }}
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @endif
                                            </div>

                                            <div class="h-px bg-slate-100 dark:bg-slate-800"></div>

                                            <!-- Education & Experience -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                                <!-- Experience -->
                                                <div>
                                                    <h5 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                                        <span class="material-symbols-outlined text-primary text-lg">work_history</span>
                                                        Pengalaman Kerja
                                                    </h5>
                                                    <div class="space-y-4">
                                                        @if($app->talent->pengalaman_kerja)
                                                            @foreach(explode(';', $app->talent->pengalaman_kerja) as $exp)
                                                                @if(trim($exp))
                                                                    <div class="flex gap-3">
                                                                        <div class="mt-1 size-8 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center shrink-0">
                                                                            <span class="material-symbols-outlined text-lg">business_center</span>
                                                                        </div>
                                                                        <div class="text-sm">
                                                                            <p class="text-slate-700 dark:text-slate-200 font-medium leading-relaxed">{{ trim($exp) }}</p>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <p class="text-sm text-slate-400 italic">Belum ada data pengalaman.</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Education -->
                                                <div>
                                                    <h5 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                                        <span class="material-symbols-outlined text-primary text-lg">school</span>
                                                        Pendidikan
                                                    </h5>
                                                    <div class="space-y-4">
                                                        @if($app->talent->pendidikan_terakhir)
                                                            @foreach(explode(';', $app->talent->pendidikan_terakhir) as $edu)
                                                                @if(trim($edu))
                                                                    <div class="flex gap-3">
                                                                        <div class="mt-1 size-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                                                            <span class="material-symbols-outlined text-lg">school</span>
                                                                        </div>
                                                                        <div class="text-sm">
                                                                            <p class="text-slate-700 dark:text-slate-200 font-medium leading-relaxed">{{ trim($edu) }}</p>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <p class="text-sm text-slate-400 italic">Belum ada data pendidikan.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="h-px bg-slate-100 dark:bg-slate-800"></div>

                                            <!-- Test Skill Results -->
                                            @if($app->talent->user && $app->talent->user->hasilTes->count() > 0)
                                            <div>
                                                <h5 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-primary text-lg">quiz</span>
                                                    Hasil Tes Skill
                                                </h5>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                                    @foreach($app->talent->user->hasilTes as $hasil)
                                                        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-4 flex items-center justify-between hover:shadow-md transition-shadow">
                                                            <div>
                                                                <h6 class="font-bold text-slate-900 dark:text-white text-sm mb-1">
                                                                    {{ $hasil->kategori ? $hasil->kategori->nama_kategori : 'Unknown Skill' }}
                                                                </h6>
                                                                <p class="text-xs text-slate-500">
                                                                    {{ $hasil->created_at->format('d M Y') }}
                                                                </p>
                                                            </div>
                                                            <div class="text-right">
                                                                <div class="text-xl font-black text-primary">{{ $hasil->skor }}</div>
                                                                <div class="text-[10px] uppercase font-bold text-slate-400">Nilai</div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="h-px bg-slate-100 dark:bg-slate-800"></div>
                                            @endif

                                            <!-- Certificates -->
                                            @if($app->talent->user && $app->talent->user->sertifikats->count() > 0)
                                            <div>
                                                <h5 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-primary text-lg">workspace_premium</span>
                                                    Sertifikat & Lisensi
                                                </h5>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                                    @foreach($app->talent->user->sertifikats as $sertifikat)
                                                        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-4 hover:shadow-md transition-shadow group">
                                                            <div class="flex items-start justify-between mb-2">
                                                                <div class="size-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                                                    <span class="material-symbols-outlined">verified</span>
                                                                </div>
                                                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full tracking-wider
                                                                    @if(strtolower($sertifikat->status) == 'verified' || strtolower($sertifikat->status) == 'valid') bg-emerald-100 text-emerald-700 
                                                                    @elseif(strtolower($sertifikat->status) == 'pending') bg-amber-100 text-amber-700 
                                                                    @else bg-rose-100 text-rose-700 @endif">
                                                                    {{ $sertifikat->status }}
                                                                </span>
                                                            </div>
                                                            <h6 class="font-bold text-slate-900 dark:text-white line-clamp-2 text-sm mb-1" title="{{ $sertifikat->nama_sertifikat }}">
                                                                {{ $sertifikat->nama_sertifikat }}
                                                            </h6>
                                                            <p class="text-xs text-slate-500 line-clamp-1 mb-3">{{ $sertifikat->penerbit }}</p>
                                                            
                                                            <div class="flex items-center justify-between mt-auto pt-3 border-t border-slate-100 dark:border-slate-700">
                                                                <span class="text-[10px] text-slate-400 font-medium">{{ \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->format('M Y') }}</span>
                                                                @if(strtolower($sertifikat->status) == 'verified' || strtolower($sertifikat->status) == 'valid')
                                                                    <a href="{{ route('certificate.verify', $sertifikat->id_sertifikat) }}" target="_blank" class="text-xs text-primary font-bold hover:underline flex items-center gap-1">
                                                                        Lihat <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Socials -->
                                            @if($app->talent->linkedin || $app->talent->portfolio || $app->talent->hobi)
                                            <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl flex flex-wrap gap-6 text-sm">
                                                @if($app->talent->linkedin)
                                                    <a href="{{ $app->talent->linkedin }}" target="_blank" class="flex items-center gap-2 text-slate-600 hover:text-primary transition-colors font-medium">
                                                        <span class="material-symbols-outlined">link</span>
                                                        LinkedIn Profile
                                                    </a>
                                                @endif
                                                @if($app->talent->portfolio)
                                                    <a href="{{ $app->talent->portfolio }}" target="_blank" class="flex items-center gap-2 text-slate-600 hover:text-primary transition-colors font-medium">
                                                        <span class="material-symbols-outlined">captive_portal</span>
                                                        Portfolio Link
                                                    </a>
                                                @endif
                                                @if($app->talent->hobi)
                                                    <div class="flex items-center gap-2 text-slate-600">
                                                        <span class="material-symbols-outlined">interests</span>
                                                        <span class="font-medium">Hobi:</span> {{ $app->talent->hobi }}
                                                    </div>
                                                @endif
                                            </div>
                                            @endif
                                            
                                            <div class="h-px bg-slate-100 dark:bg-slate-800"></div>

                                            <!-- Cover Letter -->
                                            <div>
                                                <h5 class="font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-primary">description</span>
                                                    Cover Letter
                                                </h5>
                                                <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-2xl text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line text-sm">
                                                    {{ $app->cover_letter }}
                                                </div>
                                            </div>

                                            <!-- CV Viewer -->
                                            <div>
                                                <div class="flex items-center justify-between mb-3">
                                                    <h5 class="font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                                        <span class="material-symbols-outlined text-primary">picture_as_pdf</span>
                                                        CV / Resume
                                                    </h5>
                                                    @if($app->cv_path)
                                                        <a href="{{ asset('storage/' . $app->cv_path) }}" target="_blank" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                                                            Buka di Tab Baru <span class="material-symbols-outlined text-sm">open_in_new</span>
                                                        </a>
                                                    @endif
                                                </div>
                                                
                                                @if($app->cv_path)
                                                    <div class="bg-slate-100 dark:bg-slate-800 rounded-2xl overflow-hidden h-[500px] border border-slate-200 dark:border-slate-700">
                                                        <iframe src="{{ asset('storage/' . $app->cv_path) }}" class="w-full h-full" frameborder="0"></iframe>
                                                    </div>
                                                @else
                                                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl h-32 flex flex-col items-center justify-center text-slate-400 border-2 border-dashed border-slate-200 dark:border-slate-700">
                                                        <span class="material-symbols-outlined text-3xl mb-1">sentiment_dissatisfied</span>
                                                        <p class="text-sm font-bold">Pelamar tidak menyertakan CV</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Interview Modal -->
                                <div x-show="showInterviewModal"
                                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm text-left"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     style="display: none;" x-cloak>
                                    
                                    <div @click.away="showInterviewModal = false"
                                        class="bg-white dark:bg-slate-900 rounded-[32px] w-full max-w-lg shadow-2xl flex flex-col"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                                        
                                        <!-- Header -->
                                        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-white/80 dark:bg-slate-900/80 backdrop-blur-md z-10 rounded-t-[32px]">
                                            <div>
                                                <h3 class="text-xl font-black text-slate-900 dark:text-white">Jadwalkan Wawancara</h3>
                                                <p class="text-slate-500 text-sm">Pelamar: <span class="font-bold text-primary">{{ $app->talent->nama_lengkap }}</span></p>
                                            </div>
                                            <button @click="showInterviewModal = false" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                                                <span class="material-symbols-outlined">close</span>
                                            </button>
                                        </div>

                                        <!-- Form -->
                                        <form action="{{ route('umkm.applicants.schedule', $app->id_lamaran) }}" method="POST" class="p-6 md:p-8 space-y-6">
                                            @csrf
                                            
                                            <div class="grid grid-cols-2 gap-6">
                                                <div class="space-y-2">
                                                    <label class="text-xs font-bold uppercase text-slate-500">Tanggal</label>
                                                    <input type="date" name="tanggal" required min="{{ date('Y-m-d') }}"
                                                        class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl font-bold text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-primary">
                                                </div>
                                                <div class="space-y-2">
                                                    <label class="text-xs font-bold uppercase text-slate-500">Jam</label>
                                                    <input type="time" name="jam" required
                                                        class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl font-bold text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-primary">
                                                </div>
                                            </div>

                                            <div class="space-y-2">
                                                <label class="text-xs font-bold uppercase text-slate-500">Lokasi / Link Meeting</label>
                                                <input type="text" name="lokasi" required placeholder="Contoh: Kantor Pusat Lt. 2 / Google Meet Link"
                                                    class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl font-bold text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-primary">
                                            </div>

                                            <div class="space-y-2">
                                                <label class="text-xs font-bold uppercase text-slate-500">Catatan / Deskripsi</label>
                                                <textarea name="deskripsi" rows="3" required placeholder="Bawa CV fisik dan berpakaian rapi..."
                                                    class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl font-medium text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-primary"></textarea>
                                            </div>

                                            <div class="pt-2 flex justify-end gap-3">
                                                <button type="button" @click="showInterviewModal = false"
                                                    class="px-6 py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-200 transition-colors">
                                                    Batal
                                                </button>
                                                <button type="submit"
                                                    class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/30 flex items-center gap-2">
                                                    <span class="material-symbols-outlined">send</span>
                                                    Kirim Undangan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <span class="material-symbols-outlined text-4xl opacity-10 mb-2">group_off</span>
                                <p class="text-slate-500 font-medium">Belum ada pelamar saat ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection