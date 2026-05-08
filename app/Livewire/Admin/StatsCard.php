<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Attendance;
use App\Models\User;

class StatsCard extends Component
{
    public $stat;

    public function render()
    {
        $value = match ($this->stat) {
            'employees' => User::query()->count(),
            'present_today' => Attendance::where('date', now()->toDateString())
                ->where('status', 'present')
                ->count(),
            'absent_today' => Attendance::where('date', now()->toDateString())
                ->where('status', 'absent')
                ->count(),
            'leave_today' => Attendance::where('date', now()->toDateString())
                ->whereIn('status', ['sick', 'permit'])
                ->count(),
            default => 0,
        };

        return view('livewire.admin.stats-card', ['value' => $value]);
    }
}
