<?php

namespace App\Livewire\Admin;

use App\Models\Employee as ModelsEmployee;
use App\Models\Position;
use App\Models\User;
use App\Traits\LivewireNotificationTrait;
use Livewire\Component;

class Employee extends Component
{
    use LivewireNotificationTrait;

    public $user_id;
    public $position_id;
    public $salary;
    public $editCheck = false;
    public $idEdit;

    public function render()
    {
        $users = User::all();
        $positions = Position::all();
        $employees = ModelsEmployee::all();
        return view('livewire.admin.employee', compact('users', 'positions', 'employees'));
    }

    public function store()
    {
        $validate = $this->validate(
            [
                "user_id" => 'required|unique:employees,user_id|exists:users,id',
                'position_id' => 'required|exists:positions,id',
                'salary' => "required|numeric|min:0"
            ],
            [
                'user_id.required' => 'Pilih user terlebih dahulu',
                'user_id.unique' => 'User ini sudah terdaftar sebagai employee',
                'user_id.exists' => 'User tidak ditemukan',
                'position_id.required' => 'Pilih posisi terlebih dahulu',
                'position_id.exists' => 'Posisi tidak ditemukan',
                'salary.required' => 'Gaji harus diisi',
                'salary.numeric' => 'Gaji harus berupa angka',
                'salary.min' => 'Gaji tidak boleh negatif'
            ]
        );

        try {
            $user = User::find($validate['user_id']);
            $position = Position::find($validate['position_id']);

            ModelsEmployee::create($validate);
            $this->successNotification(
                'Berhasil!',
                "Employee '{$user->name}' berhasil ditambahkan sebagai {$position->name}"
            );
            $this->clear();
        } catch (\Exception $e) {
            $this->errorNotification('Gagal!', 'Terjadi kesalahan saat menambahkan employee');
        }
    }

    public function destroy($id)
    {
        try {
            $employee = ModelsEmployee::find($id);
            if (!$employee) {
                $this->errorNotification('Gagal!', 'Employee tidak ditemukan');
                return;
            }

            $userName = $employee->user->name;
            $employee->delete();
            $this->successNotification('Berhasil!', "Employee '{$userName}' berhasil dihapus");
        } catch (\Exception $e) {
            $this->errorNotification('Gagal!', 'Terjadi kesalahan saat menghapus employee');
        }
    }

    public function edit($id)
    {
        $employee = ModelsEmployee::find($id);
        if (!$employee) {
            $this->errorNotification('Gagal!', 'Employee tidak ditemukan');
            return;
        }
        $this->user_id = $employee->user_id;
        $this->position_id = $employee->position_id;
        $this->salary = $employee->salary;
        $this->editCheck = true;
        $this->idEdit = $employee->id;
    }

    public function clear()
    {
        $this->user_id = '';
        $this->position_id = '';
        $this->salary = '';
        $this->editCheck = false;
        $this->idEdit = '';
    }

    public function update($id)
    {
        $validate = $this->validate(
            [
                'user_id' => 'required|exists:users,id',
                'position_id' => 'required|exists:positions,id',
                'salary' => 'required|numeric|min:0'
            ],
            [
                'user_id.required' => 'Pilih user terlebih dahulu',
                'user_id.exists' => 'User tidak ditemukan',
                'position_id.required' => 'Pilih posisi terlebih dahulu',
                'position_id.exists' => 'Posisi tidak ditemukan',
                'salary.required' => 'Gaji harus diisi',
                'salary.numeric' => 'Gaji harus berupa angka',
                'salary.min' => 'Gaji tidak boleh negatif'
            ]
        );

        try {
            $employee = ModelsEmployee::find($id);
            if (!$employee) {
                $this->errorNotification('Gagal!', 'Employee tidak ditemukan');
                return;
            }

            $employee->update($validate);
            $this->successNotification('Berhasil!', 'Data employee berhasil diperbarui');
            $this->clear();
        } catch (\Exception $e) {
            $this->errorNotification('Gagal!', 'Terjadi kesalahan saat memperbarui employee');
        }
    }
}
