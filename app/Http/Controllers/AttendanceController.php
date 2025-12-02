<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee.department', 'employee.position')->latest('tanggal')->latest('created_at')->get();
        return view('attendances.index', compact('attendances'));
    }

    public function create($employee_id = null)
    {
        if(Session::get('user_role') !== 'employee'){
            abort(403, 'Unauthorized action.');
        }

        $employeeId = Session::get('employee_id');
        $employee = Employee::find($employeeId);

        if(!$employee){
            return redirect()->route('employees.index')->with('error', 'Data karyawan tidak ditemukan.');
        }

        $today = now()->format('Y-m-d');
        $todayAttendance = Attendance::where('karyawan_id', $employeeId)->where('tanggal', $today)->first();

        return view('attendances.create', compact('employee', 'todayAttendance'));
    }

    public function store(Request $request)
    {
        if(Session::get('user_role') !== 'employee'){
            abort(403, 'Unauthorized action.');
        }
        
        $employeeId = Session::get('employee_id');
        $employee = Employee::find($employeeId);

        if(!$employee){
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan.');
        }

        $today = now()->format('Y-m-d');
        $currentTime = now()->format('H:i');

        $attendance = Attendance::where('karyawan_id', $employeeId)->where('tanggal', $today)->first();

        if(!$attendance){
            Attendance::create([
                'karyawan_id' => $employeeId,
                'tanggal' => $today,
                'waktu_masuk' => $currentTime,
                'waktu_keluar' => null,
                'status_absensi' => 'hadir',
            ]);

            return redirect()->route('attendances.create')->with('success', 'Absen masuk berhasil! Jam:' . $currentTime);
        }elseif($attendance->waktu_masuk && !$attendance->waktu_keluar){
            $attendance->update([
                'waktu_keluar' => $currentTime
            ]);

            return redirect()->route('attendances.create')->with('success', 'Absen berhasil masuk! Jam: ' . $currentTime);
        }else{
            return redirect()->route('attendance.create')->with('error', 'Absen anda sudah lengkap hari ini.');
        }
    }

    public function show(string $id)
    {
        $attendance = Attendance::with('employee')->findOrFail($id);
        return view('attendances.show', compact('attendance'));
    }

    public function edit(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        $employees = Employee::all();
        return view('attendances.edit', compact('attendance', 'employees'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_keluar' => 'nullable|date_format:H:i',
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha'
        ]);

        $attendance = Attendance::findOrFail($id);
        $attendance->update($request->all());

        return redirect()->route('attendances.index')->with('success', 'Data absensi berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('attendances.index')
                        ->with('success', 'Data absensi berhasil dihapus');
    }
}