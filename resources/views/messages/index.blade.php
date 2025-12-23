@extends('layouts.dashboard')

@section('title', 'Pesan - Digital Skill Passport')

@section('header_title', 'Pesan')

@section('sidebar')
    @if(Auth::user()->role == 'admin')
        @include('layouts.partials.sidebar-admin')
    @elseif(Auth::user()->role == 'talent')
        @include('layouts.partials.sidebar-talent')
    @else
        @include('layouts.partials.sidebar-umkm')
    @endif
@endsection

@section('content')
    <div
        class="h-[calc(100vh-140px)] flex bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <!-- Chat List -->
        <div class="w-full md:w-80 border-r border-slate-200 dark:border-slate-800 flex flex-col">
            <div class="p-4 border-b border-slate-200 dark:border-slate-800">
                <h3 class="font-bold text-lg">Pesan</h3>
            </div>
            <div class="flex-1 overflow-y-auto">
                @forelse($contacts as $contact)
                    @php
                        $photoUrl = null;
                        $displayRole = $contact->role;
                        $displayName = $contact->name;

                        if ($contact->role == 'talent' && $contact->talent) {
                            $photoUrl = $contact->talent->foto ? asset('storage/' . $contact->talent->foto) : null;
                            $displayName = $contact->talent->nama_lengkap ?? $contact->name;
                        } elseif ($contact->role == 'umkm' && $contact->umkm) {
                            $photoUrl = $contact->umkm->logo ? asset('storage/' . $contact->umkm->logo) : null;
                            $displayName = $contact->umkm->nama_umkm ?? $contact->name;
                            $displayRole = 'Instansi';
                        }
                    @endphp
                    <a href="{{ route('messages.show', $contact->id) }}"
                        class="flex items-center gap-4 p-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors border-b border-slate-50 dark:border-slate-800/50">
                        <div
                            class="size-12 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0 border border-primary/20 overflow-hidden">
                            @if($photoUrl)
                                <img src="{{ $photoUrl }}" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined">{{ $contact->role == 'umkm' ? 'business' : ($contact->role == 'admin' ? 'admin_panel_settings' : 'person') }}</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <h4 class="font-bold text-sm truncate text-slate-900 dark:text-white">{{ $displayName }}</h4>
                                <span
                                    class="text-[10px] text-slate-400">{{ $contact->last_message->created_at->format('H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-500 font-bold uppercase">{{ $displayRole }}</span>
                                <p class="text-xs text-slate-500 truncate flex-1">{{ $contact->last_message->pesan }}</p>
                            </div>
                        </div>
                        @if($contact->unread_count > 0)
                            <div
                                class="size-4 bg-primary text-white text-[10px] flex items-center justify-center rounded-full font-bold">
                                {{ $contact->unread_count }}
                            </div>
                        @endif
                    </a>
                @empty
                    <div class="p-8 text-center text-slate-500">
                        <span class="material-symbols-outlined text-4xl mb-2 opacity-20">chat_bubble</span>
                        <p class="text-sm">Belum ada percakapan.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Empty State for Desktop -->
        <div class="hidden md:flex flex-1 items-center justify-center bg-slate-50/50 dark:bg-slate-900/50">
            <div class="text-center max-w-sm">
                <div class="size-20 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-4xl">chat</span>
                </div>
                <h3 class="text-xl font-bold mb-2">Mulai Komunikasi</h3>
                <p class="text-slate-500 mb-6">Pilih salah satu kontak di samping untuk mulai berkirim pesan dengan instansi atau
                    talenta.</p>
                @if(Auth::user()->role !== 'admin')
                    <a href="{{ route('messages.show', \App\Models\User::where('role', 'admin')->first()->id ?? 1) }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined">contact_support</span>
                        Hubungi Admin
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection