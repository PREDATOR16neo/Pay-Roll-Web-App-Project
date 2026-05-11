<?php

namespace App\Livewire\Admin;

use App\Models\Employee;
use App\Models\Payroll as ModelsPayroll;
use App\Traits\LivewireNotificationTrait;
use Livewire\Component;

class Payroll extends Component
{
    use LivewireNotificationTrait;

    public $editCheck = false;
    public $idEdit;
    public $employee_id;
    public $period;
    public $allowance;
    public $deduction;

    public function render()
    {
        $employees = Employee::all();
        $payrolls = ModelsPayroll::all();
        return view('livewire.admin.payroll', compact('payrolls', 'employees'));
    }

    public function store()
    {
        $validate = $this->validate(
            [
                'employee_id' => 'required|exists:employees,id',
                'period' => 'required|regex:/^\d{4}-\d{2}-\d{2}$/',
                'allowance' => 'required|numeric|min:0',
                'deduction' => 'required|numeric|min:0'
            ],
            [
                'employee_id.required' => 'Pilih employee terlebih dahulu',
                'employee_id.exists' => 'Employee tidak ditemukan',
                'period.required' => 'Period harus diisi',
                'period.regex' => 'Format period tidak valid (gunakan format: YYYY-MM-DD)',
                'allowance.required' => 'Tunjangan harus diisi',
                'allowance.numeric' => 'Tunjangan harus berupa angka',
                'allowance.min' => 'Tunjangan tidak boleh negatif',
                'deduction.required' => 'Potongan harus diisi',
                'deduction.numeric' => 'Potongan harus berupa angka',
                'deduction.min' => 'Potongan tidak boleh negatif'
            ]
        );

        try {
            $employee = Employee::find($this->employee_id);
            ModelsPayroll::create([
                'employee_id' => $this->employee_id,
                'period' => $this->period,
                'allowance' => $this->allowance,
                'deduction' => $this->deduction,
                'net_salary' => $employee->salary + $this->allowance - $this->deduction
            ]);

            $this->successNotification(
                'Berhasil!',
                "Payroll untuk {$employee->user->name} periode {$this->period} berhasil ditambahkan"
            );
            $this->clear();
        } catch (\Exception $e) {
            $this->errorNotification('Gagal!', 'Terjadi kesalahan saat menambahkan payroll: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $payroll = ModelsPayroll::find($id);
            if (!$payroll) {
                $this->errorNotification('Gagal!', 'Payroll tidak ditemukan');
                return;
            }

            $employeeName = $payroll->employee->user->name;
            $period = $payroll->period;
            $payroll->delete();

            $this->successNotification('Berhasil!', "Payroll {$employeeName} periode {$period} berhasil dihapus");
        } catch (\Exception $e) {
            $this->errorNotification('Gagal!', 'Terjadi kesalahan saat menghapus payroll');
        }
    }

    public function edit($id)
    {
        $payroll = ModelsPayroll::find($id);
        if (!$payroll) {
            $this->errorNotification('Gagal!', 'Payroll tidak ditemukan');
            return;
        }

        $this->idEdit = $payroll->id;
        $this->employee_id = $payroll->employee_id;
        $this->allowance = $payroll->allowance;
        $this->deduction = $payroll->deduction;
        $this->period = $payroll->period;
        $this->editCheck = true;
    }

    public function clear()
    {
        $this->idEdit = '';
        $this->employee_id = '';
        $this->allowance = '';
        $this->deduction = '';
        $this->period = '';
        $this->editCheck = false;
    }

    public function update($id)
    {
        try {
            $payroll = ModelsPayroll::find($id);
            if (!$payroll) {
                $this->errorNotification('Gagal!', 'Payroll tidak ditemukan');
                return;
            }

            $this->validate(
                [
                    'employee_id' => 'required|exists:employees,id',
                    'period' => 'required|regex:/^\d{4}-\d{2}-\d{2}$/',
                    'allowance' => 'required|numeric|min:0',
                    'deduction' => 'required|numeric|min:0'
                ],
                [
                    'employee_id.required' => 'Pilih employee terlebih dahulu',
                    'employee_id.exists' => 'Employee tidak ditemukan',
                    'period.required' => 'Period harus diisi',
                    'period.regex' => 'Format period tidak valid (gunakan format: YYYY-MM-DD)',
                    'allowance.required' => 'Tunjangan harus diisi',
                    'allowance.numeric' => 'Tunjangan harus berupa angka',
                    'allowance.min' => 'Tunjangan tidak boleh negatif',
                    'deduction.required' => 'Potongan harus diisi',
                    'deduction.numeric' => 'Potongan harus berupa angka',
                    'deduction.min' => 'Potongan tidak boleh negatif'
                ]
            );

            $employee = Employee::find($this->employee_id);
            $payroll->update([
                'employee_id' => $this->employee_id,
                'period' => $this->period,
                'allowance' => $this->allowance,
                'deduction' => $this->deduction,
                'net_salary' => $employee->salary + $this->allowance - $this->deduction
            ]);

            $this->successNotification('Berhasil!', 'Data payroll berhasil diperbarui');
            $this->clear();
        } catch (\Exception $e) {
            $this->errorNotification('Gagal!', 'Terjadi kesalahan saat memperbarui payroll');
        }
    }
}
