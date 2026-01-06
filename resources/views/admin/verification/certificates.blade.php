@extends('layouts.dashboard')

@section('title', 'Verifikasi Sertifikat - Digital Skill Passport')

@section('header_title', 'Verifikasi Sertifikat')

@section('sidebar')
    @include('layouts.partials.sidebar-admin')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function printCertificate(url) {
            const printWindow = window.open(url, '_blank');
            printWindow.onload = function () {
                setTimeout(() => {
                    printWindow.print();
                }, 500);
            };
        }

        function confirmVerification(event, name) {
            event.preventDefault();
            const form = event.target.closest('form');
            
            Swal.fire({
                title: 'Setujui Verifikasi?',
                text: "Apakah Anda yakin ingin menyetujui verifikasi sertifikat untuk " + name + "?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal',
                background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#fff',
                color: document.documentElement.classList.contains('dark') ? '#fff' : '#0f172a',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
@endpush

@section('content')
    <div class="space-y-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Verifikasi Sertifikat Talenta</h2>
            <p class="text-slate-500">Validasi keaslian sertifikat yang diunggah oleh para talenta.</p>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div
            class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Talenta</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">Nama Sertifikat
                        </th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 text-center">Status
                        </th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500 text-right">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($sertifikats as $sertifikat)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined">person</span>
                                    </div>
                                    <div>
                                        <span
                                            class="font-bold text-slate-900 dark:text-white block">{{ $sertifikat->user->talent->nama_lengkap ?? $sertifikat->user->name }}</span>
                                        <span class="text-xs text-slate-500">{{ $sertifikat->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="text-sm font-bold text-slate-700 dark:text-slate-200 block">{{ $sertifikat->nama_sertifikat }}</span>
                                <a href="{{ asset('storage/' . $sertifikat->file_path) }}" target="_blank"
                                    class="text-[10px] text-primary hover:underline flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">visibility</span>
                                    Lihat File
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-amber-100 text-amber-700',
                                            'verified' => 'bg-emerald-100 text-emerald-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                        ];

                                        $statusLabels = [
                                            'pending' => 'Pending',
                                            'verified' => 'Terverifikasi',
                                            'rejected' => 'Ditolak',
                                        ];

                                        $rawStatus = $sertifikat->status ?? 'pending';
                                        $class = $statusClasses[$rawStatus] ?? 'bg-slate-100 text-slate-700';
                                        $label = $statusLabels[$rawStatus] ?? $rawStatus;
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $class }}">
                                        {{ $label }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2 text-center">
                                    <!-- View, Download, Print Actions -->
                                    <a href="{{ asset('storage/' . $sertifikat->file_path) }}" target="_blank"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </a>
                                    <a href="{{ asset('storage/' . $sertifikat->file_path) }}"
                                        download="{{ $sertifikat->nama_sertifikat }}"
                                        class="p-2 text-slate-600 hover:bg-slate-50 rounded-lg transition-colors" title="Unduh">
                                        <span class="material-symbols-outlined">download</span>
                                    </a>
                                    <button onclick="printCertificate('{{ asset('storage/' . $sertifikat->file_path) }}')"
                                        class="p-2 text-slate-600 hover:bg-slate-50 rounded-lg transition-colors" title="Cetak">
                                        <span class="material-symbols-outlined">print</span>
                                    </button>

                                    <div class="w-px h-8 bg-slate-200 dark:bg-slate-700 mx-1"></div>

                                    @if($sertifikat->status != 'verified')
                                        <a href="{{ route('messages.show', $sertifikat->user_id) }}"
                                            class="p-2 text-primary hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Chat Pemilik">
                                            <span class="material-symbols-outlined">chat</span>
                                        </a>
                                        <form action="{{ route('admin.verification.certificates.approve', $sertifikat->id_sertifikat) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                data-name="{{ $sertifikat->user->talent->nama_lengkap ?? $sertifikat->user->name }}"
                                                onclick="confirmVerification(event, this.getAttribute('data-name'))"
                                                class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors"
                                                title="Setujui">
                                                <span class="material-symbols-outlined">check_circle</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.verification.certificates.reject', $sertifikat->id_sertifikat) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Tolak">
                                                <span class="material-symbols-outlined">cancel</span>
                                            </button>
                                        </form>
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
        </div>
    </div>
@endsection