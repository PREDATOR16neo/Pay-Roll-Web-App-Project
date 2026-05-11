<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Attendance;
use App\Models\User;
use App\Traits\LivewireNotificationTrait;
use Illuminate\Support\Facades\DB;

class AttendanceManagement extends Component
{
    use WithPagination, LivewireNotificationTrait;

    public $search = '';
    public $filterDate = '';
    public $filterStatus = '';
    public $sortBy = 'date';
    public $sortDirection = 'desc';

    public $showModal = false;
    public $editingId = null;
    public $editingStatus = '';
    public $editingDate = '';

    protected $queryString = [
        'search',
        'filterDate',
        'filterStatus',
        'sortBy',
        'sortDirection'
    ];

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        if (!$this->filterDate) {

            $this->filterDate = now()->toDateString();
        }
    }

    public function render()
    {
        $query = Attendance::with('user');

        // SEARCH
        if ($this->search) {

            $query->whereHas('user', function ($q) {

                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // FILTER DATE
        if ($this->filterDate) {

            $query->whereDate('date', $this->filterDate);
        }

        // FILTER STATUS
        if ($this->filterStatus) {

            $query->where('status', $this->filterStatus);
        }

        // SORT
        $query->orderBy(
            $this->sortBy === 'name'
                ? 'user_id'
                : $this->sortBy,
            $this->sortDirection
        );

        $records = $query->paginate(15);

        // STATS
        $statsQuery = Attendance::query();

        if ($this->filterDate) {

            $statsQuery->whereDate('date', $this->filterDate);
        }

        if ($this->search) {

            $statsQuery->whereHas('user', function ($q) {

                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $stats = [

            'present' => (clone $statsQuery)
                ->where('status', 'present')
                ->count(),

            'absent' => (clone $statsQuery)
                ->where('status', 'absent')
                ->count(),

            'sick' => (clone $statsQuery)
                ->where('status', 'sick')
                ->count(),

            'permit' => (clone $statsQuery)
                ->where('status', 'permit')
                ->count(),

        ];

        return view('livewire.admin.attendance-management', [

            'records' => $records,

            'users' => User::orderBy('name', 'asc')->get(),

            'stats' => $stats,

            'totalRecords' => $statsQuery->count()

        ]);
    }

    public function toggleSort($field)
    {
        if ($this->sortBy === $field) {

            $this->sortDirection =
                $this->sortDirection === 'asc'
                ? 'desc'
                : 'asc';
        } else {

            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterDate = now()->toDateString();
        $this->filterStatus = '';

        $this->resetPage();
    }

    public function openEditModal($id, $status, $date)
    {
        $this->editingId = $id;
        $this->editingStatus = $status;
        $this->editingDate = $date;

        $this->showModal = true;
    }

    public function saveEdit()
    {
        $this->validate([

            'editingStatus' =>
            'required|in:present,absent,sick,permit',

            'editingDate' =>
            'required|date',

        ]);

        Attendance::find($this->editingId)->update([

            'status' => $this->editingStatus,
            'date' => $this->editingDate,

        ]);

        $this->showModal = false;

        $this->editingId = null;
        $this->editingStatus = '';
        $this->editingDate = '';

        $this->successNotification(
            'Berhasil!',
            'Data kehadiran berhasil diperbarui'
        );
    }

    public function deleteRecord($id)
    {
        Attendance::find($id)->delete();

        $this->successNotification(
            'Berhasil!',
            'Data kehadiran berhasil dihapus'
        );
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->editingId = null;
    }
}
