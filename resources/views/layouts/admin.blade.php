<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') — RS Cendana Medika</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ALPINE JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="h-full bg-slate-50 font-sans" x-data="{ open:false }">

<div class="flex h-screen overflow-hidden">

    {{-- ================= SIDEBAR ================= --}}
    <aside class="w-64 flex-shrink-0 flex flex-col bg-slate-900">

        {{-- LOGO --}}
        <div class="flex items-center gap-3 px-5 py-5 border-b border-slate-700/50">

            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">

                <svg class="w-5 h-5 text-white"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 4v16m8-8H4"/>

                </svg>

            </div>

            <div>

                <p class="text-white font-semibold text-sm">
                    RS Cendana Medika
                </p>

                <p class="text-slate-400 text-xs">
                    Hospital Management
                </p>

            </div>

        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">

            <p class="text-slate-500 text-xs font-medium uppercase px-3 py-2">
                Utama
            </p>

            {{-- DASHBOARD --}}
            <a href="{{ route('admin.dashboard') }}"
               class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                <svg class="w-5 h-5 flex-shrink-0"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-width="1.5"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h4m10-11v10a1 1 0 01-1 1h-4"/>

                </svg>

                Dashboard

            </a>

            {{-- APPOINTMENTS --}}
            <a href="{{ route('admin.appointments.index') }}"
               class="menu-item {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">

                <svg class="w-5 h-5 flex-shrink-0"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-width="1.5"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M8 7V3m8 4V3M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z"/>

                </svg>

                Jadwal Temu

            </a>

            {{-- PATIENTS --}}
            <a href="{{ route('admin.patients.index') }}"
               class="menu-item {{ request()->routeIs('admin.patients.*') ? 'active' : '' }}">

                <svg class="w-5 h-5 flex-shrink-0"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-width="1.5"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14"/>

                </svg>

                Pasien

            </a>

            {{-- DOCTORS --}}
            <a href="{{ route('admin.doctors.index') }}"
               class="menu-item {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}">

                <svg class="w-5 h-5 flex-shrink-0"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-width="1.5"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682"/>

                </svg>

                Dokter

            </a>

            {{-- REPORTS --}}
            <p class="text-slate-500 text-xs font-medium uppercase px-3 py-2 mt-3">
                Laporan
            </p>

            <a href="{{ route('admin.reports.index') }}"
               class="menu-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">

                <svg class="w-5 h-5 flex-shrink-0"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-width="1.5"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M9 17v-2m3 2v-4m3 4v-6M7 3h6l5 5v11a2 2 0 01-2 2H7"/>

                </svg>

                Laporan & Statistik

            </a>

            {{-- SETTINGS --}}
            <p class="text-slate-500 text-xs font-medium uppercase px-3 py-2 mt-3">
                Sistem
            </p>

            <a href="{{ route('admin.settings.profile') }}"
               class="menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">

                <svg class="w-5 h-5 flex-shrink-0"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-width="1.5"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 8a4 4 0 100 8 4 4 0 000-8z"/>

                </svg>

                Pengaturan

            </a>

        </nav>

        {{-- USER --}}
        <div class="px-4 py-4 border-t border-slate-700/50">

            <div class="flex items-center gap-3">

                <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold">
                    {{ auth()->user()->initials }}
                </div>

                <div class="flex-1 min-w-0">

                    <p class="text-white text-sm font-medium truncate">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-slate-400 text-xs truncate">
                        {{ auth()->user()->position ?? 'Administrator' }}
                    </p>

                </div>

            </div>

        </div>

    </aside>

    {{-- ================= CONTENT ================= --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- HEADER --}}
        <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between">

            <div>

                <h1 class="text-base font-semibold text-gray-800">
                    @yield('page-title')
                </h1>

                <div class="text-xs text-gray-400 mt-0.5">
                    @yield('breadcrumb')
                </div>

            </div>

            <div class="flex items-center gap-3">

                {{-- DATE --}}
                <div class="bg-gray-100 text-gray-500 text-xs px-3 py-2 rounded-lg">
                    {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </div>

                {{-- Notifikasi --}}
     @php

    $lastSeen = session('last_seen_appointments');

    if ($lastSeen) {

        $notifCount = \App\Models\Appointment::where(
            'created_at',
            '>',
            $lastSeen
        )->count();

    } else {

        $notifCount = \App\Models\Appointment::count();
    }

@endphp

<a href="{{ route('admin.appointments.index') }}"
   class="relative p-2 rounded-lg hover:bg-gray-100 text-gray-500 transition">

    <svg class="w-5 h-5"
         fill="none"
         stroke="currentColor"
         viewBox="0 0 24 24">

        <path stroke-width="1.5"
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5"/>
    </svg>

    @if($notifCount > 0)

        <span class="absolute -top-1 -right-1
                     min-w-[18px] h-[18px]
                     px-1 bg-red-500 text-white
                     text-[10px] rounded-full
                     flex items-center justify-center
                     font-semibold shadow">

            {{ $notifCount }}

        </span>

    @endif

</a>
                {{-- AVATAR --}}
                <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-bold">
                    {{ auth()->user()->initials }}
                </div>

            </div>

        </header>

        {{-- FLASH MESSAGE --}}
        @if(session('success'))

            <div class="mx-6 mt-4 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>

        @endif

        @if(session('error'))

            <div class="mx-6 mt-4 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>

        @endif

        {{-- MAIN CONTENT --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>

    </div>

</div>

<style>

.menu-item{
    display:flex;
    align-items:center;
    gap:.75rem;
    padding:.7rem .75rem;
    border-radius:.75rem;
    font-size:.875rem;
    color:#94a3b8;
    transition:.2s;
}

.menu-item:hover{
    background:#1e293b;
    color:#fff;
}

.menu-item.active{
    background:#2563eb;
    color:#fff;
}

[x-cloak]{
    display:none !important;
}

</style>

</body>
</html>