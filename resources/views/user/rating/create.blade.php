@extends('layouts.user')

@section('title', 'Beri Rating')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

        {{-- HEADER --}}
        <div class="mb-8">

            <h1 class="text-2xl font-bold text-gray-800">
                Beri Rating Dokter
            </h1>

            <p class="text-gray-500 text-sm mt-2">
                Bagikan pengalaman pemeriksaan Anda
            </p>

        </div>

        {{-- INFO DOKTER --}}
        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 mb-8">

            <div class="flex items-center gap-4">

                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-7 h-7 text-blue-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M8 9a3 3 0 106 0 3 3 0 00-6 0zm-3 8a6 6 0 1112 0H5z" />

                    </svg>

                </div>

                <div>

                    <h2 class="text-lg font-bold text-gray-800">
                        {{ $appointment->doctor->name }}
                    </h2>

                    <p class="text-sm text-gray-500">
                        {{ $appointment->doctor->specialist->name ?? 'Dokter Umum' }}
                    </p>

                </div>

            </div>

        </div>

        {{-- ERROR --}}
        @if ($errors->any())

            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-6">

                <ul class="text-sm space-y-1">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- FORM --}}
        <form action="{{ route('user.ratings.store', $appointment) }}"
              method="POST"
              class="space-y-6">

            @csrf

            {{-- RATING --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Rating
                </label>

                <select name="rating"
                        required
                        class="w-full border border-gray-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <option value="">
                        Pilih Rating
                    </option>

                    <option value="5">⭐⭐⭐⭐⭐ - Sangat Baik</option>
                    <option value="4">⭐⭐⭐⭐ - Baik</option>
                    <option value="3">⭐⭐⭐ - Cukup</option>
                    <option value="2">⭐⭐ - Kurang</option>
                    <option value="1">⭐ - Buruk</option>

                </select>

            </div>

            {{-- REVIEW --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Ulasan
                </label>

                <textarea name="review"
                          rows="5"
                          placeholder="Tulis pengalaman pemeriksaan Anda..."
                          class="w-full border border-gray-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>

            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-3 pt-2">

                <a href="{{ route('user.queue.index') }}"
                   class="px-5 py-3 rounded-2xl border border-gray-200 text-gray-600 hover:bg-gray-50 transition">

                    Kembali

                </a>

                <button type="submit"
                        class="px-5 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">

                    Kirim Rating

                </button>

            </div>

        </form>

    </div>

</div>

@endsection