<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SalaryController extends Controller
{
    public function index()
    {
        $salaries = Salary::with(['employee.department', 'employee.position'])->get();
        return view('salaries.index', compact('salaries'));
    }

    public function create()
    {
        $employees = Employee::with(['position', 'department'])->get();
        return view('salaries.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'bulan' => 'required|string|max:255',
            'tunjangan' => 'required|numeric|min:0',
            'potongan' => 'required|numeric|min:0',
        ]);

        $employee = Employee::with('position')->findOrFail($request->karyawan_id);
        $gajiPokok = $employee->position->gaji_pokok ?? 0;
        $total = $gajiPokok + $request->tunjangan - $request->potongan;

        Salary::create([
            'karyawan_id' => $request->karyawan_id,
            'bulan' => $request->bulan,
            'gaji_pokok' => $gajiPokok,
            'tunjangan' => $request->tunjangan,
            'potongan' => $request->potongan,
            'total_gaji' => $total,
        ]);

        return redirect()->route('salaries.index')->with('success', 'Data gaji berhasil disimpan!');
    }

    public function edit($id)
    {
        if(Session::get('user_role') !== 'admin'){
            abort(403, 'Unauthorized action');
        }
        
        $salary = Salary::with(['employee.position', 'employee.department'])->findOrFail($id);
        $employees = Employee::with(['position', 'department'])->get();

        return view('salaries.edit', compact('salary', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'bulan' => 'required|string|max:20',
            'tunjangan' => 'required|numeric|min:0',
            'potongan' => 'required|numeric|min:0',
        ]);

        $salary = Salary::findOrFail($id);
        $employee = Employee::with('position')->findOrFail($request->karyawan_id);

        $gajiPokok = $employee->position->gaji_pokok ?? 0;
        $total = $gajiPokok + $request->tunjangan - $request->potongan;

        $salary->update([
            'karyawan_id' => $request->karyawan_id,
            'bulan' => $request->bulan,
            'gaji_pokok' => $gajiPokok,
            'tunjangan' => $request->tunjangan,
            'potongan' => $request->potongan,
            'total_gaji' => $total,
        ]);

        return redirect()->route('employees.index')->with('success', 'Data gaji berhasil diupdate!');
    }

    public function destroy($id)
    {
        if(Session::get('user_role') !== 'admin'){
            abort(403, 'Unauthorized action.');
        }

        $salary = Salary::findOrFail($id);
        $salary->delete();

        return redirect()->route('salaries.index')->with('success', 'Data gaji berhasil dihapus!');
    }
}
