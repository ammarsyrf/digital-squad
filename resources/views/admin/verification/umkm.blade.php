@extends('layouts.dashboard')

@section('title', 'Verifikasi UMKM - Digital Skill Passport')

@section('header_title', 'Verifikasi UMKM')

@section('sidebar')
    @include('layouts.partials.sidebar-admin')
@endsection

@section('content')
    <div class="space-y-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Verifikasi Akun UMKM</h2>
            <p class="text-slate-500">Tinjau dan validasi pendaftaran akun instansi baru.</p>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div x-data="{ 
                        showRejectModal: false, 
                        rejectAction: '', 
                        umkmName: '',
                        openReject(id, name) {
                            this.umkmName = name;
                            this.rejectAction = `{{ url('/admin/verification/umkm') }}/${id}/reject`;
                            this.showRejectModal = true;
                        }
                    }"
            class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Instansi</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Alamat</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Tanggal Daftar</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 text-center">Status
                        </th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 text-right">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($umkms as $umkm)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined">business</span>
                                    </div>
                                    <div>
                                        <span
                                            class="font-bold text-slate-900 dark:text-white block">{{ $umkm->nama_umkm }}</span>
                                        <span class="text-xs text-slate-500">{{ $umkm->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-600 dark:text-slate-400 line-clamp-1">{{ $umkm->alamat }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ $umkm->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-amber-100 text-amber-700',
                                            'verified' => 'bg-emerald-100 text-emerald-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                            'Pending' => 'bg-amber-100 text-amber-700',
                                            'Terverifikasi' => 'bg-emerald-100 text-emerald-700',
                                            'Ditolak' => 'bg-red-100 text-red-700',
                                        ];

                                        $statusLabels = [
                                            'pending' => 'Pending',
                                            'verified' => 'Terverifikasi',
                                            'rejected' => 'Ditolak',
                                            'Pending' => 'Pending',
                                            'Terverifikasi' => 'Terverifikasi',
                                            'Ditolak' => 'Ditolak',
                                        ];

                                        $rawStatus = $umkm->status_verifikasi ?? 'pending';
                                        $class = $statusClasses[$rawStatus] ?? 'bg-slate-100 text-slate-700';
                                        $label = $statusLabels[$rawStatus] ?? $rawStatus;
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $class }}">
                                        {{ $label }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('messages.show', $umkm->user_id) }}"
                                        class="p-2 text-primary hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Chat Pemilik">
                                        <span class="material-symbols-outlined">chat</span>
                                    </a>

                                    @if($umkm->status_verifikasi != 'Terverifikasi')
                                        <form action="{{ route('admin.verification.umkm.approve', $umkm->id) }}" method="POST"
                                            onsubmit="return confirm('Setujui verifikasi ini?')">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors"
                                                title="Setujui">
                                                <span class="material-symbols-outlined">check_circle</span>
                                            </button>
                                        </form>
                                        <button @click="openReject('{{ $umkm->id }}', '{{ addslashes($umkm->nama_umkm) }}')"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Tolak">
                                            <span class="material-symbols-outlined">cancel</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                Tidak ada permohonan verifikasi saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Alpine-powered Reject Modal -->
            <div x-show="showRejectModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                <div @click.away="showRejectModal = false"
                    class="bg-white dark:bg-slate-900 rounded-2xl p-8 max-w-md w-full shadow-2xl transform transition-all"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">

                    <div class="flex items-center gap-3 mb-4 text-red-600">
                        <span class="material-symbols-outlined text-3xl">warning</span>
                        <h3 class="text-xl font-bold">Tolak Verifikasi</h3>
                    </div>

                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                        Anda akan menolak verifikasi untuk <span class="font-bold text-slate-900 dark:text-white"
                            x-text="umkmName"></span>. Berikan alasan penolakan di bawah ini.
                    </p>

                    <form :action="rejectAction" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Alasan
                                Penolakan</label>
                            <textarea name="catatan" rows="4" required
                                class="w-full rounded-xl border-slate-200 dark:border-slate-800 dark:bg-slate-950 focus:ring-primary text-sm"
                                placeholder="Contoh: Dokumen tidak lengkap atau data tidak valid..."></textarea>
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" @click="showRejectModal = false"
                                class="px-6 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-xl font-bold text-sm hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">Batal</button>
                            <button type="submit"
                                class="px-6 py-2.5 bg-red-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-red-500/30 hover:bg-red-700 transition-colors">Tolak
                                Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection