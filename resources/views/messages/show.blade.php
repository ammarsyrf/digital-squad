@extends('layouts.dashboard')

@section('title', 'Chat dengan ' . $user->name . ' - Digital Skill Passport')

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
        <!-- Chat List Sidebar (Hidden on mobile when chat is open) -->
        <div class="hidden md:flex w-80 border-r border-slate-200 dark:border-slate-800 flex-col shrink-0">
            <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
                <h3 class="font-bold text-lg">Pesan</h3>
                <a href="{{ route(Auth::user()->role . '.messages') }}" class="text-xs text-primary font-bold">Semua</a>
            </div>
            <div class="flex-1 overflow-y-auto">
                @foreach($contacts as $contact)
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
                        class="flex items-center gap-4 p-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors {{ $contact->id == $user->id ? 'bg-primary/5 border-l-4 border-primary' : 'border-b border-slate-50 dark:border-slate-800/50' }}">
                        <div
                            class="size-10 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0 border border-primary/20 overflow-hidden">
                            @if($photoUrl)
                                <img src="{{ $photoUrl }}" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-[18px]">{{ $contact->role == 'umkm' ? 'business' : ($contact->role == 'admin' ? 'admin_panel_settings' : 'person') }}</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <h4 class="font-bold text-xs truncate">{{ $displayName }}</h4>
                            </div>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[8px] px-1 py-0.2 rounded bg-slate-100 dark:bg-slate-800 text-slate-500 font-bold uppercase shrink-0">{{ $displayRole }}</span>
                                <p class="text-[10px] text-slate-500 truncate mt-0.5">{{ $contact->last_message->pesan }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Active Chat -->
        <div class="flex-1 flex flex-col min-w-0 bg-slate-50/30 dark:bg-slate-900/30">
            <!-- Chat Header -->
            <div
                class="p-4 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <a href="{{ route(Auth::user()->role . '.messages') }}" class="md:hidden p-2 -ml-2 text-slate-500">
                        <span class="material-symbols-outlined">arrow_back</span>
                    </a>
                    @php
                        $headerPhoto = null;
                        $headerRole = $user->role;
                        $headerName = $user->name;

                        if ($user->role == 'talent' && $user->talent) {
                            $headerPhoto = $user->talent->foto ? asset('storage/' . $user->talent->foto) : null;
                            $headerName = $user->talent->nama_lengkap ?? $user->name;
                        } elseif ($user->role == 'umkm' && $user->umkm) {
                            $headerPhoto = $user->umkm->logo ? asset('storage/' . $user->umkm->logo) : null;
                            $headerName = $user->umkm->nama_umkm ?? $user->name;
                            $headerRole = 'Instansi';
                        }
                    @endphp
                    <div class="size-10 rounded-full bg-primary text-white flex items-center justify-center shadow-md overflow-hidden">
                        @if($headerPhoto)
                            <img src="{{ $headerPhoto }}" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined">{{ $user->role == 'umkm' ? 'business' : ($user->role == 'admin' ? 'admin_panel_settings' : 'person') }}</span>
                        @endif
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white leading-tight">{{ $headerName }}</h4>
                        <p class="text-[10px] text-slate-400 flex items-center gap-1 uppercase font-bold tracking-wider">
                            <span class="size-1.5 bg-emerald-500 rounded-full shadow-[0_0_5px_rgba(16,185,129,0.5)]"></span>
                            {{ $headerRole }} • Online
                        </p>
                    </div>
                </div>
            </div>

            <!-- Messages Area -->
            <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4 scroll-smooth">
                @foreach($messages as $msg)
                    @if($msg->sender_id == Auth::id())
                        <!-- User Message -->
                        <div class="flex justify-end">
                            <div class="max-w-[70%] lg:max-w-[60%] flex flex-col items-end">
                                <div class="bg-primary text-white p-3 rounded-2xl rounded-tr-none shadow-sm shadow-primary/20">
                                    <p class="text-sm">{{ $msg->pesan }}</p>
                                </div>
                                <span class="text-[10px] text-slate-400 mt-1">{{ $msg->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    @else
                        <!-- Contact Message -->
                        <div class="flex justify-start">
                            <div class="max-w-[70%] lg:max-w-[60%] flex flex-col items-start">
                                <div
                                    class="bg-white dark:bg-slate-800 text-slate-900 dark:text-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 dark:border-slate-700">
                                    <p class="text-sm">{{ $msg->pesan }}</p>
                                </div>
                                <span class="text-[10px] text-slate-400 mt-1">{{ $msg->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Input Area -->
            <div class="p-4 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
                <form action="{{ route('messages.send') }}" method="POST" class="flex gap-3">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                    <div class="flex-1 relative">
                        <input type="text" name="pesan" placeholder="Ketik pesan..." required autofocus
                            class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                    </div>
                    <button type="submit"
                        class="bg-primary text-white size-11 rounded-xl flex items-center justify-center hover:bg-blue-600 active:scale-95 transition-all shadow-lg shadow-primary/30">
                        <span class="material-symbols-outlined">send</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Scroll to bottom on load
        const msgArea = document.getElementById('chat-messages');
        msgArea.scrollTop = msgArea.scrollHeight;
    </script>
@endsection