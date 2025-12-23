@extends('layouts.dashboard')

@section('title', 'Notifikasi - Digital Skill Passport')

@section('header_title', 'Notifikasi')

@section('sidebar')
    @if(Auth::user()->role == 'admin')
        @include('layouts.partials.sidebar-admin')
    @elseif(Auth::user()->role == 'talent')
        @include('layouts.partials.sidebar-talent')
    @elseif(Auth::user()->role == 'umkm')
        @include('layouts.partials.sidebar-umkm')
    @endif
@endsection

@section('content')
    <div class="max-w-4xl mx-auto space-y-6 pb-12">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Notifikasi Anda</h2>
            @if($unreadCount > 0)
                <form action="{{ route('notifications.read_all') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-primary hover:underline">Tandai semua telah
                        dibaca</button>
                </form>
            @endif
        </div>

        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="divide-y divide-slate-100 dark:divide-slate-700">
                @forelse($notifications as $notif)
                    <div
                        class="p-6 transition-colors hover:bg-slate-50 dark:hover:bg-slate-700/50 flex gap-4 {{ !$notif->is_read ? 'bg-blue-50/30 dark:bg-blue-900/10' : '' }}">
                        <div class="size-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined">{{ $notif->icon ?? 'notifications' }}</span>
                        </div>
                        <div class="flex-1 space-y-1">
                            <div class="flex items-center justify-between">
                                <h3 class="font-bold text-slate-900 dark:text-white">{{ $notif->judul }}</h3>
                                <span
                                    class="text-[10px] text-slate-400 font-bold uppercase">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ $notif->pesan }}
                            </p>
                            @if($notif->link)
                                <a href="{{ route('notifications.read', $notif->id) }}"
                                    class="inline-block mt-2 text-primary text-xs font-bold hover:underline">Lihat Detail &rarr;</a>
                            @endif
                        </div>
                        @if(!$notif->is_read)
                            <div class="size-2 bg-primary rounded-full mt-2"></div>
                        @endif
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-20 text-center space-y-4">
                        <div
                            class="size-20 bg-slate-100 dark:bg-slate-700/50 rounded-full flex items-center justify-center text-slate-300">
                            <span class="material-symbols-outlined text-5xl">notifications_off</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white">Belum ada notifikasi</h3>
                            <p class="text-sm text-slate-500">Kami akan memberi tahu Anda di sini jika ada pembaruan penting.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection