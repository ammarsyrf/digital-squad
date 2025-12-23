<!-- Side Navigation -->
<aside
    class="w-72 bg-white dark:bg-slate-900 bg-gradient-to-b from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 border-r border-slate-200 dark:border-slate-800 flex-shrink-0 flex flex-col hidden md:flex transition-all duration-300 h-full">
    <div class="p-4">
        <div
            class="relative overflow-hidden bg-gradient-to-br from-primary/20 via-primary/10 to-transparent p-4 rounded-2xl border border-primary/10 backdrop-blur-sm group hover:border-primary/30 transition-all duration-500">
            <div class="flex items-center gap-3">
                <div
                    class="h-10 w-10 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/30 group-hover:scale-110 transition-transform duration-500">
                    <span class="material-symbols-outlined text-2xl">verified</span>
                </div>
                <div class="flex flex-col">
                    <h1 class="text-slate-900 dark:text-white text-base font-black tracking-tight leading-none">Skill
                        Passport</h1>
                        <p class="text-primary text-[10px] font-bold uppercase tracking-widest mt-1">Digital Squad</p>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col gap-2 px-4 flex-1 mt-4">
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('umkm.dashboard') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }} group transition-colors"
            href="{{ route('umkm.dashboard') }}">
            <span
                class="material-symbols-outlined {{ request()->routeIs('umkm.dashboard') ? 'fill' : '' }}">grid_view</span>
            <p class="text-sm font-semibold leading-normal">Beranda</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('umkm.messages') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }} transition-colors relative"
            href="{{ route('umkm.messages') }}">
            <div class="relative">
                <span class="material-symbols-outlined">chat</span>
                @php
                    $unreadMessages = \App\Models\Pesan::where('receiver_id', Auth::id())->where('is_read', 0)->count();
                @endphp
                @if($unreadMessages > 0)
                    <span
                        class="absolute -top-2 -right-2 size-4 bg-primary text-white text-[8px] font-bold flex items-center justify-center rounded-full border-2 border-white dark:border-slate-900">
                        {{ $unreadMessages > 9 ? '9+' : $unreadMessages }}
                    </span>
                @endif
            </div>
            <p class="text-sm font-medium leading-normal">Pesan</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('umkm.jobs') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }} transition-colors"
            href="{{ route('umkm.jobs') }}">
            <span class="material-symbols-outlined">work</span>
            <p class="text-sm font-medium leading-normal">Kelola Lowongan</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('umkm.applicants') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }} transition-colors"
            href="{{ route('umkm.applicants') }}">
            <span class="material-symbols-outlined">group</span>
            <p class="text-sm font-medium leading-normal">Lihat Pelamar</p>
        </a>
    </div>
    <div class="p-4 border-t border-slate-200 dark:border-slate-800 mt-auto space-y-2">
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors group"
            href="{{ route('messages.show', \App\Models\User::where('role', 'admin')->first()->id ?? 1) }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors">contact_support</span>
            <p class="text-sm font-medium leading-normal">Bantuan Ke Admin</p>
        </a>
    </div>
</aside>