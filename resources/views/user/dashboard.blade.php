@extends('layouts.app')

@section('content')
    <div class="p-6">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-blue-100">Kelola kehadiran dan profil Anda di sini</p>
                </div>
                <div class="hidden md:block">
                    @if (Auth::user()->profile_photo && Auth::user()->profile_photo !== 'default-avatar.png')
                        <img src="{{ Storage::url('profiles/' . Auth::user()->profile_photo) }}" alt="Profile"
                            class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover">
                    @else
                        <div
                            class="w-24 h-24 rounded-full border-4 border-white bg-blue-500 flex items-center justify-center shadow-lg">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Status Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">Belum Diisi</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2 1 1 0 000-2H6a6 6 0 016 6v3h1a1 1 0 100 2h-1v2a2 2 0 11-4 0v-2H4a1 1 0 100-2h1V7a2 2 0 00-2-2h2a1 1 0 000-2H4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Total Kehadiran</p>
                        <p class="text-2xl font-bold text-green-600 mt-2">
                            @php
                                $totalAttendance = Auth::user()->attendances()->count();
                            @endphp
                            {{ $totalAttendance }}
                        </p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2 1 1 0 000-2H6a6 6 0 016 6v3h1a1 1 0 100 2h-1v2a2 2 0 11-4 0v-2H4a1 1 0 100-2h1V7a2 2 0 00-2-2h2a1 1 0 000-2H4z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Profil</p>
                        <p class="text-lg font-bold text-gray-900 mt-2">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Kehadiran</h3>
                </div>
                <p class="text-gray-600 mb-4">Catat kehadiran Anda untuk hari ini</p>
                <a href="/attendance"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                    Buka Kehadiran →
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 p-3 rounded-full mr-4">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Profil Saya</h3>
                </div>
                <p class="text-gray-600 mb-4">Kelola profil dan ubah foto Anda</p>
                <a href="/profile"
                    class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                    Buka Profil →
                </a>
            </div>
        </div>
    </div>
@endsection
