<!-- Side Navigation -->
<aside
    class="w-72 bg-white dark:bg-slate-800 bg-gradient-to-b from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 border-r border-slate-200 dark:border-slate-700 h-full hidden md:flex flex-col shrink-0 transition-all duration-300">
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
    <nav class="flex-1 px-4 py-4 space-y-1">
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->routeIs('talent.dashboard') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700' }} group"
            href="{{ route('talent.dashboard') }}">
            <span class="material-symbols-outlined" style="font-size: 24px;">dashboard</span>
            <span class="text-sm font-medium">Beranda</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->routeIs('talent.messages') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700' }} group transition-colors relative"
            href="{{ route('talent.messages') }}">
            <div class="relative">
                <span class="material-symbols-outlined group-hover:text-primary transition-colors"
                    style="font-size: 24px;">chat</span>
                @php
                    $unreadMessages = \App\Models\Pesan::where('receiver_id', Auth::id())->where('is_read', 0)->count();
                @endphp
                @if($unreadMessages > 0)
                    <span
                        class="absolute -top-1 -right-1 size-4 bg-primary text-white text-[8px] font-bold flex items-center justify-center rounded-full border-2 border-white dark:border-slate-800">
                        {{ $unreadMessages > 9 ? '9+' : $unreadMessages }}
                    </span>
                @endif
            </div>
            <span class="text-sm font-medium">Pesan</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->routeIs('talent.skill-tests') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700' }} group transition-colors"
            href="{{ route('talent.skill-tests') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors"
                style="font-size: 24px;">quiz</span>
            <span class="text-sm font-medium">Tes Skill</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->routeIs('talent.certificates') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700' }} group transition-colors"
            href="{{ route('talent.certificates') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors"
                style="font-size: 24px;">school</span>
            <span class="text-sm font-medium">Sertifikat</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->routeIs('talent.jobs') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700' }} group transition-colors"
            href="{{ route('talent.jobs') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors"
                style="font-size: 24px;">work</span>
            <span class="text-sm font-medium">Cari Lowongan</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->routeIs('talent.applications') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700' }} group transition-colors"
            href="{{ route('talent.applications') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors"
                style="font-size: 24px;">assignment</span>
            <span class="text-sm font-medium">Riwayat Lamaran</span>
        </a>
    </nav>
    <div class="p-4 border-t border-slate-200 dark:border-slate-700 space-y-2">
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 group transition-colors"
            href="{{ route('messages.show', \App\Models\User::where('role', 'admin')->first()->id ?? 1) }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors"
                style="font-size: 24px;">contact_support</span>
            <span class="text-sm font-medium">Bantuan Ke Admin</span>
        </a>
    </div>
</aside>