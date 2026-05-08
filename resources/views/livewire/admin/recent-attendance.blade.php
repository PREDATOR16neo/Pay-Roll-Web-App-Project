<div>
    <div class="overflow-x-auto bg-gray-50 rounded-lg border border-gray-200">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                    <th class="px-6 py-4 text-left font-semibold">No</th>
                    <th class="px-6 py-4 text-left font-semibold">Nama Karyawan</th>
                    <th class="px-6 py-4 text-left font-semibold">Tanggal</th>
                    <th class="px-6 py-4 text-left font-semibold">Status</th>
                    <th class="px-6 py-4 text-left font-semibold">Waktu Pencatatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($records as $record)
                    <tr class="bg-white hover:bg-blue-50 transition duration-150">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-gray-700">
                            <div class="flex items-center">
                                @if ($record->user->profile_photo && $record->user->profile_photo !== 'default-avatar.png')
                                    <img src="{{ Storage::url('profiles/' . $record->user->profile_photo) }}"
                                        alt="{{ $record->user->name }}"
                                        class="w-10 h-10 rounded-full object-cover mr-3 border border-gray-300">
                                @else
                                    <span
                                        class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white flex items-center justify-center mr-3 text-sm font-semibold">
                                        {{ substr($record->user->name, 0, 1) }}
                                    </span>
                                @endif
                                {{ $record->user->name }}
                            </div>
                        </td>
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
                        <td class="px-6 py-4 text-gray-700 text-xs">{{ $record->created_at->format('d M Y - H:i') }}
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <p class="text-lg">📭 Belum ada data kehadiran</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
