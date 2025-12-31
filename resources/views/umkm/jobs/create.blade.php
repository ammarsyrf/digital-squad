@extends('layouts.dashboard')

@section('title', 'Buat Lowongan - Digital Skill Passport')

@section('header_title', 'Buat Lowongan')

@section('sidebar')
    @include('layouts.partials.sidebar-umkm')
@endsection

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-8">
            <h2 class="text-xl font-bold mb-6">Informasi Pekerjaan</h2>

            <form action="{{ route('umkm.jobs.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Judul Posisi</label>
                    <input type="text" name="judul" required placeholder="Contoh: Web Developer, UI Designer"
                        class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tipe Pekerjaan</label>
                        <select name="tipe_pekerjaan" required
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                            <option value="Full-time">Full-time</option>
                            <option value="Part-time">Part-time</option>
                            <option value="Daily Worker/Harian">Daily Worker/Harian</option>
                            <option value="Kontrak">Kontrak</option>
                            <option value="Freelance">Freelance</option>
                            <option value="Internship">Magang/Internship</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Lokasi</label>
                        <input type="text" name="lokasi" required placeholder="Contoh: Jakarta, Remote"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Sistem Kerja</label>
                        <select name="sistem_kerja" required
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                            <option value="WFO">WFO (Work From Office)</option>
                            <option value="Remote">Remote (Kerja Jarak Jauh)</option>
                            <option value="Hybrid">Hybrid (Campuran)</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Rentang Gaji</label>
                        <input type="text" name="gaji" placeholder="Contoh: Rp 2.000.000 - Rp 3.000.000"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary">
                        <p class="text-[10px] text-slate-400">Transparansi gaji meningkatkan minat pelamar hingga 40%.</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Fasilitas & Benefit</label>
                    <textarea name="fasilitas" rows="3"
                        placeholder="Contoh: Makan siang gratis, Mess/Tempat tinggal, Bonus target, THR..."
                        class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary"></textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Deskripsi Pekerjaan &
                        Persyaratan</label>
                    <textarea name="deskripsi" rows="8" required
                        placeholder="Jelaskan tanggung jawab, kriteria, dan benefit..."
                        class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-primary focus:border-primary"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('umkm.jobs') }}"
                        class="px-6 py-3 bg-slate-100 dark:bg-slate-800 rounded-xl font-bold hover:bg-slate-200 transition-colors">Batal</a>
                    <button type="submit"
                        class="px-8 py-3 bg-primary text-white rounded-xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-primary/30">
                        Publikasikan Lowongan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection