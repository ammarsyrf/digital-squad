@extends('layouts.dashboard')

@section('title', 'Profil Admin - Digital Skill Passport')

@section('sidebar')
    @include('layouts.partials.sidebar-admin')
@endsection

@section('content')
    <div class="max-w-2xl mx-auto w-full">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary">
                        Dashboard
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-slate-400 text-sm mx-1">chevron_right</span>
                        <span class="ml-1 text-sm font-medium text-slate-900 dark:text-white md:ml-2">Profil Admin</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Profil Admin</h2>
            <p class="mt-2 text-slate-600 dark:text-slate-400">Kelola informasi profil administrator.</p>
        </div>

        <!-- Info Card -->
        <div
            class="bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="size-20 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-4xl">admin_panel_settings</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ Auth::user()->name }}</h3>
                    <p class="text-slate-500 dark:text-slate-400">{{ Auth::user()->email }}</p>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 mt-2">
                        Administrator
                    </span>
                </div>
            </div>

            <div class="border-t border-slate-200 dark:border-slate-700 pt-6">
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">
                    Pengaturan profil admin saat ini dikelola langsung melalui database atau hubungi pengembang sistem untuk
                    perubahan kredensial tingkat lanjut.
                </p>

                {{-- Logout Button --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2 border border-red-200 text-red-700 bg-red-50 hover:bg-red-100 rounded-lg dark:border-red-900/30 dark:text-red-400 dark:bg-red-900/20 dark:hover:bg-red-900/40 transition-colors">
                        <span class="material-symbols-outlined text-sm">logout</span>
                        Keluar dari Sistem
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection