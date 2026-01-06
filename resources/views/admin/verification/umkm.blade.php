@extends('layouts.dashboard')

@section('title', 'Verifikasi UMKM - Digital Skill Passport')

@section('header_title', 'Verifikasi UMKM')

@section('sidebar')
    @include('layouts.partials.sidebar-admin')
@endsection

@section('content')
    <div class="space-y-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Verifikasi Akun UMKM</h2>
            <p class="text-slate-500">Tinjau dan validasi pendaftaran akun instansi baru.</p>
        </div>

        @if(session('success'))
            <div x-data="{ show: true }" 
                 x-init="setTimeout(() => show = false, 3000)" 
                 x-show="show" 
                 x-transition.duration.500ms
                 class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div x-data="{ 
                        showRejectModal: false, 
                        showApproveModal: false,
                        rejectAction: '', 
                        approveAction: '',
                        umkmName: '',
                        openReject(id, name) {
                            this.umkmName = name;
                            this.rejectAction = `{{ url('/admin/verification/umkm') }}/${id}/reject`;
                            this.showRejectModal = true;
                        },
                        openApprove(id, name) {
                            this.umkmName = name;
                            this.approveAction = `{{ url('/admin/verification/umkm') }}/${id}/approve`;
                            this.showApproveModal = true;
                        }
                    }"
            class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Instansi</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Alamat</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Tanggal Daftar</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 text-center">Status
                        </th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 text-right">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($umkms as $umkm)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined">business</span>
                                    </div>
                                    <div>
                                        <span
                                            class="font-bold text-slate-900 dark:text-white block">{{ $umkm->nama_umkm }}</span>
                                        <span class="text-xs text-slate-500">{{ $umkm->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-600 dark:text-slate-400 line-clamp-1">{{ $umkm->alamat }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ $umkm->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-amber-100 text-amber-700',
                                            'verified' => 'bg-emerald-100 text-emerald-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                            'Pending' => 'bg-amber-100 text-amber-700',
                                            'Terverifikasi' => 'bg-emerald-100 text-emerald-700',
                                            'Ditolak' => 'bg-red-100 text-red-700',
                                        ];

                                        $statusLabels = [
                                            'pending' => 'Pending',
                                            'verified' => 'Terverifikasi',
                                            'rejected' => 'Ditolak',
                                            'Pending' => 'Pending',
                                            'Terverifikasi' => 'Terverifikasi',
                                            'Ditolak' => 'Ditolak',
                                        ];

                                        $rawStatus = $umkm->status_verifikasi ?? 'pending';
                                        $class = $statusClasses[$rawStatus] ?? 'bg-slate-100 text-slate-700';
                                        $label = $statusLabels[$rawStatus] ?? $rawStatus;
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $class }}">
                                        {{ $label }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right" x-data="{ showDetailModal: false }">
                                <div class="flex justify-end gap-2">
                                    <button @click="showDetailModal = true"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Lihat Detail & Dokumen">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </button>

                                    <a href="{{ route('messages.show', $umkm->user_id) }}"
                                        class="p-2 text-primary hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Chat Pemilik">
                                        <span class="material-symbols-outlined">chat</span>
                                    </a>

                                    @if($umkm->status_verifikasi != 'Terverifikasi')
                                        <button @click="openApprove('{{ $umkm->id_umkm }}', '{{ addslashes($umkm->nama_umkm) }}')"
                                            class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors"
                                            title="Setujui">
                                            <span class="material-symbols-outlined">check_circle</span>
                                        </button>
                                        <button @click="openReject('{{ $umkm->id_umkm }}', '{{ addslashes($umkm->nama_umkm) }}')"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Tolak">
                                            <span class="material-symbols-outlined">cancel</span>
                                        </button>
                                    @endif
                                </div>

                                <!-- Detail Modal -->
                                <template x-teleport="body">
                                    <div x-show="showDetailModal"
                                        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm text-left"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        style="display: none;" x-cloak>
                                        
                                        <div @click.away="showDetailModal = false"
                                            class="bg-white dark:bg-slate-900 rounded-[32px] w-full max-w-5xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                            x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                                            
                                            <!-- Header -->
                                            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-white/80 dark:bg-slate-900/80 backdrop-blur-md z-10">
                                                <div>
                                                    <h3 class="text-xl font-black text-slate-900 dark:text-white">Detail UMKM</h3>
                                                    <p class="text-slate-500 text-sm">Informasi lengkap dan dokumen verifikasi.</p>
                                                </div>
                                                <button @click="showDetailModal = false" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                                                    <span class="material-symbols-outlined">close</span>
                                                </button>
                                            </div>

                                            <div class="flex-1 overflow-y-auto p-6 md:p-8 space-y-8">
                                                <!-- Profile Info -->
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                                    <!-- Basic Info -->
                                                    <div class="md:col-span-1 space-y-6">
                                                        <div class="text-center md:text-left">
                                                            <div class="size-24 rounded-2xl bg-slate-100 dark:bg-slate-800 mx-auto md:mx-0 flex items-center justify-center mb-4 overflow-hidden border border-slate-200 dark:border-slate-700">
                                                                @if($umkm->logo)
                                                                    <img src="{{ asset('storage/' . $umkm->logo) }}" alt="Logo" class="w-full h-full object-cover">
                                                                @else
                                                                    <span class="material-symbols-outlined text-4xl text-slate-400">business</span>
                                                                @endif
                                                            </div>
                                                            <h4 class="text-xl font-bold text-slate-900 dark:text-white">{{ $umkm->nama_umkm }}</h4>
                                                            <p class="text-slate-500 text-sm">{{ $umkm->user->email }}</p>
                                                        </div>

                                                        <div class="space-y-4 divide-y divide-slate-100 dark:divide-slate-800">
                                                            <div class="pt-4 first:pt-0">
                                                                <p class="text-xs font-bold uppercase text-slate-400 mb-1">Info Bisnis</p>
                                                                <div class="space-y-2">
                                                                     <div class="flex justify-between text-sm">
                                                                        <span class="text-slate-500">Pemilik</span>
                                                                        <span class="font-medium text-slate-900 dark:text-white">{{ $umkm->user->name ?? '-' }}</span>
                                                                    </div>
                                                                     <div class="flex justify-between text-sm">
                                                                        <span class="text-slate-500">Kategori</span>
                                                                        <span class="font-medium text-slate-900 dark:text-white">{{ $umkm->kategori ?? '-' }}</span>
                                                                    </div>
                                                                    <div class="flex justify-between text-sm">
                                                                        <span class="text-slate-500">Skala</span>
                                                                        <span class="font-medium text-slate-900 dark:text-white">{{ $umkm->skala_usaha ?? '-' }}</span>
                                                                    </div>
                                                                    <div class="flex justify-between text-sm">
                                                                        <span class="text-slate-500">Berdiri</span>
                                                                        <span class="font-medium text-slate-900 dark:text-white">{{ $umkm->tahun_berdiri ?? '-' }}</span>
                                                                    </div>
                                                                    <div class="flex justify-between text-sm">
                                                                        <span class="text-slate-500">Karyawan</span>
                                                                        <span class="font-medium text-slate-900 dark:text-white">{{ $umkm->jumlah_karyawan ?? '-' }}</span>
                                                                    </div>
                                                                    <div class="flex justify-between text-sm">
                                                                        <span class="text-slate-500">Legalitas (NPWP)</span>
                                                                        <span class="font-medium text-slate-900 dark:text-white">{{ $umkm->npwp ?? '-' }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="pt-4">
                                                                <p class="text-xs font-bold uppercase text-slate-400 mb-1">Penanggung Jawab</p>
                                                                @if($umkm->nama_penanggung_jawab)
                                                                    <p class="font-medium text-slate-900 dark:text-white text-sm">{{ $umkm->nama_penanggung_jawab }}</p>
                                                                    <p class="text-xs text-slate-500">{{ $umkm->jabatan_penanggung_jawab ?? 'Jabatan tidak info' }}</p>
                                                                @else
                                                                    <p class="text-sm italic text-slate-500">Data tidak tersedia</p>
                                                                @endif
                                                            </div>

                                                            <div class="pt-4">
                                                                <p class="text-xs font-bold uppercase text-slate-400 mb-1">Kontak & Media Sosial</p>
                                                                <div class="space-y-2 mt-2">
                                                                     @if($umkm->website)
                                                                        <a href="{{ $umkm->website }}" target="_blank" class="flex items-center gap-2 text-sm text-blue-600 hover:underline">
                                                                            <span class="material-symbols-outlined text-[16px]">public</span> Website
                                                                        </a>
                                                                    @endif
                                                                    @if($umkm->email_instansi)
                                                                         <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                                                            <span class="material-symbols-outlined text-[16px]">mail</span> {{ $umkm->email_instansi }}
                                                                        </div>
                                                                    @endif
                                                                    @if($umkm->instagram)
                                                                        <a href="{{ $umkm->instagram }}" target="_blank" class="flex items-center gap-2 text-sm text-pink-600 hover:underline">
                                                                             <span class="material-symbols-outlined text-[16px]">photo_camera</span> Instagram
                                                                        </a>
                                                                    @endif
                                                                    @if($umkm->tiktok)
                                                                        <a href="{{ $umkm->tiktok }}" target="_blank" class="flex items-center gap-2 text-sm text-slate-900 dark:text-white hover:underline">
                                                                             <span class="material-symbols-outlined text-[16px]">music_note</span> TikTok
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            
                                                             <div class="pt-4">
                                                                <p class="text-xs font-bold uppercase text-slate-400 mb-1">Alamat Kantor</p>
                                                                <p class="font-medium text-sm text-slate-700 dark:text-slate-300 leading-relaxed">{{ $umkm->alamat ?? '-' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Description & Document -->
                                                    <div class="md:col-span-2 space-y-8">
                                                        <div>
                                                            <h5 class="font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                                                                <span class="material-symbols-outlined text-primary">notes</span>
                                                                Tentang Instansi
                                                            </h5>
                                                            <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-2xl text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line text-sm border border-slate-100 dark:border-slate-800/50">
                                                                {{ $umkm->deskripsi ?? 'Tidak ada deskripsi.' }}
                                                            </div>
                                                        </div>

                                                        <!-- Gallery Preview -->
                                                        @if($umkm->galeri && count(json_decode($umkm->galeri)) > 0)
                                                        <div>
                                                            <h5 class="font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                                                                <span class="material-symbols-outlined text-primary">photo_library</span>
                                                                Galeri Foto
                                                            </h5>
                                                            <div class="grid grid-cols-4 gap-2">
                                                                @foreach(json_decode($umkm->galeri) as $img)
                                                                    <a href="{{ asset('storage/' . $img) }}" target="_blank" class="aspect-square rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 hover:opacity-80 transition-opacity">
                                                                        <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        @endif

                                                        <div>
                                                            <div class="flex items-center justify-between mb-3">
                                                                <h5 class="font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                                                    <span class="material-symbols-outlined text-primary">verified</span>
                                                                    Dokumen Verifikasi
                                                                </h5>
                                                                @if($umkm->dokumen_verifikasi)
                                                                    <a href="{{ asset('storage/' . $umkm->dokumen_verifikasi) }}" target="_blank" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                                                                        Buka di Tab Baru <span class="material-symbols-outlined text-sm">open_in_new</span>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            
                                                            @if($umkm->dokumen_verifikasi)
                                                                <div class="bg-slate-100 dark:bg-slate-800 rounded-2xl overflow-hidden h-[500px] border border-slate-200 dark:border-slate-700 relative group">
                                                                    @php
                                                                        $extension = pathinfo($umkm->dokumen_verifikasi, PATHINFO_EXTENSION);
                                                                    @endphp
                                                                    
                                                                    @if(in_array(strtolower($extension), ['pdf']))
                                                                        <iframe src="{{ asset('storage/' . $umkm->dokumen_verifikasi) }}" class="w-full h-full" frameborder="0"></iframe>
                                                                    @elseif(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']))
                                                                         <div class="w-full h-full flex items-center justify-center bg-black/5">
                                                                            <img src="{{ asset('storage/' . $umkm->dokumen_verifikasi) }}" class="max-w-full max-h-full object-contain">
                                                                         </div>
                                                                    @else
                                                                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                                                            <span class="material-symbols-outlined text-5xl mb-2">description</span>
                                                                            <p class="font-bold">Format file tidak didukung untuk pratinjau.</p>
                                                                            <a href="{{ asset('storage/' . $umkm->dokumen_verifikasi) }}" class="mt-4 px-4 py-2 bg-primary text-white rounded-xl font-bold text-sm">Download File</a>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl h-32 flex flex-col items-center justify-center text-slate-400 border-2 border-dashed border-slate-200 dark:border-slate-700">
                                                                    <span class="material-symbols-outlined text-3xl mb-1">folder_off</span>
                                                                    <p class="text-sm font-bold">UMKM beum mengunggah dokumen verifikasi</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                Tidak ada permohonan verifikasi saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Alpine-powered Reject Modal -->
            <div x-show="showRejectModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                <div @click.away="showRejectModal = false"
                    class="bg-white dark:bg-slate-900 rounded-2xl p-8 max-w-md w-full shadow-2xl transform transition-all"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">

                    <div class="flex items-center gap-3 mb-4 text-red-600">
                        <span class="material-symbols-outlined text-3xl">warning</span>
                        <h3 class="text-xl font-bold">Tolak Verifikasi</h3>
                    </div>

                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                        Anda akan menolak verifikasi untuk <span class="font-bold text-slate-900 dark:text-white"
                            x-text="umkmName"></span>. Berikan alasan penolakan di bawah ini.
                    </p>

                    <form :action="rejectAction" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Alasan
                                Penolakan</label>
                            <textarea name="catatan" rows="4" required
                                class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-950 focus:ring-primary text-sm"
                                placeholder="Contoh: Dokumen tidak lengkap atau data tidak valid..."></textarea>
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" @click="showRejectModal = false"
                                class="px-6 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-xl font-bold text-sm hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">Batal</button>
                            <button type="submit"
                                class="px-6 py-2.5 bg-red-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-red-500/30 hover:bg-red-700 transition-colors">Tolak
                                Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Alpine-powered Approve Modal -->
            <div x-show="showApproveModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                <div @click.away="showApproveModal = false"
                    class="bg-white dark:bg-slate-900 rounded-2xl p-8 max-w-md w-full shadow-2xl transform transition-all"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">

                    <div class="flex items-center gap-3 mb-4 text-emerald-600">
                        <span class="material-symbols-outlined text-3xl">verified</span>
                        <h3 class="text-xl font-bold">Setujui Verifikasi</h3>
                    </div>

                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                        Apakah Anda yakin ingin menyetujui verifikasi untuk instansi <span class="font-bold text-slate-900 dark:text-white"
                            x-text="umkmName"></span>?
                        <br><br>
                        <span class="text-xs bg-emerald-50 text-emerald-700 px-2 py-1 rounded-lg border border-emerald-100 block">
                            <span class="font-bold">Info:</span> Pesan notifikasi otomatis akan dikirim ke pengguna.
                        </span>
                    </p>

                    <form :action="approveAction" method="POST">
                        @csrf
                        <div class="flex justify-end gap-3">
                            <button type="button" @click="showApproveModal = false"
                                class="px-6 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-xl font-bold text-sm hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">Batal</button>
                            <button type="submit"
                                class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-emerald-500/30 hover:bg-emerald-700 transition-colors">
                                Ya, Setujui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection