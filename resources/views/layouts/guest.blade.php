<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'Digital Skill Passport')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap"
        rel="stylesheet" />

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#137fec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101922",
                    },
                    fontFamily: {
                        "sans": ["Inter", "sans-serif"]
                    }
                },
            },
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .material-symbols-outlined.fill {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark min-h-screen flex flex-col text-slate-900 dark:text-slate-50 font-sans">
    <!-- Header -->
    <header
        class="w-full bg-white/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-6 py-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="text-primary">
                    <span class="material-symbols-outlined text-3xl fill">verified_user</span>
                </div>
                <h2 class="text-slate-900 dark:text-white text-lg font-black tracking-tight leading-none uppercase">
                    Digital Skill <span class="text-primary">Passport</span></h2>
            </a>
            <div class="flex items-center gap-3">
                <!-- Bantuan link removed -->
                @if(Route::currentRouteName() == 'login')
                    <a href="{{ route('register') }}"
                        class="inline-flex h-10 items-center justify-center rounded-xl bg-primary px-6 text-sm font-bold text-white shadow-lg shadow-blue-500/20 hover:bg-blue-600 transition-all">Daftar</a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-flex h-10 items-center justify-center rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-6 text-sm font-bold text-slate-700 dark:text-slate-200 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">Masuk</a>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="py-12 border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-background-dark">
        <div class="max-w-7xl mx-auto px-6 flex flex-col items-center gap-6">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-slate-400 dark:text-slate-600 text-xl">badge</span>
                <span class="text-sm font-black text-slate-400 dark:text-slate-600 uppercase tracking-widest">Digital
                    Skill Passport</span>
            </div>
            <p class="text-xs font-bold text-slate-400 dark:text-slate-500">© 2026 Digital Skill Passport. Hak Cipta
                Dilindungi.</p>
        </div>
    </footer>
</body>

</html>