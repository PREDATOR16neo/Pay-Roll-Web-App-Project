<?php

namespace App\Livewire\User;

use App\Traits\LivewireNotificationTrait;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance as ModelsAttendance;

class Attendance extends Component
{
    use LivewireNotificationTrait;

    public $user_id;
    public $date;
    public $status;
    public $attendanceRecords = [];

    public function mount()
    {
        $this->loadAttendanceRecords();
    }

    public function render()
    {
        return view('livewire.user.attendance', [
            'attendanceRecords' => $this->attendanceRecords
        ]);
    }

    public function save()
    {
        $this->validate(
            [
                'status' => 'required|in:present,absent,sick,permit'
            ],
            [
                'status.required' => 'Pilih status kehadiran terlebih dahulu',
                'status.in' => 'Status kehadiran tidak valid'
            ]
        );

        try {
            // Check if already submitted today
            $existingRecord = ModelsAttendance::where('user_id', Auth::user()->id)
                ->whereDate('date', now()->toDateString())
                ->first();

            $statusLabel = [
                'present' => 'Hadir',
                'absent' => 'Tidak Hadir',
                'sick' => 'Sakit',
                'permit' => 'Izin'
            ];

            if ($existingRecord) {
                // Update existing record
                $existingRecord->update([
                    'status' => $this->status
                ]);
                $this->successNotification(
                    'Berhasil!',
                    'Kehadiran berhasil diperbarui menjadi ' . $statusLabel[$this->status]
                );
            } else {
                // Create new record
                ModelsAttendance::create([
                    'user_id' => Auth::user()->id,
                    'date' => now()->toDateString(),
                    'status' => $this->status
                ]);
                $this->successNotification(
                    'Berhasil!',
                    'Kehadiran berhasil disimpan sebagai ' . $statusLabel[$this->status]
                );
            }

            // Reset form
            $this->status = null;

            // Reload records
            $this->loadAttendanceRecords();
        } catch (\Exception $e) {
            $this->errorNotification('Gagal!', 'Terjadi kesalahan saat menyimpan kehadiran');
        }
    }

    private function loadAttendanceRecords()
    {
        $this->attendanceRecords = ModelsAttendance::where('user_id', Auth::user()->id)
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();
    }
}
