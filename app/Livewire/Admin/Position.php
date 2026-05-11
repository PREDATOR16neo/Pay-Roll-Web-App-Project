<?php

namespace App\Livewire\Admin;

use App\Models\Position as ModelsPosition;
use App\Traits\LivewireNotificationTrait;
use Livewire\Component;

class Position extends Component
{
    use LivewireNotificationTrait;

    public $name;
    public $editCheck = false;
    public $idEdit;
    public $keyword;

    public function render()
    {
        $positions = ModelsPosition::where('name', 'like', '%' . $this->keyword . '%')->get();
        return view('livewire.admin.position', compact('positions'));
    }

    public function store()
    {
        $validated = $this->validate(
            [
                'name' => 'required|unique:positions,name|min:3'
            ],
            [
                'name.required' => 'Nama posisi harus diisi',
                'name.unique' => 'Nama posisi sudah ada di sistem',
                'name.min' => 'Nama posisi minimal 3 karakter'
            ]
        );

        try {
            ModelsPosition::create($validated);
            $this->successNotification('Berhasil!', 'Posisi baru berhasil ditambahkan');
            $this->clear();
        } catch (\Exception $e) {
            $this->errorNotification('Gagal!', 'Terjadi kesalahan saat menambahkan posisi');
        }
    }

    public function destroy($id)
    {
        try {
            $position = ModelsPosition::find($id);
            if (!$position) {
                $this->errorNotification('Gagal!', 'Posisi tidak ditemukan');
                return;
            }

            $positionName = $position->name;
            $position->delete();
            $this->successNotification('Berhasil!', "Posisi '$positionName' berhasil dihapus");
        } catch (\Exception $e) {
            $this->errorNotification('Gagal!', 'Terjadi kesalahan saat menghapus posisi');
        }
    }

    public function edit($id)
    {
        $position = ModelsPosition::find($id);
        if (!$position) {
            $this->errorNotification('Gagal!', 'Posisi tidak ditemukan');
            return;
        }
        $this->name = $position->name;
        $this->idEdit = $position->id;
        $this->editCheck = true;
    }

    public function clear()
    {
        $this->name = '';
        $this->idEdit = '';
        $this->editCheck = false;
    }

    public function update($id)
    {
        $validate = $this->validate(
            [
                'name' => 'required|min:3|unique:positions,name,' . $id
            ],
            [
                'name.required' => 'Nama posisi harus diisi',
                'name.min' => 'Nama posisi minimal 3 karakter',
                'name.unique' => 'Nama posisi sudah ada di sistem'
            ]
        );

        try {
            $position = ModelsPosition::find($id);
            if (!$position) {
                $this->errorNotification('Gagal!', 'Posisi tidak ditemukan');
                return;
            }

            $position->update($validate);
            $this->successNotification('Berhasil!', 'Posisi berhasil diperbarui');
            $this->clear();
        } catch (\Exception $e) {
            $this->errorNotification('Gagal!', 'Terjadi kesalahan saat memperbarui posisi');
        }
    }
}
