<div class="p-6 bg-white rounded-lg shadow-md">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">📋 Form Kehadiran</h2>
        <p class="text-gray-600">Isi form kehadiran Anda untuk hari ini</p>
    </div>

    <!-- Form -->
    <form wire:submit.prevent="save" class="space-y-6">
        <!-- Status Selection -->
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
            <label class="block text-sm font-semibold text-gray-700 mb-4">
                🎯 Pilih Status Kehadiran Anda
                <span class="text-red-500">*</span>
            </label>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Present -->
                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition"
                    :class="status === 'present' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'">
                    <input type="radio" wire:model="status" value="present" class="w-4 h-4 text-green-500">
                    <div class="ml-4">
                        <p class="font-semibold text-gray-900">✅ Hadir</p>
                        <p class="text-xs text-gray-500">Anda masuk kerja hari ini</p>
                    </div>
                </label>

                <!-- Sick -->
                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition"
                    :class="status === 'sick' ? 'border-orange-500 bg-orange-50' : 'border-gray-200 hover:border-orange-300'">
                    <input type="radio" wire:model="status" value="sick" class="w-4 h-4 text-orange-500">
                    <div class="ml-4">
                        <p class="font-semibold text-gray-900">🤒 Sakit</p>
                        <p class="text-xs text-gray-500">Anda sedang tidak sehat</p>
                    </div>
                </label>

                <!-- Permit -->
                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition"
                    :class="status === 'permit' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                    <input type="radio" wire:model="status" value="permit" class="w-4 h-4 text-blue-500">
                    <div class="ml-4">
                        <p class="font-semibold text-gray-900">📝 Izin</p>
                        <p class="text-xs text-gray-500">Anda minta izin kepada atasan</p>
                    </div>
                </label>

                <!-- Absent -->
                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition"
                    :class="status === 'absent' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-red-300'">
                    <input type="radio" wire:model="status" value="absent" class="w-4 h-4 text-red-500">
                    <div class="ml-4">
                        <p class="font-semibold text-gray-900">❌ Tidak Hadir</p>
                        <p class="text-xs text-gray-500">Anda tidak masuk tanpa keterangan</p>
                    </div>
                </label>
            </div>

            @error('status')
                <p class="mt-3 text-sm text-red-600 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Date Info -->
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
            <p class="text-sm text-blue-800">
                <span class="font-semibold">📅 Tanggal:</span>
                {{ now()->format('d M Y') }}
            </p>
        </div>

        <!-- Submit Button -->
        <div class="flex gap-4">
            <button type="submit"
                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                </svg>
                Simpan Kehadiran
            </button>
        </div>
    </form>

    <hr class="my-10">

    <!-- History/Record Section -->
    <div>
        <h3 class="text-xl font-bold text-gray-900 mb-6">📊 Riwayat Kehadiran Anda</h3>

        <div class="overflow-x-auto bg-white rounded-lg shadow-sm border border-gray-200">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                        <th class="px-6 py-4 text-left font-semibold">No</th>
                        <th class="px-6 py-4 text-left font-semibold">Tanggal</th>
                        <th class="px-6 py-4 text-left font-semibold">Status</th>
                        <th class="px-6 py-4 text-left font-semibold">Waktu Pencatatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @if (count($attendanceRecords) > 0)
                        @foreach ($attendanceRecords as $key => $record)
                            <tr class="hover:bg-blue-50 transition duration-150">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $record->date->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    @switch($record->status)
                                        @case('present')
                                            <span
                                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                ✅ Hadir
                                            </span>
                                        @break

                                        @case('sick')
                                            <span
                                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                                🤒 Sakit
                                            </span>
                                        @break

                                        @case('permit')
                                            <span
                                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                                📝 Izin
                                            </span>
                                        @break

                                        @case('absent')
                                            <span
                                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                ❌ Tidak Hadir
                                            </span>
                                        @break
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $record->created_at->format('d M Y - H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                <p class="text-lg">📭 Belum ada riwayat kehadiran</p>
                                <p class="text-sm">Mulai isi kehadiran Anda di atas</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tailwind Alpine.js for radio button styling -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
