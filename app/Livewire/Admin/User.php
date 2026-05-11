<?php

namespace App\Livewire\Admin;

use App\Models\User as ModelsUser;
use App\Traits\LivewireNotificationTrait;
use Livewire\Component;

class User extends Component
{
    use LivewireNotificationTrait;

    public $name;
    public $email;
    public $password;
    public $role;
    public $editCheck = false;
    public $idEdit;
    public $keyword;

    public function render()
    {
        $users = ModelsUser::where('name', 'like', '%' . $this->keyword . '%')->orWhere('email', 'like', '%' . $this->keyword . '%')->get();
        return view('livewire.admin.user', compact('users'));
    }

    public function store()
    {
        $validate = $this->validate(
            [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'role' => 'required|in:admin,user'
            ],
            [
                'name.required' => 'Nama user harus diisi',
                'name.min' => 'Nama user minimal 3 karakter',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar di sistem',
                'password.required' => 'Password harus diisi',
                'password.min' => 'Password minimal 6 karakter',
                'role.required' => 'Role harus dipilih',
                'role.in' => 'Role tidak valid'
            ]
        );

        try {
            $validate['password'] = bcrypt($validate['password']);
            ModelsUser::create($validate);
            $this->successNotification(
                'Berhasil!',
                "User '{$this->name}' dengan role '{$this->role}' berhasil ditambahkan"
            );
            $this->clear();
        } catch (\Exception $e) {
            $this->errorNotification('Gagal!', 'Terjadi kesalahan saat menambahkan user');
        }
    }

    public function destroy($id)
    {
        try {
            $user = ModelsUser::find($id);
            if (!$user) {
                $this->errorNotification('Gagal!', 'User tidak ditemukan');
                return;
            }

            $userName = $user->name;
            $user->delete();
            $this->successNotification('Berhasil!', "User '{$userName}' berhasil dihapus");
        } catch (\Exception $e) {
            $this->errorNotification('Gagal!', 'Terjadi kesalahan saat menghapus user');
        }
    }


    public function edit($id)
    {
        $user = ModelsUser::find($id);
        if (!$user) {
            $this->errorNotification('Gagal!', 'User tidak ditemukan');
            return;
        }
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->role = $user->role;
        $this->idEdit = $user->id;
        $this->editCheck = true;
    }


    public function clear()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->idEdit = '';
        $this->editCheck = false;
    }

    public function update($id)
    {
        $validate = $this->validate(
            [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|min:6',
                'role' => 'required|in:admin,user'
            ],
            [
                'name.required' => 'Nama user harus diisi',
                'name.min' => 'Nama user minimal 3 karakter',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar di sistem',
                'password.min' => 'Password minimal 6 karakter',
                'role.required' => 'Role harus dipilih',
                'role.in' => 'Role tidak valid'
            ]
        );

        try {
            $user = ModelsUser::find($id);
            if (!$user) {
                $this->errorNotification('Gagal!', 'User tidak ditemukan');
                return;
            }

            if ($validate['password']) {
                $validate['password'] = bcrypt($validate['password']);
            } else {
                unset($validate['password']);
            }

            $user->update($validate);
            $this->successNotification('Berhasil!', 'Data user berhasil diperbarui');
            $this->clear();
        } catch (\Exception $e) {
            $this->errorNotification('Gagal!', 'Terjadi kesalahan saat memperbarui user');
        }
    }
}
