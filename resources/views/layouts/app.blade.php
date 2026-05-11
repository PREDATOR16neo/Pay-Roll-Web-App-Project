<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        }

        // Fungsi untuk menampilkan notifikasi SweetAlert2
        function showNotification(icon, title, message, timer = null) {
            const config = {
                icon: icon,
                title: title,
                html: message,
                confirmButtonColor: '#667eea',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                didOpen: function(modal) {
                    const confirmButton = modal.querySelector('.swal2-confirm');
                    if (confirmButton) {
                        confirmButton.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                        confirmButton.style.borderRadius = '8px';
                        confirmButton.style.padding = '10px 20px';
                    }
                }
            };

            if (timer) {
                config.timer = timer;
                config.timerProgressBar = true;
            }

            return Swal.fire(config);
        }

        // Fungsi untuk menampilkan notifikasi berhasil dengan loading
        function showLoadingAlert(title, message) {
            Swal.fire({
                title: title,
                html: message,
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: (modal) => {
                    Swal.showLoading();
                }
            });
        }
    </script>
    @livewireStyles
</head>

<body class="bg-gray-100">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 w-64 bg-gray-900 text-white transform -translate-x-full md:translate-x-0 transition duration-300 z-50">

            @if (Auth::check() && Auth::user()->role === 'admin')
                <!-- Admin Sidebar -->
                <div class="p-6 text-2xl font-bold border-b border-gray-700">
                    🚀 Admin Panel
                </div>

                <nav class="mt-6 space-y-2 px-4">
                    <a href="/admin"
                        class="block py-2 px-4 rounded-lg hover:bg-gray-700 @if (request()->path() === 'admin') bg-gray-700 @endif">🏠
                        Dashboard</a>
                    <a href="/user"
                        class="block py-2 px-4 rounded-lg hover:bg-gray-700 @if (request()->path() === 'user') bg-gray-700 @endif">👤
                        Users</a>
                    <a href="/position"
                        class="block py-2 px-4 rounded-lg hover:bg-gray-700 @if (request()->path() === 'position') bg-gray-700 @endif">🎯
                        Position</a>
                    <a href="/employee"
                        class="block py-2 px-4 rounded-lg hover:bg-gray-700 @if (request()->path() === 'employee') bg-gray-700 @endif">👥
                        Employee</a>
                    <a href="/payroll"
                        class="block py-2 px-4 rounded-lg hover:bg-gray-700 @if (request()->path() === 'payroll') bg-gray-700 @endif">💰
                        Payroll</a>
                    <a href="/admin/attendance"
                        class="block py-2 px-4 rounded-lg hover:bg-gray-700 @if (request()->path() === 'admin/attendance') bg-gray-700 @endif">📋
                        Attendance</a>
                    <a href="/admin/profile"
                        class="block py-2 px-4 rounded-lg hover:bg-gray-700 @if (request()->path() === 'admin/profile') bg-gray-700 @endif">⚙️
                        Profil</a>
                    <a href="{{ route('logout') }}" class="block py-2 px-4 rounded-lg hover:bg-red-900 text-red-500">🚪
                        Log
                        Out</a>
                </nav>
            @else
                <!-- User Sidebar -->
                <div class="p-6 text-2xl font-bold border-b border-gray-700">
                    👤 Portal Karyawan
                </div>

                <nav class="mt-6 space-y-2 px-4">
                    <a href="/attendance"
                        class="block py-2 px-4 rounded-lg hover:bg-gray-700 @if (request()->path() === 'attendance') bg-gray-700 @endif">📋
                        Kehadiran</a>
                    <a href="/profile"
                        class="block py-2 px-4 rounded-lg hover:bg-gray-700 @if (request()->path() === 'profile') bg-gray-700 @endif">👤
                        Profil</a>
                    <hr class="my-4 border-gray-700">
                    <a href="{{ route('logout') }}" class="block py-2 px-4 rounded-lg hover:bg-red-900 text-red-500">🚪
                        Log
                        Out</a>
                </nav>
            @endif
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col md:ml-64">

            <!-- Navbar -->
            <header class="bg-white shadow p-4 flex items-center justify-between">
                <button onclick="toggleSidebar()" class="md:hidden text-gray-700">
                    ☰
                </button>

                <h1 class="text-xl font-semibold">Dashboard</h1>

                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Hi, {{ Auth::user()->name }}</span>
                    @if (Auth::user()->profile_photo && Auth::user()->profile_photo !== 'default-avatar.png')
                        <img src="{{ Storage::url('profiles/' . Auth::user()->profile_photo) }}" alt="Profile Photo"
                            class="w-10 h-10 rounded-full object-cover border-2 border-blue-500">
                    @else
                        <div
                            class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center border-2 border-gray-400">
                            <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                </div>
            </header>

            <!-- Content -->
            <main class="p-6 overflow-y-auto">




                @yield('content')

            </main>
        </div>

    </div>
    @livewireScripts

    <!-- Global Notification Handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle Success Messages
            @if (session('message'))
                @if (str_contains(session('message'), 'berhasil') || str_contains(session('message'), 'Berhasil'))
                    showNotification(
                        'success',
                        'Berhasil!',
                        '{{ session('message') }}',
                        3000
                    );
                @else
                    showNotification(
                        'info',
                        'Informasi',
                        '{{ session('message') }}'
                    );
                @endif
            @endif

            // Handle Error Messages
            @if (session('error'))
                showNotification(
                    'error',
                    'Error!',
                    '{{ session('error') }}'
                );
            @endif

            // Handle Validation Errors
            @if ($errors->any())
                const errors = {!! json_encode($errors->all()) !!};
                showNotification(
                    'error',
                    'Validasi Gagal',
                    errors.join('<br>')
                );
            @endif

            // Handle Warning Messages
            @if (session('warning'))
                showNotification(
                    'warning',
                    'Peringatan',
                    '{{ session('warning') }}'
                );
            @endif
        });

        // Custom Livewire Notification Handler
        window.addEventListener('notify', function(event) {
            const {
                type = 'info', title = 'Notifikasi', message = ''
            } = event.detail;
            showNotification(type, title, message, type === 'success' ? 3000 : null);
        });

        // Custom Livewire Notification Handler with custom timer
        window.addEventListener('notifyWithTimer', function(event) {
            const {
                type = 'info', title = 'Notifikasi', message = '', timer = 3000
            } = event.detail;
            showNotification(type, title, message, timer);
        });
    </script>
</body>

</html>
