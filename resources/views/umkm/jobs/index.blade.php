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
                <div onclick="showJobDetail({{ $loop->index }})"
                    class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-800 hover:shadow-md transition-all cursor-pointer group relative">
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="px-3 py-1 bg-{{ $job->status == 'Aktif' ? 'emerald' : 'slate' }}-100 text-{{ $job->status == 'Aktif' ? 'emerald' : 'slate' }}-700 rounded-full text-[10px] font-bold uppercase">
                            {{ $job->status }}
                        </div>
                    </div>
                    <h3 class="font-bold text-lg mb-1 group-hover:text-primary transition-colors">{{ $job->judul }}</h3>
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
                    <div class="flex gap-2 relative z-10">
                        <a href="{{ route('umkm.jobs.edit', $job->id_lowongan) }}" onclick="event.stopPropagation()"
                            class="flex-1 text-center py-2 bg-slate-100 dark:bg-slate-800 rounded-lg text-sm font-bold hover:bg-slate-200 transition-colors">
                            Edit
                        </a>
                        <form action="{{ route('umkm.jobs.destroy', $job->id_lowongan) }}" method="POST" class="flex-1"
                            onsubmit="return confirm('Hapus lowongan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="event.stopPropagation()"
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

    <!-- Job Detail Modal -->
    <div id="jobDetailModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300 opacity-0" id="modalBackdrop" onclick="closeJobModal()"></div>
        <div class="relative bg-white dark:bg-slate-900 rounded-3xl w-full max-w-2xl mx-4 shadow-2xl overflow-hidden transform scale-95 transition-all duration-300 opacity-0" id="modalContent">
            <!-- Content injected by JS -->
        </div>
    </div>

    <script>
        const jobs = @json($jobs);

        function showJobDetail(index) {
            const job = jobs[index];
            const modal = document.getElementById('jobDetailModal');
            const backdrop = document.getElementById('modalBackdrop');
            const content = document.getElementById('modalContent');
            
            // Format Description (handle newlines)
            const description = job.deskripsi ? job.deskripsi.replace(/\n/g, '<br>') : 'Tidak ada deskripsi';

            // Populate content
            content.innerHTML = `
                <div class="p-6 md:p-8 max-h-[80vh] overflow-y-auto custom-scrollbar">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <div class="inline-flex px-3 py-1 bg-${job.status === 'Aktif' ? 'emerald' : 'slate'}-100 text-${job.status === 'Aktif' ? 'emerald' : 'slate'}-700 rounded-full text-xs font-bold uppercase mb-3">
                                ${job.status}
                            </div>
                            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">${job.judul}</h3>
                            <div class="flex flex-wrap items-center text-slate-500 text-sm gap-4">
                                <span class="flex items-center gap-1.5 bg-slate-50 dark:bg-slate-800/50 px-2.5 py-1 rounded-lg">
                                    <span class="material-symbols-outlined text-[18px]">location_on</span>
                                    ${job.lokasi}
                                </span>
                                <span class="flex items-center gap-1.5 bg-slate-50 dark:bg-slate-800/50 px-2.5 py-1 rounded-lg">
                                    <span class="material-symbols-outlined text-[18px]">work_history</span>
                                    ${job.sistem_kerja || 'WFO'}
                                </span>
                                <span class="flex items-center gap-1.5 bg-slate-50 dark:bg-slate-800/50 px-2.5 py-1 rounded-lg">
                                    <span class="material-symbols-outlined text-[18px]">schedule</span>
                                    ${job.tipe_pekerjaan}
                                </span>
                                <span class="flex items-center gap-1.5 bg-slate-50 dark:bg-slate-800/50 px-2.5 py-1 rounded-lg">
                                    <span class="material-symbols-outlined text-[18px]">payments</span>
                                    ${job.gaji || 'Kompetitif'}
                                </span>
                            </div>
                        </div>
                        <button onclick="closeJobModal()" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors flex-shrink-0">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    
                    <div class="prose dark:prose-invert max-w-none">
                        <h4 class="text-lg font-bold mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined">description</span>
                            Deskripsi Pekerjaan
                        </h4>
                        <div class="text-slate-600 dark:text-slate-300 leading-relaxed text-sm">${description}</div>
                    </div>

                    ${job.fasilitas ? `
                    <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800">
                        <h4 class="text-lg font-bold mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined">redeem</span>
                            Fasilitas & Benefit
                        </h4>
                        <div class="text-slate-600 dark:text-slate-300 leading-relaxed text-sm whitespace-pre-line">${job.fasilitas}</div>
                    </div>
                    ` : ''}
                </div>
                <div class="bg-slate-50 dark:bg-slate-800/50 p-6 border-t border-slate-200 dark:border-slate-800 flex justify-end gap-3 sticky bottom-0">
                    <button onclick="closeJobModal()" class="px-5 py-2.5 font-bold text-slate-600 hover:bg-slate-200 dark:text-slate-300 dark:hover:bg-slate-700 rounded-xl transition-colors">Tutup</button>
                    <a href="/umkm/jobs/${job.id}/edit" class="px-6 py-2.5 font-bold bg-primary text-white rounded-xl hover:bg-blue-600 transition-colors shadow-lg shadow-primary/20 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                        Edit Lowongan
                    </a>
                </div>
            `;

            modal.classList.remove('hidden');
            // Animation start
            requestAnimationFrame(() => {
                backdrop.classList.remove('opacity-0');
                content.classList.remove('opacity-0', 'scale-95');
                content.classList.add('scale-100');
            });
            
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeJobModal() {
            const modal = document.getElementById('jobDetailModal');
            const backdrop = document.getElementById('modalBackdrop');
            const content = document.getElementById('modalContent');
            
            backdrop.classList.add('opacity-0');
            content.classList.remove('scale-100');
            content.classList.add('opacity-0', 'scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }

        // Close on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closeJobModal();
            }
        });
    </script>
@endsection