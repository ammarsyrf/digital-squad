@extends('layouts.dashboard')

@section('title', 'Detail Sertifikat - Digital Skill Passport')

@section('header_title', 'Detail Sertifikat')

@section('sidebar')
    @include('layouts.partials.sidebar-talent')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const qrContainer = document.getElementById('qrcode');
            if (qrContainer) {
                const url = qrContainer.getAttribute('data-url');
                QRCode.toCanvas(qrContainer, url, {
                    width: 200,
                    margin: 2,
                    color: {
                        dark: '#000000',
                        light: '#ffffff'
                    }
                }, function (error) {
                    if (error) console.error(error)
                    console.log('QR code generated!');
                });
            }
        });
    </script>
@endpush

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Back Button -->
        <a href="{{ route('talent.certificates') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-primary transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
            <span>Kembali ke Koleksi</span>
        </a>

        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3">
                <!-- Left: Certificate Preview -->
                <div class="lg:col-span-2 bg-slate-100 dark:bg-slate-900 border-b lg:border-b-0 lg:border-r border-slate-200 dark:border-slate-700 p-8 flex items-center justify-center">
                    @php
                        $ext = pathinfo($sertifikat->file_path, PATHINFO_EXTENSION);
                    @endphp
                    @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                        <img src="{{ asset('storage/' . $sertifikat->file_path) }}" alt="{{ $sertifikat->nama_sertifikat }}" class="max-w-full max-h-[500px] shadow-lg rounded-lg">
                    @else
                        <div class="text-center p-12">
                            <span class="material-symbols-outlined text-9xl text-slate-300">description</span>
                            <p class="text-xl font-bold text-slate-500 mt-4 uppercase">{{ $ext }} Document</p>
                            <a href="{{ asset('storage/' . $sertifikat->file_path) }}" target="_blank" class="inline-block mt-4 text-primary hover:underline">
                                Buka File Asli
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Right: Details & QR -->
                <div class="p-8 space-y-8">
                    <div>
                        <div class="flex items-start justify-between mb-4">
                            <span class="px-3 py-1 text-xs font-bold uppercase rounded-full tracking-wider
                                @if(strtolower($sertifikat->status) == 'verified' || strtolower($sertifikat->status) == 'valid') bg-emerald-100 text-emerald-700 
                                @elseif(strtolower($sertifikat->status) == 'pending') bg-amber-100 text-amber-700 
                                @else bg-rose-100 text-rose-700 @endif">
                                {{ $sertifikat->status }}
                            </span>
                        </div>
                        
                        <h1 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">{{ $sertifikat->nama_sertifikat }}</h1>
                        <div class="flex items-center gap-2 text-slate-500">
                            <span class="material-symbols-outlined text-sm">business</span>
                            <span class="font-medium">{{ $sertifikat->penerbit }}</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <p class="text-xs uppercase text-slate-400 font-bold mb-1">Tanggal Terbit</p>
                            <p class="text-slate-700 dark:text-slate-300 font-medium">{{ \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->format('d F Y') }}</p>
                        </div>
                        
                        @if($sertifikat->deskripsi)
                        <div>
                            <p class="text-xs uppercase text-slate-400 font-bold mb-1">Deskripsi</p>
                            <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">{{ $sertifikat->deskripsi }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- OR Code Section -->
                    @if(strtolower($sertifikat->status) == 'verified' || strtolower($sertifikat->status) == 'valid')
                        <div class="pt-6 border-t border-slate-100 dark:border-slate-700">
                            <h3 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">qr_code_2</span>
                                QR Code Validasi
                            </h3>
                            <div class="bg-white p-4 rounded-xl border border-slate-200 inline-block shadow-sm">
                                <canvas id="qrcode" data-url="{{ $verificationUrl }}"></canvas>
                            </div>
                            <p class="text-xs text-slate-400 mt-3 leading-relaxed">
                                Scan QR Code ini untuk memverifikasi keaslian sertifikat di sistem Digital Skill Passport.
                            </p>
                             <div class="mt-4">
                                <a href="{{ $verificationUrl }}" target="_blank" class="text-xs text-primary hover:underline flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">open_in_new</span>
                                    Buka Halaman Validasi
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="pt-6 border-t border-slate-100 dark:border-slate-700">
                            <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 flex gap-3 text-amber-800">
                                <span class="material-symbols-outlined shrink-0">info</span>
                                <p class="text-sm">QR Code validasi hanya tersedia untuk sertifikat yang telah diverifikasi (Valid).</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
