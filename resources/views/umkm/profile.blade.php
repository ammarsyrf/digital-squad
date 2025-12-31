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
                    <div class="flex flex-col md:items-start items-center gap-1 mt-1">
                        <div class="flex items-center gap-2">
                             @php
                                $statusMap = [
                                    'pending' => ['label' => 'Menunggu Verifikasi', 'class' => 'text-amber-600 bg-amber-50 border-amber-200', 'icon' => 'hourglass_empty'],
                                    'verified' => ['label' => 'Terverifikasi', 'class' => 'text-emerald-600 bg-emerald-50 border-emerald-200', 'icon' => 'verified'],
                                    'rejected' => ['label' => 'Ditolak', 'class' => 'text-red-600 bg-red-50 border-red-200', 'icon' => 'cancel'],
                                    'Belum Terverifikasi' => ['label' => 'Belum Terverifikasi', 'class' => 'text-slate-500 bg-slate-50 border-slate-200', 'icon' => 'info'],
                                ];
                                $currentStatus = optional($umkm)->status_verifikasi ?? 'Belum Terverifikasi';
                                $statusInfo = $statusMap[$currentStatus] ?? $statusMap['Belum Terverifikasi'];
                            @endphp
                            
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide border flex items-center gap-1.5 {{ $statusInfo['class'] }}">
                                <span class="material-symbols-outlined text-[16px]">{{ $statusInfo['icon'] }}</span>
                                {{ $statusInfo['label'] }}
                            </span>
                        </div>

                        @if(optional($umkm)->status_verifikasi == 'rejected' && optional($umkm)->catatan_admin)
                            <div class="mt-2 p-3 bg-red-50 border border-red-100 rounded-lg text-xs text-red-700 max-w-md text-left">
                                <span class="font-bold block mb-1">Alasan Penolakan:</span>
                                {{ $umkm->catatan_admin }}
                            </div>
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

            <!-- Informasi Bisnis (Tambahan) -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">storefront</span>
                    <h3 class="font-bold">Informasi Bisnis & Operasional</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Kategori / Sektor Usaha</label>
                        <select name="kategori" class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                            <option value="">Pilih Kategori</option>
                            @foreach(['Kuliner', 'Fashion', 'Jasa', 'Teknologi', 'Kerajinan', 'Agribisnis', 'Lainnya'] as $cat)
                                <option value="{{ $cat }}" {{ old('kategori', optional($umkm)->kategori) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Skala Usaha</label>
                        <select name="skala_usaha" class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                            <option value="">Pilih Skala</option>
                            @foreach(['Mikro (< 50jt)', 'Kecil (50-500jt)', 'Menengah (500jt-10M)'] as $scale)
                                <option value="{{ $scale }}" {{ old('skala_usaha', optional($umkm)->skala_usaha) == $scale ? 'selected' : '' }}>{{ $scale }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tahun Berdiri</label>
                        <input type="number" name="tahun_berdiri" value="{{ old('tahun_berdiri', optional($umkm)->tahun_berdiri) }}" placeholder="Contoh: 2020"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Jumlah Karyawan</label>
                        <select name="jumlah_karyawan" class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                            <option value="">Pilih Rentang</option>
                            @foreach(['1-5 Orang', '6-20 Orang', '21-50 Orang', '> 50 Orang'] as $range)
                                <option value="{{ $range }}" {{ old('jumlah_karyawan', optional($umkm)->jumlah_karyawan) == $range ? 'selected' : '' }}>{{ $range }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Branding & Media Visual -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">campaign</span>
                    <h3 class="font-bold">Branding & Media Visual</h3>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Social Media -->
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Media Sosial</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-1">
                                <label class="text-xs font-bold uppercase text-slate-400">Instagram</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 text-sm">@</span>
                                    <input type="text" name="instagram" value="{{ old('instagram', optional($umkm)->instagram) }}" placeholder="username"
                                        class="w-full pl-8 rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-bold uppercase text-slate-400">TikTok</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 text-sm">@</span>
                                    <input type="text" name="tiktok" value="{{ old('tiktok', optional($umkm)->tiktok) }}" placeholder="username"
                                        class="w-full pl-8 rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-bold uppercase text-slate-400">WhatsApp Business</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 text-sm material-symbols-outlined text-[16px]">call</span>
                                    <input type="tel" name="whatsapp" value="{{ old('whatsapp', optional($umkm)->whatsapp) }}" placeholder="0812..."
                                        class="w-full pl-9 rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery -->
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-2">Galeri Foto / Suasana Kerja</h4>
                        <p class="text-xs text-slate-500 mb-4">Unggah 3-5 foto untuk meningkatkan kepercayaan pelamar. (Max 2MB per foto)</p>
                        
                        <!-- Existing Gallery Preview -->
                        @if(optional($umkm)->galeri)
                            @php
                                $gallery = json_decode($umkm->galeri);
                            @endphp
                            @if(is_array($gallery) && count($gallery) > 0)
                                <div class="flex gap-4 overflow-x-auto pb-4 mb-4">
                                    @foreach($gallery as $img)
                                        <div class="relative shrink-0 size-24 rounded-lg overflow-hidden border border-slate-200 group">
                                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif

                        <label class="block w-full cursor-pointer">
                            <div class="w-full border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl p-8 flex flex-col items-center justify-center hover:border-primary hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all group">
                                <span class="material-symbols-outlined text-4xl text-slate-300 group-hover:text-primary mb-2">add_photo_alternate</span>
                                <p class="text-sm font-bold text-slate-500 group-hover:text-primary">Klik untuk unggah foto baru</p>
                                <p class="text-xs text-slate-400 mt-1">Bisa pilih banyak foto sekaligus</p>
                            </div>
                            <input type="file" name="galeri[]" multiple accept="image/*" class="hidden">
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Verification Documents -->
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div
                    class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">verified_user</span>
                    <h3 class="font-bold">Verifikasi & Legalitas</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <div class="p-4 bg-blue-50 text-blue-800 rounded-xl text-sm mb-4">
                            Untuk mendapatkan status <strong>Terverifikasi</strong>, harap lengkapi data legalitas dan unggah dokumen pendukung.
                        </div>

                        <!-- Legalitas Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-slate-100 dark:border-slate-800">
                             <div class="space-y-1">
                                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">NPWP Badan / Perorangan</label>
                                <input type="text" name="npwp" value="{{ old('npwp', optional($umkm)->npwp) }}"
                                    class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Penanggung Jawab</label>
                                <input type="text" name="nama_penanggung_jawab" value="{{ old('nama_penanggung_jawab', optional($umkm)->nama_penanggung_jawab) }}"
                                    class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Jabatan Penanggung Jawab</label>
                                <input type="text" name="jabatan_penanggung_jawab" value="{{ old('jabatan_penanggung_jawab', optional($umkm)->jabatan_penanggung_jawab) }}"
                                    placeholder="Contoh: Owner, Direktur, Manager HR"
                                    class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Dokumen Pendukung / Surat Usaha</label>
                            
                            @if(optional($umkm)->dokumen_verifikasi)
                                <div class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl mb-3 bg-slate-50">
                                    <span class="material-symbols-outlined text-slate-500">description</span>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-slate-700">Dokumen Telah Diunggah</p>
                                        <a href="{{ asset('storage/' . $umkm->dokumen_verifikasi) }}" target="_blank" class="text-xs text-primary hover:underline">Lihat Dokumen Saat Ini</a>
                                    </div>
                                    <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                                </div>
                            @endif

                            <input type="file" name="dokumen_verifikasi" accept=".pdf,.jpg,.jpeg,.png"
                                class="w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-xl file:border-0
                                file:text-sm file:font-semibold
                                file:bg-primary/10 file:text-primary
                                hover:file:bg-primary/20 cursor-pointer">
                            <p class="text-xs text-slate-400 mt-2">Format: PDF, JPG, PNG. Maksimal 5MB.</p>
                        </div>
                    </div>
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