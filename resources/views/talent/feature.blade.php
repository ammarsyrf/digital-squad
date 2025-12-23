@extends('layouts.dashboard')

@section('title', 'Fitur Talenta - Digital Skill Passport')

@section('header_title', 'Fitur Talenta')

@section('sidebar')
    @include('layouts.partials.sidebar-talent')
@endsection

@section('content')
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden border border-slate-200 dark:border-slate-700">
            <div class="px-6 py-12 text-center">
                <div class="size-20 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-4xl">hvac</span>
                </div>
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4 italic uppercase tracking-widest">Fitur
                    Sedang Dikembangkan</h2>
                <p class="text-slate-500 dark:text-slate-400 max-w-lg mx-auto mb-8 font-medium">
                    Halaman <span class="text-primary font-bold">{{ $feature }}</span> sedang dalam tahap migrasi dari
                    aplikasi native ke Laravel.
                    Mohon kembali lagi secara berkala untuk melihat pembaruan.
                </p>
                <a href="{{ route('talent.dashboard') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-blue-600 transition-all hover:-translate-y-1 shadow-lg shadow-primary/30">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection