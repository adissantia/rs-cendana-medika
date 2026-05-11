{{-- resources/views/auth/register.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrasi Pasien - RS Cendana Medika</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen bg-slate-100 font-sans">

    <div class="min-h-screen flex">

        {{-- LEFT SIDE --}}
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gradient-to-br from-cyan-500 via-blue-600 to-indigo-700">

            {{-- Blur Circle --}}
            <div class="absolute -top-20 -left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-300/10 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col justify-between w-full p-14 text-white">

                {{-- Logo --}}
                <div class="flex items-center gap-4">

                    <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold">
                            RS Cendana Medika
                        </h1>

                        <p class="text-blue-100 text-sm">
                            Sistem Registrasi Pasien Online
                        </p>
                    </div>
                </div>

                {{-- Hero --}}
                <div class="max-w-xl">

                    <span class="bg-white/20 text-white text-sm px-4 py-2 rounded-full backdrop-blur-md">
                        Registrasi Pasien Digital
                    </span>

                    <h2 class="mt-6 text-5xl font-extrabold leading-tight">
                        Daftar Lebih Cepat,
                        <br>
                        Berobat Lebih Mudah
                    </h2>

                    <p class="mt-6 text-lg text-blue-100 leading-relaxed">
                        Registrasi online untuk mendapatkan akses layanan rumah sakit,
                        antrean dokter, pembayaran, dan riwayat kunjungan secara digital.
                    </p>

                    {{-- Features --}}
                    <div class="grid grid-cols-2 gap-4 mt-10">

                        <div class="bg-white/10 border border-white/10 backdrop-blur-md rounded-2xl p-5">
                            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-3">
                                🩺
                            </div>

                            <h3 class="font-semibold">
                                Booking Dokter
                            </h3>

                            <p class="text-sm text-blue-100 mt-1">
                                Pilih dokter & jadwal secara online
                            </p>
                        </div>

                        <div class="bg-white/10 border border-white/10 backdrop-blur-md rounded-2xl p-5">
                            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-3">
                                💳
                            </div>

                            <h3 class="font-semibold">
                                Pembayaran Mudah
                            </h3>

                            <p class="text-sm text-blue-100 mt-1">
                                Transaksi cepat dan aman
                            </p>
                        </div>

                        <div class="bg-white/10 border border-white/10 backdrop-blur-md rounded-2xl p-5">
                            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-3">
                                📄
                            </div>

                            <h3 class="font-semibold">
                                Tiket Digital
                            </h3>

                            <p class="text-sm text-blue-100 mt-1">
                                Tidak perlu antre manual
                            </p>
                        </div>

                        <div class="bg-white/10 border border-white/10 backdrop-blur-md rounded-2xl p-5">
                            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-3">
                                ⭐
                            </div>

                            <h3 class="font-semibold">
                                Pelayanan Modern
                            </h3>

                            <p class="text-sm text-blue-100 mt-1">
                                Pengalaman pasien lebih nyaman
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Footer --}}
                <div class="text-sm text-blue-100">
                    © {{ date('Y') }} RS Cendana Medika
                </div>

            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6">

            <div class="w-full max-w-2xl">

                {{-- Mobile Logo --}}
                <div class="lg:hidden text-center mb-8">

                    <div class="w-16 h-16 mx-auto rounded-2xl bg-blue-600 flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>

                    <h1 class="mt-4 text-2xl font-bold text-slate-800">
                        RS Cendana Medika
                    </h1>

                    <p class="text-slate-500 text-sm">
                        Registrasi Pasien
                    </p>
                </div>

                {{-- Card --}}
                <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">

                    {{-- Header --}}
                    <div class="px-8 pt-8 pb-4">

                        <h2 class="text-3xl font-bold text-slate-800">
                            Buat Akun Pasien
                        </h2>

                        <p class="text-slate-500 mt-2">
                            Lengkapi data untuk membuat akun pasien baru.
                        </p>
                    </div>

                    {{-- Form --}}
                    <form method="POST" action="{{ route('register') }}" class="px-8 pb-8">
                        @csrf

                        {{-- GRID --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            {{-- Nama --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Nama Lengkap
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition"
                                    placeholder="Masukkan nama lengkap">

                                @error('name')
                                    <p class="text-red-500 text-sm mt-2">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition"
                                    placeholder="email@gmail.com">

                                @error('email')
                                    <p class="text-red-500 text-sm mt-2">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Nomor HP --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Nomor HP
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    required
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition"
                                    placeholder="08xxxxxxxxxx">

                                @error('phone')
                                    <p class="text-red-500 text-sm mt-2">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Jenis Kelamin
                                </label>

                                <select
                                    name="gender"
                                    required
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition">

                                    <option value="">Pilih Gender</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>

                                </select>

                                @error('gender')
                                    <p class="text-red-500 text-sm mt-2">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Umur --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Umur
                                </label>

                                <input
                                    type="number"
                                    name="age"
                                    value="{{ old('age') }}"
                                    required
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition"
                                    placeholder="20">

                                @error('age')
                                    <p class="text-red-500 text-sm mt-2">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Tanggal Lahir
                                </label>

                                <input
                                    type="date"
                                    name="birth_date"
                                    value="{{ old('birth_date') }}"
                                    required
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition">

                                @error('birth_date')
                                    <p class="text-red-500 text-sm mt-2">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Alamat
                                </label>

                                <textarea
                                    name="address"
                                    rows="3"
                                    required
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition"
                                    placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>

                                @error('address')
                                    <p class="text-red-500 text-sm mt-2">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Password
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    required
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition"
                                    placeholder="Minimal 8 karakter">

                                @error('password')
                                    <p class="text-red-500 text-sm mt-2">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Konfirmasi Password
                                </label>

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition"
                                    placeholder="Ulangi password">

                            </div>

                        </div>

                        {{-- Button --}}
                        <button
                            type="submit"
                            class="w-full mt-8 bg-gradient-to-r from-cyan-500 via-blue-600 to-indigo-600 hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 text-white font-semibold py-4 rounded-2xl shadow-xl shadow-blue-200">

                            Daftar Sekarang
                        </button>

                        {{-- Login --}}
                        <p class="text-center text-sm text-slate-500 mt-6">
                            Sudah punya akun?

                            <a href="{{ route('login') }}"
                                class="text-blue-600 font-semibold hover:text-blue-700">
                                Login Pasien
                            </a>
                        </p>

                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>