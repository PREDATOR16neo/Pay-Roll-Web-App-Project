<div>
    @if ($total > 0)
        <div class="space-y-6">
            <!-- Progress bars -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-green-600 font-semibold">✅ Hadir</span>
                    <span class="text-green-600 font-bold">{{ $present }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div class="bg-green-500 h-full" style="width: {{ ($present / $total) * 100 }}%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-red-600 font-semibold">❌ Tidak Hadir</span>
                    <span class="text-red-600 font-bold">{{ $absent }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div class="bg-red-500 h-full" style="width: {{ ($absent / $total) * 100 }}%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-orange-600 font-semibold">🤒 Sakit</span>
                    <span class="text-orange-600 font-bold">{{ $sick }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div class="bg-orange-500 h-full" style="width: {{ ($sick / $total) * 100 }}%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-blue-600 font-semibold">📝 Izin</span>
                    <span class="text-blue-600 font-bold">{{ $permit }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div class="bg-blue-500 h-full" style="width: {{ ($permit / $total) * 100 }}%"></div>
                </div>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg mt-4">
                <p class="text-gray-700 text-sm"><span class="font-semibold">Total:</span> {{ $total }} orang</p>
            </div>
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-gray-500">📭 Belum ada data kehadiran untuk hari ini</p>
        </div>
    @endif
</div>
