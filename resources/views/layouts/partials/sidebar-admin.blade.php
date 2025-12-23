<!-- Sidebar Navigation -->
<aside
    class="hidden md:flex flex-col w-72 bg-surface-light dark:bg-surface-dark border-r border-slate-200 dark:border-slate-700 h-full shrink-0 transition-colors duration-300">
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
    <div class="flex flex-col gap-1 px-4 mt-4">
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-all"
            href="{{ route('admin.dashboard') }}">
            <span class="material-symbols-outlined filled">dashboard</span>
            <span class="text-sm font-semibold">Beranda</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.messages') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors group relative"
            href="{{ route('admin.messages') }}">
            <div class="relative">
                <span class="material-symbols-outlined group-hover:text-primary transition-colors">chat</span>
                @php
                    $unreadMessages = \App\Models\Pesan::where('receiver_id', Auth::id())->where('is_read', 0)->count();
                @endphp
                @if($unreadMessages > 0)
                    <span
                        class="absolute -top-2 -right-2 size-4 bg-primary text-white text-[8px] font-bold flex items-center justify-center rounded-full border-2 border-white dark:border-slate-700">
                        {{ $unreadMessages > 9 ? '9+' : $unreadMessages }}
                    </span>
                @endif
            </div>
            <span class="text-sm font-medium">Pesan</span>
        </a>
        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Verifikasi</div>
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.verification.certificates') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors group"
            href="{{ route('admin.verification.certificates') }}">
            <span
                class="material-symbols-outlined group-hover:text-primary transition-colors">approval_delegation</span>
            <span class="text-sm font-medium">Verifikasi Sertifikat</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.verification.umkm') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors group"
            href="{{ route('admin.verification.umkm') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors">storefront</span>
            <span class="text-sm font-medium">Verifikasi Akun UMKM</span>
        </a>
        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Manajemen</div>
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.users') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors group"
            href="{{ route('admin.users') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors">group</span>
            <span class="text-sm font-medium">Kelola User</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.skill-tests') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors group"
            href="{{ route('admin.skill-tests') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors">quiz</span>
            <span class="text-sm font-medium">Kelola Tes Skill</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.skill-categories') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors group"
            href="{{ route('admin.skill-categories') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors">category</span>
            <span class="text-sm font-medium">Kelola Kategori Skill</span>
        </a>
    </div>
</aside>