<?php

namespace App\Observers;

use App\Models\Employee;
use App\Models\Salary;
use App\Models\Position;

class EmployeeObserver
{
    /**
     * Handle the Employee "created" event.
     */
    public function created(Employee $employee): void
    {
        // Pastikan method ini ada dan berjalan
        $this->createInitialSalary($employee);
    }

    /**
     * Handle the Employee "updated" event.
     */
    public function updated(Employee $employee): void
    {
        // Jika jabatan berubah, update gaji pokok di data gaji bulan ini
        if ($employee->isDirty('jabatan_id')) {
            $position = Position::find($employee->jabatan_id);
            $currentMonth = now()->format('Y-m');
            
            $salary = Salary::where('karyawan_id', $employee->id)
                ->where('bulan', $currentMonth)
                ->first();
            
            if ($salary && $position) {
                $salary->update([
                    'gaji_pokok' => $position->gaji_pokok,
                    'total_gaji' => $position->gaji_pokok + $salary->tunjangan - $salary->potongan,
                ]);
            }
        }
    }

    /**
     * Membuat data gaji pertama untuk karyawan baru
     */
    private function createInitialSalary(Employee $employee)
    {
        // Ambil data posisi untuk mendapatkan gaji pokok
        $position = Position::find($employee->jabatan_id);
        
        if (!$position) {
            return;
        }

        // Buat data gaji untuk bulan saat ini
        $currentMonth = now()->format('Y-m');

        // Cek dulu apakah sudah ada data gaji untuk bulan ini
        $existingSalary = Salary::where('karyawan_id', $employee->id)
            ->where('bulan', $currentMonth)
            ->first();

        if (!$existingSalary) {
            Salary::create([
                'karyawan_id' => $employee->id,
                'bulan' => $currentMonth,
                'gaji_pokok' => $position->gaji_pokok,
                'tunjangan' => 0,
                'potongan' => 0,
                'total_gaji' => $position->gaji_pokok,
            ]);
        }
    }
}