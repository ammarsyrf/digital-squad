@extends('layouts.dashboard')

@section('title', 'Kelola Data User - Digital Skill Passport')

@section('sidebar')
    @include('layouts.partials.sidebar-admin')
@endsection

@push('styles')
    <style>
        @media print {
            @page {
                size: landscape;
                margin: 1cm;
            }

            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }

            /* Hide layout elements */
            aside,
            header,
            nav,
            footer {
                display: none !important;
            }

            /* Reset background for clarity */
            body {
                background: white !important;
                color: black !important;
            }

            /* Table styling for print */
            table {
                width: 100% !important;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #ddd;
                padding: 8px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="print-area max-w-7xl mx-auto w-full">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6 no-print" aria-label="Breadcrumb">
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
                        <a href="#"
                            class="ml-1 text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary md:ml-2">User</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-slate-400 text-sm mx-1">chevron_right</span>
                        <span class="ml-1 text-sm font-medium text-slate-900 dark:text-white md:ml-2">Kelola Data
                            User</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">Kelola Data
                    User</h2>
                <p class="mt-2 text-slate-600 dark:text-slate-400 no-print">Kelola akun Talenta Digital dan UMKM/Instansi,
                    pantau status, dan aksi lainnya.</p>
            </div>
            <div class="flex gap-2 no-print">
                <button onclick="window.print()"
                    class="inline-flex items-center justify-center rounded-lg bg-surface-light border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-200 dark:bg-surface-dark dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-[20px] mr-2">print</span>
                    Cetak
                </button>
                <a href="{{ route('admin.users.export') }}" target="_blank"
                    class="inline-flex items-center justify-center rounded-lg bg-surface-light border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-200 dark:bg-surface-dark dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-[20px] mr-2">download</span>
                    Unduh
                </a>
                <a href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-primary px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900 transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-[20px] mr-2">add</span>
                    Tambah User Baru
                </a>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 no-print">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-blue-100 dark:border-blue-900/30 shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-6xl text-blue-600">group</span>
                </div>
                <div class="flex items-center justify-between mb-4 relative z-10">
                    <h3 class="text-sm font-bold text-blue-900 dark:text-blue-100 uppercase tracking-wider">Total User</h3>
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/50 rounded-lg">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">group</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 relative z-10">
                    <span class="text-3xl font-black text-slate-900 dark:text-white">{{ number_format($totalUsers) }}</span>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-purple-100 dark:border-purple-900/30 shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-6xl text-purple-600">school</span>
                </div>
                <div class="flex items-center justify-between mb-4 relative z-10">
                    <h3 class="text-sm font-bold text-purple-900 dark:text-purple-100 uppercase tracking-wider">Talenta</h3>
                    <div class="p-2 bg-purple-50 dark:bg-purple-900/50 rounded-lg">
                        <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">school</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 relative z-10">
                    <span class="text-3xl font-black text-slate-900 dark:text-white">{{ number_format($talentCount) }}</span>
                    <span class="text-sm font-medium text-purple-600 dark:text-purple-400">User</span>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-orange-100 dark:border-orange-900/30 shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-6xl text-orange-600">storefront</span>
                </div>
                <div class="flex items-center justify-between mb-4 relative z-10">
                    <h3 class="text-sm font-bold text-orange-900 dark:text-orange-100 uppercase tracking-wider">UMKM</h3>
                    <div class="p-2 bg-orange-50 dark:bg-orange-900/50 rounded-lg">
                        <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">storefront</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 relative z-10">
                    <span class="text-3xl font-black text-slate-900 dark:text-white">{{ number_format($umkmCount) }}</span>
                    <span class="text-sm font-medium text-orange-600 dark:text-orange-400">User</span>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-emerald-100 dark:border-emerald-900/30 shadow-sm relative overflow-hidden group">
                 <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-6xl text-emerald-600">today</span>
                </div>
                <div class="flex items-center justify-between mb-4 relative z-10">
                    <h3 class="text-sm font-bold text-emerald-900 dark:text-emerald-100 uppercase tracking-wider">User Baru</h3>
                    <div class="p-2 bg-emerald-50 dark:bg-emerald-900/50 rounded-lg">
                        <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400">today</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 relative z-10">
                    <span class="text-3xl font-black text-slate-900 dark:text-white">{{ number_format($newUsersCount) }}</span>
                    @if($newUsersCount > 0)
                    <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">+{{ $newUsersCount }}</span>
                    @else
                    <span class="text-sm font-medium text-slate-400">--</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Filters & Actions Bar -->
        <div
            class="bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark p-4 mb-6 shadow-sm no-print">
            <form action="{{ route('admin.users') }}" method="GET"
                class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-end">
                <!-- Search -->
                <div class="w-full lg:w-1/3 relative">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1" for="search">Cari
                        User</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-slate-400">search</span>
                        </div>
                        <input name="q" value="{{ request('q') }}"
                            class="block w-full pl-10 pr-3 py-2.5 border border-border-light dark:border-border-dark rounded-lg leading-5 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary sm:text-sm"
                            id="search" placeholder="Nama atau email..." type="text" />
                    </div>
                </div>
                <!-- Filters Wrapper -->
                <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-2/3">
                    <!-- Role Filter -->
                    <div class="w-full sm:w-1/3">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1" for="role">Filter
                            Role</label>
                        <select name="role"
                            class="block w-full pl-3 pr-10 py-2.5 text-base border-border-light dark:border-border-dark focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-lg bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white"
                            id="role">
                            <option value="">Semua Role</option>
                            <option value="talent" {{ request('role') == 'talent' ? 'selected' : '' }}>Talenta Digital
                            </option>
                            <option value="umkm" {{ request('role') == 'umkm' ? 'selected' : '' }}>UMKM / Instansi</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <!-- Status Filter -->
                    <div class="w-full sm:w-1/3">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1" for="status">Filter
                            Status</label>
                        <select name="status"
                            class="block w-full pl-3 pr-10 py-2.5 text-base border-border-light dark:border-border-dark focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-lg bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white"
                            id="status">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif
                            </option>
                            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended
                            </option>
                        </select>
                    </div>
                    <!-- Filter Buttons -->
                    <div class="w-full sm:w-auto flex items-end">
                        <button type="submit"
                            class="w-full sm:w-auto flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg text-primary bg-primary/10 hover:bg-primary/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px] mr-2">filter_list</span>
                            Terapkan
                        </button>
                        @if(request()->anyFilled(['q', 'role', 'status']))
                            <a href="{{ route('admin.users') }}"
                                class="ml-2 w-full sm:w-auto flex items-center justify-center px-4 py-2.5 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-200 transition-colors">
                                Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 border border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800 no-print"
                role="alert">
                <span class="font-medium">Sukses!</span> {{ session('success') }}
            </div>
        @endif

        <!-- Data Table -->
        <div
            class="bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-border-light dark:divide-border-dark">
                    <thead class="bg-slate-50 dark:bg-slate-800/50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                User</th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Role</th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Tanggal Gabung</th>
                            <th scope="col" class="relative px-6 py-4 no-print"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody
                        class="bg-surface-light dark:bg-surface-dark divide-y divide-border-light dark:divide-border-dark">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 flex-shrink-0 bg-slate-200 dark:bg-slate-700 rounded-full flex items-center justify-center text-slate-500 dark:text-slate-400 font-bold overflow-hidden">
                                            <!-- Placeholder Avatar if no image -->
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-slate-900 dark:text-white">{{ $user->name }}
                                            </div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->role == 'talent')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">Talenta
                                            Digital</span>
                                    @elseif($user->role == 'umkm')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">UMKM
                                            / Instansi</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300">Admin</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->status == 'active')
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                            <span class="size-1.5 rounded-full bg-green-500"></span> Aktif
                                        </span>
                                    @elseif($user->status == 'inactive')
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                            <span class="size-1.5 rounded-full bg-yellow-500"></span> Non-Aktif
                                        </span>
                                    @elseif($user->status == 'suspended')
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                            <span class="size-1.5 rounded-full bg-red-500"></span> Suspended
                                        </span>
                                    @else
                                        <!-- Fallback/Default -->
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                            <span class="size-1.5 rounded-full bg-green-500"></span> Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-400">
                                    {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium no-print">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="text-slate-400 hover:text-orange-500 dark:hover:text-orange-400 transition-colors p-1"
                                            title="Edit">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </a>
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-slate-400 hover:text-red-600 dark:hover:text-red-400 transition-colors p-1"
                                                title="Delete">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-slate-500 dark:text-slate-400">
                                    Tidak ada data user ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div
                class="bg-surface-light dark:bg-surface-dark px-4 py-3 flex items-center justify-between border-t border-border-light dark:border-border-dark sm:px-6 no-print">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection