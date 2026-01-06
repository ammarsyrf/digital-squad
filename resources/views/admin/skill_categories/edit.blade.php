@extends('layouts.dashboard')

@section('title', 'Edit Kategori Skill - Digital Skill Passport')

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
                <li>
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-slate-400 text-sm mx-1">chevron_right</span>
                        <a href="{{ route('admin.skill-categories') }}"
                            class="ml-1 text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary md:ml-2">Kategori</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-slate-400 text-sm mx-1">chevron_right</span>
                        <span class="ml-1 text-sm font-medium text-slate-900 dark:text-white md:ml-2">Edit</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Edit Kategori</h2>
            <p class="mt-2 text-slate-600 dark:text-slate-400">Perbarui nama kategori ini.</p>
        </div>

        <!-- Form -->
        <div
            class="bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-xl shadow-sm p-6">
            <form action="{{ route('admin.skill-categories.update', $category->id_kategori_skill) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label for="nama_kategori"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori"
                            value="{{ old('nama_kategori', $category->nama_kategori) }}" required
                            class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-primary focus:border-primary sm:text-sm">
                        @error('nama_kategori') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('admin.skill-categories') }}"
                            class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-600 dark:hover:bg-slate-700">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-dark focus:ring-4 focus:ring-primary/20">
                            Perbarui Kategori
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection