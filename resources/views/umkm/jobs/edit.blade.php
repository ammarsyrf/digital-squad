@extends('layouts.dashboard')

@section('title', 'Edit Lowongan - Digital Skill Passport')

@section('header_title', 'Edit Lowongan')

@section('sidebar')
    @include('layouts.partials.sidebar-umkm')
@endsection

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-8">
            <h2 class="text-xl font-bold mb-6">Informasi Pekerjaan</h2>

            <form action="{{ route('umkm.jobs.update', $lowongan->id) }}" method="POST" class="space-y-6">
                @csrf
                {{-- No @method('PUT') because the route is defined as POST --}}

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Judul Posisi</label>
                    <input type="text" name="judul" value="{{ old('judul', $lowongan->judul) }}" required
                        placeholder="Contoh: Web Developer, UI Designer"
                        class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tipe Pekerjaan</label>
                        <select name="tipe_pekerjaan" required
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                            <option value="Full-time" {{ $lowongan->tipe_pekerjaan == 'Full-time' ? 'selected' : '' }}>
                                Full-time</option>
                            <option value="Part-time" {{ $lowongan->tipe_pekerjaan == 'Part-time' ? 'selected' : '' }}>
                                Part-time</option>
                            <option value="Kontrak" {{ $lowongan->tipe_pekerjaan == 'Kontrak' ? 'selected' : '' }}>Kontrak
                            </option>
                            <option value="Freelance" {{ $lowongan->tipe_pekerjaan == 'Freelance' ? 'selected' : '' }}>
                                Freelance</option>
                            <option value="Internship" {{ $lowongan->tipe_pekerjaan == 'Internship' ? 'selected' : '' }}>
                                Internship</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Lokasi</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi', $lowongan->lokasi) }}" required
                            placeholder="Contoh: Jakarta, Remote"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Estimasi Gaji
                            (Opsional)</label>
                        <input type="text" name="gaji" value="{{ old('gaji', $lowongan->gaji) }}"
                            placeholder="Contoh: 5jt - 8jt"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Status Lowongan</label>
                        <select name="status" required
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                            <option value="Aktif" {{ $lowongan->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ $lowongan->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Deskripsi Pekerjaan &
                        Persyaratan</label>
                    <textarea name="deskripsi" rows="8" required
                        placeholder="Jelaskan tanggung jawab, kriteria, dan benefit..."
                        class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('umkm.jobs') }}"
                        class="px-6 py-3 bg-slate-100 dark:bg-slate-800 rounded-xl font-bold hover:bg-slate-200 transition-colors">Batal</a>
                    <button type="submit"
                        class="px-8 py-3 bg-primary text-white rounded-xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-primary/30">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection