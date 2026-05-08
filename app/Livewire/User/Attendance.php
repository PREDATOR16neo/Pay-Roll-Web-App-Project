<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance as ModelsAttendance;

class Attendance extends Component
{
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
        $this->validate([
            'status' => 'required|in:present,absent,sick,permit'
        ]);

        // Check if already submitted today
        $existingRecord = ModelsAttendance::where('user_id', Auth::user()->id)
            ->whereDate('date', now()->toDateString())
            ->first();

        if ($existingRecord) {
            // Update existing record
            $existingRecord->update([
                'status' => $this->status
            ]);
            session()->flash('massage', '✅ Kehadiran berhasil diperbarui!');
        } else {
            // Create new record
            ModelsAttendance::create([
                'user_id' => Auth::user()->id,
                'date' => now()->toDateString(),
                'status' => $this->status
            ]);
            session()->flash('massage', '✅ Kehadiran berhasil disimpan!');
        }

        // Reset form
        $this->status = null;

        // Reload records
        $this->loadAttendanceRecords();
    }

    private function loadAttendanceRecords()
    {
        $this->attendanceRecords = ModelsAttendance::where('user_id', Auth::user()->id)
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();
    }
}
