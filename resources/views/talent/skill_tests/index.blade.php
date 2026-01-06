@extends('layouts.dashboard')

@section('title', 'Tes Skill - Digital Skill Passport')

@section('header_title', 'Tes Skill')

@section('sidebar')
    @include('layouts.partials.sidebar-talent')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold">Uji Kemampuan Anda</h2>
                <p class="text-slate-500 text-sm">Dapatkan badge verifikasi dengan menyelesaikan tes sesuai bidang Anda.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                <p class="font-medium text-sm">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center gap-3">
                <span class="material-symbols-outlined text-red-500">error</span>
                <p class="font-medium text-sm">{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($categories as $category)
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-md transition-all group">
                    <div
                        class="size-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl">psychology</span>
                    </div>
                    <h3 class="font-bold text-lg mb-1">{{ $category->nama_kategori }}</h3>
                    <p class="text-sm text-slate-500 mb-6">{{ $category->soal_count }} Soal tersedia</p>

                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400">Durasi: 30 Menit</span>
                        <a href="{{ route('talent.skill-tests.take', $category->id_kategori_skill) }}"
                            class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold shadow-lg shadow-primary/20 hover:bg-blue-600 transition-colors">
                            Mulai Tes
                        </a>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full py-20 text-center bg-white dark:bg-slate-800 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-700">
                    <span class="material-symbols-outlined text-6xl opacity-10 mb-4">quiz</span>
                    <p class="text-slate-500 font-medium">Belum ada kategori tes tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection