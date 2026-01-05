@extends('layouts.dashboard')

@section('title', 'Sertifikat Saya - Digital Skill Passport')

@section('header_title', 'Sertifikat')

@section('sidebar')
    @include('layouts.partials.sidebar-talent')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
             // Optional: if specific Alpine logic outside usage is needed
        });

        function generateQRCode(url) {
            const container = document.getElementById('modal-qrcode');
            if (container && url) {
                // Clear previous
                container.innerHTML = '';
                const canvas = document.createElement('canvas');
                container.appendChild(canvas);
                
                QRCode.toCanvas(canvas, url, {
                    width: 200,
                    margin: 1,
                    color: {
                        dark: '#000000',
                        light: '#ffffff'
                    }
                }, function (error) {
                    if (error) console.error(error)
                });
            }
        }
    </script>
@endpush

@section('content')
    <div class="space-y-6" x-data="{ 
                        showAddModal: false, 
                        showEditModal: false, 
                        showDeleteModal: false,
                        showDetailModal: false,
                        selectedCert: '',
                        viewData: {
                            name: '',
                            issuer: '',
                            date: '',
                            desc: '',
                            status: '',
                            fileUrl: '',
                            fileExt: '',
                            verifyUrl: ''
                        },
                        editData: {
                            id: '',
                            nama_sertifikat: '',
                            penerbit: '',
                            tanggal_terbit: '',
                            deskripsi: ''
                        }
                    }">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold">Koleksi Sertifikat</h2>
                <p class="text-slate-500 text-sm">Kelola dan tampilkan bukti keahlian profesional Anda.</p>
            </div>
            <button @click="showAddModal = true"
                class="px-6 py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/30 flex items-center gap-2">
                <span class="material-symbols-outlined">add_circle</span>
                Unggah Sertifikat
            </button>
        </div>

        @if(session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition.duration.500ms
                class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-100 border border-rose-400 text-rose-700 px-4 py-3 rounded-xl relative" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($certificates as $cert)
                @php
                    $ext = pathinfo($cert->file_path, PATHINFO_EXTENSION);
                    $verifyUrl = route('certificate.verify', ['id' => $cert->id]);
                    $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']);
                @endphp
                <div @click="
                        viewData = {
                            name: '{{ e($cert->nama_sertifikat) }}',
                            issuer: '{{ e($cert->penerbit) }}',
                            date: '{{ \Carbon\Carbon::parse($cert->tanggal_terbit)->format('d F Y') }}',
                            desc: '{{ e($cert->deskripsi) }}',
                            status: '{{ $cert->status }}',
                            fileUrl: '{{ asset('storage/' . $cert->file_path) }}',
                            fileExt: '{{ $ext }}',
                            isImage: {{ $isImage ? 'true' : 'false' }},
                            verifyUrl: '{{ $verifyUrl }}'
                        };
                        showDetailModal = true;
                        // Delay slightly to allow modal to render before canvas generation
                        setTimeout(() => generateQRCode(viewData.verifyUrl), 50);
                     "
                    class="bg-white dark:bg-slate-800 rounded-3xl overflow-hidden shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all group relative cursor-pointer flex flex-col h-full">
                    
                    <!-- Dropdown Menu (Stop Propagation) -->
                    <div class="absolute top-4 right-4 z-10" x-data="{ open: false }" @click.stop>
                        <button @click="open = !open"
                            class="p-2 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md rounded-full shadow-lg hover:bg-white dark:hover:bg-slate-800 transition-all">
                            <span class="material-symbols-outlined text-slate-700 dark:text-slate-300">more_vert</span>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
                            <button @click='
                                        editData = {
                                            id: "{{ $cert->id }}",
                                            nama_sertifikat: "{{ e($cert->nama_sertifikat) }}",
                                            penerbit: "{{ e($cert->penerbit) }}",
                                            tanggal_terbit: "{{ $cert->tanggal_terbit }}",
                                            deskripsi: "{{ e($cert->deskripsi) }}"
                                        };
                                        showEditModal = true;
                                        open = false;
                                    '
                                class="w-full flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all text-left">
                                <span class="material-symbols-outlined text-amber-500 text-xl">edit</span>
                                Edit Data
                            </button>
                            <button @click="selectedCert = {{ $cert->id }}; showDeleteModal = true; open = false;"
                                class="w-full flex items-center gap-3 px-4 py-3 text-sm text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/30 transition-all text-left">
                                <span class="material-symbols-outlined text-xl">delete</span>
                                Hapus
                            </button>
                        </div>
                    </div>

                    <!-- Certificate Image/Preview -->
                    <div class="h-52 bg-slate-100 dark:bg-slate-900 flex items-center justify-center relative group-hover:scale-105 transition-transform duration-500 overflow-hidden shrink-0">
                        @if($isImage)
                            <img src="{{ asset('storage/' . $cert->file_path) }}" alt="{{ $cert->nama_sertifikat }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="text-center">
                                <span class="material-symbols-outlined text-6xl text-primary/30">description</span>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mt-2">{{ $ext }} Document</p>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                            <span class="text-white text-xs font-bold">{{ $cert->penerbit }}</span>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-slate-900 dark:text-white line-clamp-1 text-lg group-hover:text-primary transition-colors">
                                {{ $cert->nama_sertifikat }}
                            </h3>
                        </div>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-slate-400 text-sm">business</span>
                            <p class="text-sm text-slate-500">{{ $cert->penerbit }}</p>
                        </div>
                         <div class="mt-auto pt-4 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between">
                            <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full tracking-wider
                                        @if(strtolower($cert->status) == 'verified' || strtolower($cert->status) == 'terverifikasi' || strtolower($cert->status) == 'valid') bg-emerald-100 text-emerald-700 
                                        @elseif(strtolower($cert->status) == 'pending') bg-amber-100 text-amber-700 
                                        @else bg-rose-100 text-rose-700 @endif">
                                {{ strtoupper($cert->status) }}
                            </span>
                            <span class="text-xs text-slate-400 font-medium">
                                {{ \Carbon\Carbon::parse($cert->tanggal_terbit)->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full py-20 text-center bg-white dark:bg-slate-800 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-700">
                    <span class="material-symbols-outlined text-6xl opacity-10 mb-4">workspace_premium</span>
                    <p class="text-slate-500 font-medium">Belum ada sertifikat yang diunggah.</p>
                    <button @click="showAddModal = true" class="mt-4 text-primary font-bold hover:underline">Unggah
                        sekarang</button>
                </div>
            @endforelse
        </div>

        <!-- Detail Modal -->
        <div x-show="showDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 overflow-y-auto" x-cloak>
            <div class="bg-white dark:bg-slate-800 rounded-3xl w-full max-w-4xl p-0 shadow-2xl overflow-hidden flex flex-col md:flex-row max-h-[90vh]" @click.away="showDetailModal = false">
                
                <!-- Close Button Mobile -->
                <button @click="showDetailModal = false" class="absolute top-4 right-4 p-2 bg-white/50 rounded-full md:hidden z-10">
                    <span class="material-symbols-outlined">close</span>
                </button>

                <!-- Left: Preview -->
                <div class="w-full md:w-1/2 bg-slate-100 dark:bg-slate-900 flex items-center justify-center p-8 border-b md:border-b-0 md:border-r border-slate-200 dark:border-slate-700 overflow-y-auto">
                    <template x-if="viewData.isImage">
                        <img :src="viewData.fileUrl" class="max-w-full max-h-full object-contain rounded-lg shadow-sm">
                    </template>
                    <template x-if="!viewData.isImage">
                        <div class="text-center p-8">
                            <span class="material-symbols-outlined text-9xl text-slate-300">description</span>
                            <p class="text-xl font-bold text-slate-500 mt-4 uppercase"><span x-text="viewData.fileExt"></span> Document</p>
                            <a :href="viewData.fileUrl" target="_blank" class="inline-block mt-4 text-primary hover:underline">
                                Buka File Asli
                            </a>
                        </div>
                    </template>
                </div>

                <!-- Right: Details -->
                <div class="w-full md:w-1/2 p-8 overflow-y-auto">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                             <span class="px-3 py-1 text-xs font-bold uppercase rounded-full tracking-wider"
                                :class="{
                                    'bg-emerald-100 text-emerald-700': ['verified', 'terverifikasi', 'valid'].includes(viewData.status.toLowerCase()),
                                    'bg-amber-100 text-amber-700': viewData.status.toLowerCase() === 'pending',
                                    'bg-rose-100 text-rose-700': ['ditolak', 'rejected'].includes(viewData.status.toLowerCase())
                                }" x-text="viewData.status">
                            </span>
                        </div>
                        <button @click="showDetailModal = false" class="hidden md:block p-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-full transition-colors">
                            <span class="material-symbols-outlined text-slate-400">close</span>
                        </button>
                    </div>

                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2" x-text="viewData.name"></h2>
                    <div class="flex items-center gap-2 text-slate-500 mb-6">
                        <span class="material-symbols-outlined text-sm">business</span>
                        <span class="font-medium" x-text="viewData.issuer"></span>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div>
                            <p class="text-xs uppercase text-slate-400 font-bold mb-1">Tanggal Terbit</p>
                            <p class="text-slate-700 dark:text-slate-300 font-medium" x-text="viewData.date"></p>
                        </div>
                        <div x-show="viewData.desc">
                            <p class="text-xs uppercase text-slate-400 font-bold mb-1">Deskripsi</p>
                            <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed" x-text="viewData.desc"></p>
                        </div>
                    </div>

                    <!-- QR Code Section -->
                    <template x-if="['verified', 'terverifikasi', 'valid'].includes(viewData.status.toLowerCase())">
                        <div class="pt-6 border-t border-slate-100 dark:border-slate-700">
                             <h3 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">qr_code_2</span>
                                QR Code Validasi
                            </h3>
                            <div class="bg-white p-4 rounded-xl border border-slate-200 inline-block shadow-sm">
                                <div id="modal-qrcode"></div>
                            </div>
                            <p class="text-xs text-slate-400 mt-3 leading-relaxed">
                                Scan QR Code ini untuk memverifikasi keaslian sertifikat di sistem Digital Skill Passport.
                            </p>
                             <div class="mt-4">
                                <a :href="viewData.verifyUrl" target="_blank" class="text-xs text-primary hover:underline flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">open_in_new</span>
                                    Buka Halaman Validasi
                                </a>
                            </div>
                        </div>
                    </template>
                    <template x-if="!['verified', 'terverifikasi', 'valid'].includes(viewData.status.toLowerCase())">
                         <div class="pt-6 border-t border-slate-100 dark:border-slate-700">
                            <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 flex gap-3 text-amber-800">
                                <span class="material-symbols-outlined shrink-0">info</span>
                                <p class="text-sm">QR Code validasi hanya tersedia untuk sertifikat yang telah diverifikasi (Valid).</p>
                            </div>
                        </div>
                    </template>

                </div>
            </div>
        </div>

        <!-- Add Modal -->
        <div x-show="showAddModal"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 overflow-y-auto" x-cloak>
            <div class="bg-white dark:bg-slate-800 rounded-3xl w-full max-w-lg p-8 shadow-2xl"
                @click.away="showAddModal = false">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold">Unggah Sertifikat Baru</h3>
                    <button @click="showAddModal = false"
                        class="p-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-full">
                        <span class="material-symbols-outlined text-slate-500">close</span>
                    </button>
                </div>
                <form action="{{ route('talent.certificates.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nama
                            Sertifikat</label>
                        <input type="text" name="nama_sertifikat" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Penerbit</label>
                        <input type="text" name="penerbit" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Tanggal
                            Terbit</label>
                        <input type="date" name="tanggal_terbit" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Deskripsi
                            (Opsional)</label>
                        <textarea name="deskripsi" rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">File Sertifikat
                            (PDF/JPG/PNG, Max 2MB)</label>
                        <input type="file" name="file_sertifikat" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" @click="showAddModal = false"
                            class="flex-1 px-4 py-3 border border-slate-200 dark:border-slate-700 rounded-xl font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">Batal</button>
                        <button type="submit"
                            class="flex-1 px-4 py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-all">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-show="showEditModal"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 overflow-y-auto" x-cloak>
            <div class="bg-white dark:bg-slate-800 rounded-3xl w-full max-w-lg p-8 shadow-2xl"
                @click.away="showEditModal = false">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold">Edit Sertifikat</h3>
                    <button @click="showEditModal = false"
                        class="p-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-full">
                        <span class="material-symbols-outlined text-slate-500">close</span>
                    </button>
                </div>
                <form :action="'{{ url('talent/certificates') }}/' + editData.id" method="POST"
                    enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nama
                            Sertifikat</label>
                        <input type="text" name="nama_sertifikat" x-model="editData.nama_sertifikat" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Penerbit</label>
                        <input type="text" name="penerbit" x-model="editData.penerbit" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Tanggal
                            Terbit</label>
                        <input type="date" name="tanggal_terbit" x-model="editData.tanggal_terbit" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Deskripsi
                            (Opsional)</label>
                        <textarea name="deskripsi" rows="3" x-model="editData.deskripsi"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Ganti File
                            (Opsional)</label>
                        <input type="file" name="file_sertifikat"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" @click="showEditModal = false"
                            class="flex-1 px-4 py-3 border border-slate-200 dark:border-slate-700 rounded-xl font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">Batal</button>
                        <button type="submit"
                            class="flex-1 px-4 py-3 bg-amber-500 text-white rounded-xl font-bold hover:bg-amber-600 transition-all">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Modal -->
        <div x-show="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" x-cloak>
            <div class="bg-white dark:bg-slate-800 rounded-3xl w-full max-w-sm p-8 shadow-2xl"
                @click.away="showDeleteModal = false">
                <div class="text-center">
                    <span class="material-symbols-outlined text-rose-500 text-6xl mb-4">warning</span>
                    <h3 class="text-xl font-bold mb-2">Hapus Sertifikat?</h3>
                    <p class="text-slate-500 mb-6">Tindakan ini tidak dapat dibatalkan. File sertifikat juga akan dihapus
                        secara permanen.</p>
                </div>
                <form :action="'{{ url('talent/certificates') }}/' + selectedCert" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" @click="showDeleteModal = false"
                            class="flex-1 px-4 py-3 border border-slate-200 dark:border-slate-700 rounded-xl font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">Batal</button>
                        <button type="submit"
                            class="flex-1 px-4 py-3 bg-rose-500 text-white rounded-xl font-bold hover:bg-rose-600 transition-all">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection