<div>
    @extends('layouts.app')

    @section('content')
        <div class="space-y-6">
            <!-- Welcome Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-8 text-white">
                <h1 class="text-3xl font-bold mb-2">👋 Selamat Datang Admin</h1>
                <p class="text-blue-100">Kelola sistem manajemen kepegawaian dengan mudah dan efisien</p>
            </div>

            <!-- Statistics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Employees -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">Total Karyawan</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                @livewire('admin.stats-card', ['stat' => 'employees'])
                            </p>
                        </div>
                        <div class="text-4xl text-blue-500 opacity-20">👥</div>
                    </div>
                </div>

                <!-- Today Present -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">Hadir Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                @livewire('admin.stats-card', ['stat' => 'present_today'])
                            </p>
                        </div>
                        <div class="text-4xl text-green-500 opacity-20">✅</div>
                    </div>
                </div>

                <!-- Today Absent -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">Tidak Hadir Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                @livewire('admin.stats-card', ['stat' => 'absent_today'])
                            </p>
                        </div>
                        <div class="text-4xl text-red-500 opacity-20">❌</div>
                    </div>
                </div>

                <!-- On Leave Today -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">Izin/Sakit Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                @livewire('admin.stats-card', ['stat' => 'leave_today'])
                            </p>
                        </div>
                        <div class="text-4xl text-yellow-500 opacity-20">📋</div>
                    </div>
                </div>
            </div>

            <!-- Main Content Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Today's Attendance Chart -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">📊 Statistik Kehadiran Hari Ini</h2>
                    @livewire('admin.attendance-chart')
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">⚡ Akses Cepat</h2>
                    <div class="space-y-3">
                        <a href="/admin/attendance"
                            class="flex items-center p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition border border-blue-200">
                            <span class="text-2xl mr-3">📋</span>
                            <div>
                                <p class="font-semibold text-gray-900">Kehadiran</p>
                                <p class="text-xs text-gray-600">Lihat semua data</p>
                            </div>
                        </a>
                        <a href="/employee"
                            class="flex items-center p-3 rounded-lg bg-green-50 hover:bg-green-100 transition border border-green-200">
                            <span class="text-2xl mr-3">👥</span>
                            <div>
                                <p class="font-semibold text-gray-900">Karyawan</p>
                                <p class="text-xs text-gray-600">Kelola data karyawan</p>
                            </div>
                        </a>
                        <a href="/payroll"
                            class="flex items-center p-3 rounded-lg bg-purple-50 hover:bg-purple-100 transition border border-purple-200">
                            <span class="text-2xl mr-3">💰</span>
                            <div>
                                <p class="font-semibold text-gray-900">Payroll</p>
                                <p class="text-xs text-gray-600">Kelola gaji karyawan</p>
                            </div>
                        </a>
                        <a href="/position"
                            class="flex items-center p-3 rounded-lg bg-orange-50 hover:bg-orange-100 transition border border-orange-200">
                            <span class="text-2xl mr-3">🎯</span>
                            <div>
                                <p class="font-semibold text-gray-900">Posisi</p>
                                <p class="text-xs text-gray-600">Kelola jabatan</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Attendance Records -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">🕐 Kehadiran Terbaru</h2>
                @livewire('admin.recent-attendance')
            </div>
        </div>
    @endsection
</div>
