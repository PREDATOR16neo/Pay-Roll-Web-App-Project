<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Attendance;

class RecentAttendance extends Component
{
    public function render()
    {
        $records = Attendance::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('livewire.admin.recent-attendance', ['records' => $records]);
    }
}
