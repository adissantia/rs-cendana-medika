<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') - RS Cendana Medika</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-slate-100 font-sans">

<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-72 bg-white border-r hidden lg:flex flex-col">

        {{-- LOGO --}}
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold text-blue-600">
                Medicore
            </h1>

            <p class="text-sm text-slate-500">
                Hospital App
            </p>
        </div>

        {{-- MENU --}}
        <nav class="flex-1 p-4 space-y-2">

            <a href="{{ route('user.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
                {{ request()->routeIs('user.dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-slate-100 text-slate-700' }}">

                <span>🏠</span>
                Dashboard
            </a>

            <a href="{{ route('user.queue.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
                {{ request()->routeIs('user.queue.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-100 text-slate-700' }}">

                <span>📅</span>
                Janji Temu
            </a>

            <a href="{{ route('user.payments.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
                {{ request()->routeIs('user.payments.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-100 text-slate-700' }}">

                <span>💳</span>
                Pembayaran
            </a>

            <a href="{{ route('user.account.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
                {{ request()->routeIs('user.account.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-100 text-slate-700' }}">

                <span>👤</span>
                Akun Saya
            </a>

        </nav>

        {{-- USER --}}
        <div class="p-4 border-t">

            <div class="flex items-center gap-3">

                <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-bold">
                    {{ auth()->user()->initials }}
                </div>

                <div>
                    <h3 class="font-semibold text-slate-800">
                        {{ auth()->user()->name }}
                    </h3>

                    <p class="text-sm text-slate-500">
                        Pasien
                    </p>
                </div>

            </div>

        </div>

    </aside>

    {{-- CONTENT --}}
    <main class="flex-1">

        {{-- TOPBAR --}}
        <header class="bg-white border-b px-6 py-4 flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    @yield('title')
                </h1>

                <p class="text-sm text-slate-500">
                    Selamat datang kembali 👋
                </p>
            </div>

            <div class="flex items-center gap-4">

                <div class="hidden md:block text-right">
                    <p class="font-semibold text-slate-700">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-sm text-slate-500">
                        User
                    </p>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-bold">
                    {{ auth()->user()->initials }}
                </div>

            </div>

        </header>

        {{-- CONTENT --}}
        <div class="p-6">
            @yield('content')
        </div>

    </main>

</div>

</body>
</html>