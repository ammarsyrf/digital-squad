<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Sertifikat - Digital Skill Passport</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-emerald-600 text-3xl mr-2">verified_user</span>
                    <h1 class="font-bold text-xl tracking-tight">Digital Skill Passport</h1>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-grow flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            
            <div class="relative h-32 bg-gradient-to-r from-blue-600 to-indigo-700">
                <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2">
                    <div class="w-24 h-24 bg-white rounded-full p-1 shadow-lg">
                        <div class="w-full h-full rounded-full bg-gray-100 flex items-center justify-center overflow-hidden">
                             @if($sertifikat->user->talent && $sertifikat->user->talent->foto)
                                <img src="{{ asset('storage/'.$sertifikat->user->talent->foto) }}" class="w-full h-full object-cover">
                             @else
                                <span class="material-symbols-outlined text-4xl text-gray-400">person</span>
                             @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-16 pb-8 px-8 text-center">
                @if(strtolower($sertifikat->status) == 'verified' || strtolower($sertifikat->status) == 'valid')
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-full font-bold text-sm mb-6 border border-emerald-100">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        SERTIFIKAT VALID
                    </div>
                @else
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-700 rounded-full font-bold text-sm mb-6 border border-amber-100">
                        <span class="material-symbols-outlined text-lg">warning</span>
                        MENUNGGU VERIFIKASI
                    </div>
                @endif

                <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $sertifikat->nama_sertifikat }}</h2>
                <p class="text-gray-500 text-sm mb-6">Diterbitkan oleh <span class="font-semibold text-gray-700">{{ $sertifikat->penerbit }}</span></p>

                <div class="space-y-4 text-left bg-gray-50 rounded-xl p-5 mb-6">
                    <div>
                        <p class="text-xs uppercase text-gray-400 font-bold tracking-wider mb-1">Pemilik Sertifikat</p>
                        <p class="font-medium text-gray-900">{{ $sertifikat->user->talent->nama_lengkap ?? $sertifikat->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-400 font-bold tracking-wider mb-1">Tanggal Terbit</p>
                        <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->isoFormat('D MMMM Y') }}</p>
                    </div>
                    <div>
                         <p class="text-xs uppercase text-gray-400 font-bold tracking-wider mb-1">ID Verifikasi</p>
                         <p class="font-mono text-sm text-gray-600 truncate">{{ md5($sertifikat->id . $sertifikat->created_at) }}</p>
                    </div>
                </div>

                <a href="{{ asset('storage/' . $sertifikat->file_path) }}" target="_blank" class="block w-full py-3 px-4 bg-gray-900 hover:bg-gray-800 text-white rounded-xl font-medium transition-colors">
                    Lihat Dokumen Asli
                </a>
            </div>
            
            <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-400">Verifikasi keaslian sertifikat ini dilakukan melalui sistem Digital Skill Passport.</p>
            </div>
        </div>
    </main>

</body>
</html>
