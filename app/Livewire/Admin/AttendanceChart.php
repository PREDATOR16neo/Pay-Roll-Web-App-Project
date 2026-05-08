<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Attendance;

class AttendanceChart extends Component
{
    public function render()
    {
        $today = now()->toDateString();

        $present = Attendance::where('date', $today)->where('status', 'present')->count();
        $absent = Attendance::where('date', $today)->where('status', 'absent')->count();
        $sick = Attendance::where('date', $today)->where('status', 'sick')->count();
        $permit = Attendance::where('date', $today)->where('status', 'permit')->count();

        return view('livewire.admin.attendance-chart', [
            'present' => $present,
            'absent' => $absent,
            'sick' => $sick,
            'permit' => $permit,
            'total' => $present + $absent + $sick + $permit
        ]);
    }
}
