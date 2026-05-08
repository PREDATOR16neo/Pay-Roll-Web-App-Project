<div class="p-6 bg-white rounded-lg shadow-md">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">👤 Profil Saya</h2>
        <p class="text-gray-600">Kelola profil dan foto Anda</p>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-green-700 font-semibold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-red-700 font-semibold">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Profile Info Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Photo Section -->
        <div class="flex flex-col items-center">
            <div class="mb-6">
                @if ($user->profile_photo && $user->profile_photo !== 'default-avatar.png')
                    <img src="{{ Storage::url('profiles/' . $user->profile_photo) }}" alt="Profile Photo"
                        class="w-40 h-40 rounded-full border-4 border-blue-500 shadow-lg object-cover">
                @else
                    <div
                        class="w-40 h-40 rounded-full border-4 border-gray-300 shadow-lg bg-gray-100 flex items-center justify-center">
                        <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Upload Photo Form -->
            <form wire:submit.prevent="uploadPhoto" class="w-full">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        📸 Ubah Foto Profil
                    </label>
                    <input type="file" wire:model="photo" accept="image/*"
                        class="block w-full text-sm text-gray-500 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">

                    @error('photo')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if ($photo)
                    <div class="mb-4">
                        <p class="text-xs text-gray-600 mb-2">Preview:</p>
                        <img src="{{ $photo->temporaryUrl() }}" alt="Preview"
                            class="w-32 h-32 rounded-lg object-cover border-2 border-blue-300">
                    </div>
                @endif

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                    Simpan Foto
                </button>
            </form>
        </div>

        <!-- Info Section -->
        <div class="md:col-span-2">
            <div class="space-y-6">
                <!-- Name Info -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="text-sm font-semibold text-gray-600">Nama Lengkap</label>
                    <p class="text-lg font-semibold text-gray-900 mt-1">{{ $user->name }}</p>
                </div>

                <!-- Email Info -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="text-sm font-semibold text-gray-600">Email</label>
                    <p class="text-lg font-semibold text-gray-900 mt-1">{{ $user->email }}</p>
                </div>

                <!-- Role Info -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="text-sm font-semibold text-gray-600">Peran</label>
                    <p class="text-lg font-semibold text-gray-900 mt-1">
                        @if ($user->role === 'admin')
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">
                                👨‍💼 Administrator
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                👤 Karyawan
                            </span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
