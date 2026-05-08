<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{
    use WithFileUploads;

    public $photo;
    public $user;
    public $name;
    public $email;

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    public function render()
    {
        return view('livewire.admin.profile', [
            'user' => $this->user
        ]);
    }

    public function uploadPhoto()
    {
        $this->validate([
            'photo' => 'required|image|max:2048',
        ]);

        try {
            // Delete old photo if not default
            if ($this->user->profile_photo && $this->user->profile_photo !== 'default-avatar.png') {
                if (Storage::disk('public')->exists('profiles/' . $this->user->profile_photo)) {
                    Storage::disk('public')->delete('profiles/' . $this->user->profile_photo);
                }
            }

            // Store new photo
            $filename = 'profile_' . $this->user->id . '_' . time() . '.' . $this->photo->getClientOriginalExtension();
            $this->photo->storeAs('profiles', $filename, 'public');

            // Update user
            $this->user->update([
                'profile_photo' => $filename
            ]);

            session()->flash('success', '✅ Foto profil berhasil diubah!');
            $this->reset('photo');
            $this->mount();
        } catch (\Exception $e) {
            session()->flash('error', '❌ Gagal mengubah foto profil: ' . $e->getMessage());
        }
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
        ]);

        try {
            $this->user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            session()->flash('success', '✅ Profil berhasil diperbarui!');
            $this->mount();
        } catch (\Exception $e) {
            session()->flash('error', '❌ Gagal memperbarui profil: ' . $e->getMessage());
        }
    }
}
