<div class="space-y-6 p-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-6 text-white">
        <h1 class="text-3xl font-bold">👤 Profil Admin</h1>
        <p class="text-blue-100 mt-2">Kelola informasi profil Anda</p>
    </div>

    <!-- Profile Container -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Photo Section -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📸 Foto Profil</h3>

                <!-- Current Photo -->
                <div class="mb-6 flex justify-center">
                    @if ($user->profile_photo && $user->profile_photo !== 'default-avatar.png')
                        <img src="{{ Storage::url('profiles/' . $user->profile_photo) }}" alt="Profile Photo"
                            class="w-32 h-32 rounded-full object-cover border-4 border-blue-500 shadow-lg">
                    @else
                        <div
                            class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white flex items-center justify-center text-4xl font-bold shadow-lg">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- Upload Photo Form -->
                <form wire:submit="uploadPhoto" class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Foto Baru</label>
                        <input type="file" wire:model="photo" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('photo')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    @if ($photo)
                        <div class="border-2 border-dashed border-blue-300 rounded-lg p-4">
                            <img src="{{ $photo->temporaryUrl() }}" alt="Preview"
                                class="w-full h-32 object-cover rounded">
                        </div>
                    @endif

                    <button type="submit"
                        class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                        📤 Upload Foto
                    </button>
                </form>
            </div>
        </div>

        <!-- Info Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">ℹ️ Informasi Profil</h3>

                <!-- Profile Update Form -->
                <form wire:submit="updateProfile" class="space-y-4">
                    <!-- Name Field -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" wire:model="name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan nama lengkap">
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" wire:model="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan email">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Account Info (Read-only) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Peran</label>
                        <input type="text" value="Administrator" disabled
                            class="w-full px-4 py-2 border border-gray-300 bg-gray-100 rounded-lg text-gray-600">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Bergabung</label>
                        <input type="text" value="{{ $user->created_at->format('d M Y - H:i') }}" disabled
                            class="w-full px-4 py-2 border border-gray-300 bg-gray-100 rounded-lg text-gray-600">
                    </div>

                    <!-- Update Button -->
                    <button type="submit"
                        class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                        ✅ Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
