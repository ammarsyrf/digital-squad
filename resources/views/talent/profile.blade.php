@extends('layouts.dashboard')

@section('title', 'Profil Saya - Digital Skill Passport')

@section('header_title', 'Profil Saya')

@section('sidebar')
    @include('layouts.partials.sidebar-talent')
@endsection

@section('content')
    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition.duration.500ms
                class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('talent.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Profile Header -->
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col md:flex-row gap-6 items-center">
                <div class="relative group">
                    <div
                        class="size-24 rounded-full overflow-hidden border-4 border-slate-50 dark:border-slate-700 shadow-lg">
                        <img id="profile-preview"
                            src="{{ (isset($talent) && $talent->foto) ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(optional($talent)->nama_lengkap ?? 'User') . '&color=7F9CF5&background=EBF4FF' }}"
                            alt="Foto Profil" class="w-full h-full object-cover">
                    </div>
                    <label for="foto"
                        class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                        <span class="material-symbols-outlined text-white">photo_camera</span>
                    </label>
                    <input type="file" name="foto" id="foto" class="hidden" onchange="previewImage(this)">
                </div>
                <div class="text-center md:text-left">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">{{ optional($talent)->nama_lengkap }}</h2>
                    <p class="text-slate-500 dark:text-slate-400 font-medium">
                        {{ optional($talent)->pekerjaan_saat_ini ?? 'Talenta Digital' }}
                    </p>
                </div>
            </div>

            <!-- Basic Info -->
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div
                    class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person</span>
                    <h3 class="font-bold">Informasi Dasar</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap"
                            value="{{ old('nama_lengkap', optional($talent)->nama_lengkap) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                        @error('nama_lengkap') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', optional($talent)->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', optional($talent)->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', optional($talent)->tanggal_lahir) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Umur</label>
                        <input type="number" name="umur" value="{{ old('umur', optional($talent)->umur) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Status Pernikahan</label>
                        <select name="status_pernikahan" class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                            <option value="">Pilih Status</option>
                            <option value="Belum Menikah" {{ old('status_pernikahan', optional($talent)->status_pernikahan) == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                            <option value="Sudah Menikah" {{ old('status_pernikahan', optional($talent)->status_pernikahan) == 'Sudah Menikah' ? 'selected' : '' }}>Sudah Menikah</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Nomor Telepon</label>
                        <input type="tel" name="telepon" value="{{ old('telepon', optional($talent)->telepon) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="md:col-span-2 space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Alamat</label>
                        <textarea name="alamat" rows="2"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">{{ old('alamat', optional($talent)->alamat) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Bio -->
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div
                    class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">description</span>
                    <h3 class="font-bold">Tentang Saya</h3>
                </div>
                <div class="p-6 space-y-4">
                     <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Hobi</label>
                        <input type="text" name="hobi" value="{{ old('hobi', optional($talent)->hobi) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>

                    <div class="space-y-3 pt-2 border-t border-slate-100 dark:border-slate-700/50">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-base">stars</span>
                            Keahlian / Skill
                        </label>
                        <div id="skill-container" class="space-y-3">
                            @php
                                $skills = old('skill') ?? (optional($talent)->skill ? explode('; ', optional($talent)->skill) : []);
                                if (!is_array($skills)) $skills = [$skills];
                                if (empty($skills)) $skills = [''];
                            @endphp
                            
                            @foreach($skills as $skill)
                                <div class="relative group skill-row transition-all duration-300">
                                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                        <span class="material-symbols-outlined text-slate-400 text-[18px]">verified</span>
                                    </div>
                                    <input type="text" name="skill[]"
                                        value="{{ $skill }}"
                                        placeholder="Contoh: Laravel, React, Photoshop"
                                        class="w-full pl-10 pr-12 rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                                    
                                    <button type="button" onclick="removeRow(this)" 
                                        class="absolute inset-y-0 my-auto right-3 h-8 w-8 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Hapus Skill">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addSkill()" 
                            class="flex items-center gap-2 text-sm font-bold text-primary hover:text-blue-700 hover:bg-blue-50 px-4 py-2 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-[20px]">add</span>
                            Tambah Skill
                        </button>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Deskripsi Diri</label>
                        <textarea name="deskripsi" rows="4" placeholder="Ceritakan tentang Anda..."
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">{{ old('deskripsi', optional($talent)->deskripsi) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div
                    class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">work_history</span>
                    <h3 class="font-bold">Pekerjaan & Pendidikan</h3>
                </div>
                <div class="p-6 space-y-8">
                    <!-- Current Job -->
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Pekerjaan Saat Ini</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined text-slate-400 text-[18px]">work</span>
                            </div>
                            <input type="text" name="pekerjaan_saat_ini"
                                value="{{ old('pekerjaan_saat_ini', optional($talent)->pekerjaan_saat_ini) }}"
                                placeholder="Contoh: Full Stack Developer"
                                class="w-full pl-10 rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                        </div>
                    </div>

                    <!-- Work Experience -->
                    <div class="space-y-3 pt-6 border-t border-slate-100 dark:border-slate-700/50">
                        <div class="flex justify-between items-center">
                            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-base">work_history</span>
                                Pengalaman Kerja
                            </label>
                        </div>
                        
                        <div id="experience-container" class="space-y-3">
                            @php
                                $experiences = old('pengalaman_kerja') ?? (optional($talent)->pengalaman_kerja ? explode('; ', optional($talent)->pengalaman_kerja) : []);
                                if (!is_array($experiences)) $experiences = [$experiences];
                                if (empty($experiences)) $experiences = ['']; // Default one empty row
                            @endphp
                            
                            @foreach($experiences as $exp)
                                <div class="relative group experience-row transition-all duration-300">
                                    <div class="absolute top-3 left-3 flex items-center pointer-events-none">
                                        <span class="material-symbols-outlined text-slate-400 text-[18px]">business_center</span>
                                    </div>
                                    <textarea name="pengalaman_kerja[]" rows="2"
                                        placeholder="Contoh: Senior Developer di Google (2020-2023)&#10;- Memimpin tim frontend"
                                        class="w-full pl-10 pr-12 rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary resize-y min-h-[60px]">{{ $exp }}</textarea>
                                    
                                    <button type="button" onclick="removeRow(this)" 
                                        class="absolute top-3 right-3 p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Hapus Pengalaman">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addExperience()" 
                            class="flex items-center gap-2 text-sm font-bold text-primary hover:text-blue-700 hover:bg-blue-50 px-4 py-2 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-[20px]">add</span>
                            Tambah Pengalaman
                        </button>
                    </div>
                    
                    <!-- Education -->
                    <div class="space-y-3 pt-6 border-t border-slate-100 dark:border-slate-700/50">
                        <div class="flex justify-between items-center">
                            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-base">school</span>
                                Riwayat Pendidikan
                            </label>
                        </div>

                        <div id="education-container" class="space-y-3">
                            @php
                                $educations = old('pendidikan_terakhir') ?? (optional($talent)->pendidikan_terakhir ? explode('; ', optional($talent)->pendidikan_terakhir) : []);
                                if (!is_array($educations)) $educations = [$educations];
                                if (empty($educations)) $educations = ['']; // Default one empty row
                            @endphp
                            
                            @foreach($educations as $edu)
                                <div class="relative group education-row transition-all duration-300">
                                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                        <span class="material-symbols-outlined text-slate-400 text-[18px]">school</span>
                                    </div>
                                    <input type="text" name="pendidikan_terakhir[]"
                                        value="{{ $edu }}"
                                        placeholder="Contoh: S1 Teknik Informatika - Universitas Indonesia"
                                        class="w-full pl-10 pr-12 rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                                    
                                    <button type="button" onclick="removeRow(this)" 
                                        class="absolute inset-y-0 my-auto right-3 h-8 w-8 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Hapus Pendidikan">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addEducation()" 
                            class="flex items-center gap-2 text-sm font-bold text-primary hover:text-blue-700 hover:bg-blue-50 px-4 py-2 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-[20px]">add</span>
                            Tambah Pendidikan
                        </button>
                    </div>

                    <script>
                        function addEducation() {
                            const container = document.getElementById('education-container');
                            const div = document.createElement('div');
                            div.className = 'relative group education-row opacity-0 transform translate-y-2 transition-all duration-300';
                            div.innerHTML = `
                                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined text-slate-400 text-[18px]">school</span>
                                </div>
                                <input type="text" name="pendidikan_terakhir[]" 
                                    placeholder="Contoh: S1 Teknik Informatika - Universitas Indonesia"
                                    class="w-full pl-10 pr-12 rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                                
                                <button type="button" onclick="removeRow(this)" 
                                    class="absolute inset-y-0 my-auto right-3 h-8 w-8 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                    title="Hapus Pendidikan">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            `;
                            container.appendChild(div);
                            animateIn(div);
                        }

                        function addExperience() {
                            const container = document.getElementById('experience-container');
                            const div = document.createElement('div');
                            div.className = 'relative group experience-row opacity-0 transform translate-y-2 transition-all duration-300';
                            div.innerHTML = `
                                <div class="absolute top-3 left-3 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined text-slate-400 text-[18px]">business_center</span>
                                </div>
                                <textarea name="pengalaman_kerja[]" rows="2"
                                    placeholder="Contoh: Senior Developer di Google (2020-2023)&#10;- Memimpin tim frontend"
                                    class="w-full pl-10 pr-12 rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary resize-y min-h-[60px]"></textarea>
                                
                                <button type="button" onclick="removeRow(this)" 
                                    class="absolute top-3 right-3 p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                    title="Hapus Pengalaman">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            `;
                            container.appendChild(div);
                            animateIn(div);
                        }

                        function animateIn(element) {
                            requestAnimationFrame(() => {
                                element.classList.remove('opacity-0', 'translate-y-2');
                            });
                        }

                        function removeRow(btn) {
                            const row = btn.closest('.relative'); // Find closest parent row
                            
                            // Check if it's the only row in the container
                            const container = row.parentElement;
                            if (container.children.length <= 1) {
                                // Optional: Clear value instead of removing if it's the last one
                                const input = row.querySelector('input, textarea');
                                input.value = '';
                                input.focus();
                                return;
                            }

                            row.classList.add('opacity-0', 'scale-95');
                            setTimeout(() => {
                                row.remove();
                            }, 200);
                        }

                        function addSkill() {
                            const container = document.getElementById('skill-container');
                            const div = document.createElement('div');
                            div.className = 'relative group skill-row opacity-0 transform translate-y-2 transition-all duration-300';
                            div.innerHTML = `
                                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined text-slate-400 text-[18px]">verified</span>
                                </div>
                                <input type="text" name="skill[]" 
                                    placeholder="Contoh: Laravel, React, Photoshop"
                                    class="w-full pl-10 pr-12 rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                                
                                <button type="button" onclick="removeRow(this)" 
                                    class="absolute inset-y-0 my-auto right-3 h-8 w-8 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                    title="Hapus Skill">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            `;
                            container.appendChild(div);
                            requestAnimationFrame(() => {
                                div.classList.remove('opacity-0', 'translate-y-2');
                            });
                        }
                    </script>
                </div>
            </div>

            <!-- Keahlian & Portofolio (Renamed/Adjusted) -->
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div
                    class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">rocket_launch</span>
                    <h3 class="font-bold">Portofolio & Sosial Media</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">LinkedIn URL</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined text-slate-400 text-[18px]">link</span>
                            </div>
                            <input type="url" name="linkedin" value="{{ old('linkedin', optional($talent)->linkedin) }}"
                                placeholder="https://linkedin.com/in/username"
                                class="w-full pl-10 rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Portfolio URL</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined text-slate-400 text-[18px]">captive_portal</span>
                            </div>
                            <input type="url" name="portfolio"
                                value="{{ old('portfolio', optional($talent)->portfolio) }}"
                                placeholder="https://myportfolio.com"
                                class="w-full pl-10 rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-primary focus:border-primary">
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
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profile-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection