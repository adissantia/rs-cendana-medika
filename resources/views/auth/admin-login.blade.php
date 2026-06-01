<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - RS Cendana Medika</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-slate-950 flex items-center justify-center font-sans">

<div class="w-full max-w-md">

    {{-- Card --}}
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-2xl">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-600 rounded-2xl mx-auto flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>
            </div>

            <h1 class="text-2xl font-bold text-white">
                Admin Panel
            </h1>

            <p class="text-slate-400 text-sm mt-1">
                RS Cendana Medika
            </p>
        </div>

        {{-- Error --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl text-sm">
                Email atau password salah
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label class="block text-sm text-slate-300 mb-2">
                    Email
                </label>

                <input type="email"
                       name="email"
                       required
                       class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                       placeholder="admin@gmail.com">
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm text-slate-300 mb-2">
                    Password
                </label>

                <input type="password"
                       name="password"
                       required
                       class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                       placeholder="••••••••">
            </div>

            {{-- Remember --}}
            <label class="flex items-center gap-2 text-sm text-slate-400">
                <input type="checkbox" name="remember" class="rounded border-slate-600 bg-slate-700">
                Remember me
            </label>

            {{-- Button --}}
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-xl transition">
                Login Admin
            </button>
        </form>
    </div>
</div>

</body>
</html>