<div class="space-y-6">
    <!-- Flash Messages -->
    @if (session('massage'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-green-700 font-semibold">{{ session('massage') }}</span>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-6 text-white">
        <h1 class="text-3xl font-bold">📊 Manajemen Kehadiran</h1>
        <p class="text-blue-100 mt-2">Kelola dan monitor kehadiran seluruh karyawan</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">🔍 Filter Data</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Nama/Email</label>
                <input type="text" wire:model.live="search"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan nama atau email...">
            </div>

            <!-- Date Filter -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                <input type="date" wire:model.live="filterDate"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <select wire:model.live="filterStatus"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="present">✅ Hadir</option>
                    <option value="absent">❌ Tidak Hadir</option>
                    <option value="sick">🤒 Sakit</option>
                    <option value="permit">📝 Izin</option>
                </select>
            </div>

            <!-- Reset Button -->
            <div class="flex items-end">
                <button wire:click="resetFilters()"
                    class="w-full px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition">
                    🔄 Reset Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Summary -->
    @if ($totalRecords > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                <p class="text-sm text-gray-600">✅ Hadir</p>
                <p class="text-3xl font-bold text-green-600">{{ $stats['present'] }}</p>
            </div>
            <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                <p class="text-sm text-gray-600">❌ Tidak Hadir</p>
                <p class="text-3xl font-bold text-red-600">{{ $stats['absent'] }}</p>
            </div>
            <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                <p class="text-sm text-gray-600">🤒 Sakit</p>
                <p class="text-3xl font-bold text-orange-600">{{ $stats['sick'] }}</p>
            </div>
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                <p class="text-sm text-gray-600">📝 Izin</p>
                <p class="text-3xl font-bold text-blue-600">{{ $stats['permit'] }}</p>
            </div>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                        <th class="px-6 py-4 text-left font-semibold">No</th>
                        <th class="px-6 py-4 text-left font-semibold cursor-pointer hover:bg-blue-800"
                            wire:click="toggleSort('date')">
                            📅 Tanggal
                            @if ($sortBy === 'date')
                                {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                            @endif
                        </th>
                        <th class="px-6 py-4 text-left font-semibold">Nama Karyawan</th>
                        <th class="px-6 py-4 text-left font-semibold">Email</th>
                        <th class="px-6 py-4 text-left font-semibold">Status</th>
                        <th class="px-6 py-4 text-left font-semibold">Waktu Pencatatan</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($records as $record)
                        <tr class="hover:bg-blue-50 transition duration-150">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ ($records->currentPage() - 1) * 15 + $loop->iteration }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $record->date->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if ($record->user->profile_photo && $record->user->profile_photo !== 'default-avatar.png')
                                        <img src="{{ Storage::url('profiles/' . $record->user->profile_photo) }}"
                                            alt="{{ $record->user->name }}"
                                            class="w-10 h-10 rounded-full object-cover mr-3 border border-gray-300">
                                    @else
                                        <span
                                            class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white flex items-center justify-center mr-3 text-sm font-bold">
                                            {{ substr($record->user->name, 0, 1) }}
                                        </span>
                                    @endif
                                    <span class="font-medium text-gray-900">{{ $record->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-xs">{{ $record->user->email }}</td>
                            <td class="px-6 py-4">
                                @switch($record->status)
                                    @case('present')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            ✅ Hadir
                                        </span>
                                    @break

                                    @case('sick')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800">
                                            🤒 Sakit
                                        </span>
                                    @break

                                    @case('permit')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                            📝 Izin
                                        </span>
                                    @break

                                    @case('absent')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                            ❌ Tidak Hadir
                                        </span>
                                    @break
                                @endswitch
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-xs">
                                {{ $record->created_at->format('d M Y - H:i') }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex gap-2 justify-center">
                                    <button
                                        wire:click="openEditModal({{ $record->id }}, '{{ $record->status }}', '{{ $record->date->toDateString() }}')"
                                        class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded transition">
                                        ✏️ Edit
                                    </button>
                                    <button wire:click="deleteRecord({{ $record->id }})"
                                        wire:confirm="Yakin hapus record ini?"
                                        class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs rounded transition">
                                        🗑️ Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center">
                                    <p class="text-gray-500 text-lg">📭 Tidak ada data yang sesuai dengan filter</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($records->hasPages())
            <div class="flex justify-center">
                {{ $records->links() }}
            </div>
        @endif

        <!-- Edit Modal -->
        @if ($showModal)
            <div class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">✏️ Edit Kehadiran</h3>

                    <div class="space-y-4">
                        <!-- Date Input -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                            <input type="date" wire:model="editingDate"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('editingDate')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status Selection -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                            <select wire:model="editingStatus"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Status</option>
                                <option value="present">✅ Hadir</option>
                                <option value="absent">❌ Tidak Hadir</option>
                                <option value="sick">🤒 Sakit</option>
                                <option value="permit">📝 Izin</option>
                            </select>
                            @error('editingStatus')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 justify-end mt-6">
                            <button wire:click="closeModal()"
                                class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg transition">
                                Batal
                            </button>
                            <button wire:click="saveEdit()"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
