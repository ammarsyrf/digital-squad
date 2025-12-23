@extends('layouts.dashboard')

@section('title', 'Kelola Lowongan - Digital Skill Passport')

@section('header_title', 'Kelola Lowongan')

@section('sidebar')
    @include('layouts.partials.sidebar-umkm')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold">Daftar Lowongan</h2>
                <p class="text-slate-500">Kelola informasi pekerjaan yang telah Anda publikasikan.</p>
            </div>
            <a href="{{ route('umkm.jobs.create') }}"
                class="px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-primary/30 flex items-center gap-2">
                <span class="material-symbols-outlined">add</span>
                Buat Lowongan
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($jobs as $job)
                <div
                    class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-800 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="px-3 py-1 bg-{{ $job->status == 'Aktif' ? 'emerald' : 'slate' }}-100 text-{{ $job->status == 'Aktif' ? 'emerald' : 'slate' }}-700 rounded-full text-[10px] font-bold uppercase">
                            {{ $job->status }}
                        </div>
                    </div>
                    <h3 class="font-bold text-lg mb-1">{{ $job->judul }}</h3>
                    <p class="text-slate-500 text-sm mb-4 flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">location_on</span>
                        {{ $job->lokasi }}
                    </p>
                    <div class="flex items-center gap-4 text-xs text-slate-400 mb-6">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            {{ $job->tipe_pekerjaan }}
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">payments</span>
                            {{ $job->gaji ?? 'Kompetitif' }}
                        </span>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('umkm.jobs.edit', $job->id) }}"
                            class="flex-1 text-center py-2 bg-slate-100 dark:bg-slate-800 rounded-lg text-sm font-bold hover:bg-slate-200 transition-colors">
                            Edit
                        </a>
                        <form action="{{ route('umkm.jobs.destroy', $job->id) }}" method="POST" class="flex-1"
                            onsubmit="return confirm('Hapus lowongan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full py-2 bg-red-50 text-red-600 rounded-lg text-sm font-bold hover:bg-red-100 transition-colors">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full py-12 text-center bg-white dark:bg-slate-900 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                    <span class="material-symbols-outlined text-6xl opacity-10 mb-4">work_off</span>
                    <p class="text-slate-500 font-medium">Belum ada lowongan yang dibuat.</p>
                    <a href="{{ route('umkm.jobs.create') }}"
                        class="text-primary font-bold hover:underline mt-2 inline-block text-sm">Buat lowongan pertama Anda</a>
                </div>
            @endforelse
        </div>
    </div>
@endsection