<header
    class="h-16 flex items-center justify-between px-6 lg:px-8 bg-surface-light dark:bg-surface-dark border-b border-slate-200 dark:border-slate-700 shrink-0 z-50">
    <div class="flex items-center gap-4">
        <!-- Mobile Menu Toggle -->
        <button
            class="md:hidden p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-300">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <h2 class="text-lg font-bold text-slate-800 dark:text-white hidden sm:block">
            @yield('header_title', 'Beranda')
        </h2>
    </div>

    <div class="flex items-center gap-4 lg:gap-6">
        <!-- Search Bar -->
        @php
            $searchRoute = '#';
            if (Auth::user()->role == 'talent')
                $searchRoute = route('talent.jobs');
            elseif (Auth::user()->role == 'umkm')
                $searchRoute = route('umkm.jobs');
            elseif (Auth::user()->role == 'admin')
                $searchRoute = route('admin.users');
        @endphp
        <form action="{{ $searchRoute }}" method="GET"
            class="hidden sm:flex items-center h-10 w-64 bg-slate-100 dark:bg-slate-900/50 border border-transparent dark:border-slate-700 rounded-lg px-3 focus-within:ring-2 focus-within:ring-primary/50 transition-all">
            <span class="material-symbols-outlined text-slate-400">search</span>
            <input name="q" value="{{ request('q') }}"
                class="bg-transparent border-none text-sm w-full focus:ring-0 text-slate-700 dark:text-slate-200 placeholder-slate-400 ml-2"
                placeholder="Cari..." type="text" />
        </form>

        <!-- Notifications -->
        @php
            $unreadCount = \App\Models\Notifikasi::where('user_id', Auth::id())->where('is_read', false)->count();
            $recentNotifs = \App\Models\Notifikasi::where('user_id', Auth::id())->orderBy('created_at', 'desc')->take(5)->get();
        @endphp
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="relative size-10 flex items-center justify-center rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-300 transition-colors">
                <span
                    class="material-symbols-outlined {{ $unreadCount > 0 ? 'filled text-primary' : '' }}">notifications</span>
                @if($unreadCount > 0)
                    <span
                        class="absolute -top-1 -right-1 size-5 bg-red-500 text-white text-[10px] font-bold flex items-center justify-center rounded-full border-2 border-surface-light dark:border-surface-dark animate-pulse">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
                @endif
            </button>
            <div x-show="open" @click.away="open = false"
                class="absolute right-0 mt-2 w-80 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-200 dark:border-slate-700 z-50 overflow-hidden"
                style="display: none;" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100">
                <div
                    class="p-4 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50 dark:bg-slate-800/50">
                    <h3 class="font-bold text-sm">Notifikasi</h3>
                    @php
                        $notifRoute = '#';
                        if (Auth::user()->role == 'talent')
                            $notifRoute = route('talent.notifications');
                        elseif (Auth::user()->role == 'umkm')
                            $notifRoute = route('umkm.notifications');
                        elseif (Auth::user()->role == 'admin')
                            $notifRoute = route('admin.notifications');
                    @endphp
                    <div class="flex items-center gap-3">
                        @if($unreadCount > 0)
                            <form action="{{ route('notifications.read_all') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[10px] text-slate-400 hover:text-primary font-bold">Baca
                                    Semua</button>
                            </form>
                        @endif
                        <a href="{{ $notifRoute }}" class="text-[10px] text-primary font-bold hover:underline">Lihat
                            Semua</a>
                    </div>
                </div>
                <div class="divide-y divide-slate-50 dark:divide-slate-700 max-h-96 overflow-y-auto">
                    @forelse($recentNotifs as $notif)
                        <a href="{{ route('notifications.read', $notif->id_notifikasi) }}"
                            class="block p-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors {{ !$notif->is_read ? 'bg-blue-50/30 dark:bg-blue-900/10' : '' }}">
                            <p class="text-xs font-bold text-slate-900 dark:text-white">{{ $notif->judul }}</p>
                            <p class="text-[10px] text-slate-500 line-clamp-2 mt-1">{{ $notif->pesan }}</p>
                            <p class="text-[8px] text-slate-400 mt-2 font-bold uppercase">
                                {{ $notif->created_at->diffForHumans() }}
                            </p>
                        </a>
                    @empty
                        <div class="p-8 text-center text-slate-500 text-sm italic">Belum ada notifikasi baru.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">

            <!-- User Profile Dropdown -->
            <div class="relative ml-2" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center gap-3 p-1 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    <div
                        class="size-8 rounded-full bg-primary/10 text-primary flex items-center justify-center border border-primary/20 overflow-hidden">
                        @php
                            $user = Auth::user();
                            $photoUrl = null;
                            if ($user->role == 'talent' && $user->talent && $user->talent->foto) {
                                $photoUrl = asset('storage/' . $user->talent->foto);
                            } elseif ($user->role == 'umkm' && $user->umkm && $user->umkm->logo) {
                                $photoUrl = asset('storage/' . $user->umkm->logo);
                            }
                        @endphp

                        @if($photoUrl)
                            <img src="{{ $photoUrl }}" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined">person</span>
                        @endif
                    </div>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-800 rounded-xl shadow-2xl border border-slate-200 dark:border-slate-700 z-[60] overflow-hidden"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100" style="display: none;">
                    <div class="p-4 border-b border-slate-100 dark:border-slate-700">
                        <p class="text-sm font-bold truncate">{{ Auth::user()->name ?? 'User' }}</p>
                        <p class="text-xs text-slate-500 truncate capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="p-2">
                        @if(Auth::user()->role == 'talent')
                            <a href="{{ route('talent.profile') }}"
                                class="flex items-center gap-3 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-[18px]">account_circle</span>
                                <span>Profil Saya</span>
                            </a>
                            <a href="{{ route('talent.settings') }}"
                                class="flex items-center gap-3 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-[18px]">settings</span>
                                <span>Pengaturan Akun</span>
                            </a>
                        @elseif(Auth::user()->role == 'umkm')
                            <a href="{{ route('umkm.profile') }}"
                                class="flex items-center gap-3 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-[18px]">business</span>
                                <span>Profil Instansi</span>
                            </a>
                            <a href="{{ route('umkm.settings') }}"
                                class="flex items-center gap-3 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-[18px]">settings</span>
                                <span>Pengaturan Akun</span>
                            </a>
                        @else
                            <a href="{{ route('admin.profile') }}"
                                class="flex items-center gap-3 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-[18px]">account_circle</span>
                                <span>Profil Admin</span>
                            </a>
                            <a href="{{ route('admin.settings') }}"
                                class="flex items-center gap-3 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                                <span>Pengaturan Akun</span>
                            </a>
                        @endif

                        <hr class="my-1 border-slate-100 dark:border-slate-700">

                        <button type="submit" form="logout-form"
                            class="flex w-full items-center gap-3 px-3 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors text-left font-medium">
                            <span class="material-symbols-outlined text-[18px]">logout</span>
                            <span>Keluar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>