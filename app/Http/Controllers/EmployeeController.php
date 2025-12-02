<?php
namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    public function index(){
        $employees = Employee::with(['department', 'position'])->get();

        return view('employees.index', compact('employees'));
    }

    public function create(){
        if(Session::get('user_role') !== 'admin'){
            abort(403, 'Unauthorized action.');
        }

        $departments = Department :: all();
        $positions =  Position :: all();
        return view('employees.create', compact('departments', 'positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'      => 'required|string|max:225',
            'email'             => 'required|email|max:225|unique:employees,email',
            'nomor_telepon'     => 'required|string|max:20',
            'tanggal_lahir'     => 'required|date',
            'alamat'            => 'required|string|max:225',
            'tanggal_masuk'     => 'required|date',
            'status'            => 'required|string|max:50',
            'departemen_id'     => 'required|exists:departments,id',
            'jabatan_id'        => 'required|exists:positions,id',
        ]);

        // 1. Buat Employee
        $employee = Employee::create($request->all());
        
        // 2. Buat User untuk login (password default)
        $user = \App\Models\User::create([
            'name' => $employee->nama_lengkap,
            'email' => $employee->email,
            'password' => bcrypt('password123'), // Password default
            'employee_id' => $employee->id,
            'role' => 'employee',
            'is_active' => true,
        ]);
        
        // 3. Buat data gaji pertama
        $position = Position::find($employee->jabatan_id);
        if ($position) {
            \App\Models\Salary::create([
                'karyawan_id' => $employee->id,
                'bulan' => now()->format('Y-m'),
                'gaji_pokok' => $position->gaji_pokok,
                'tunjangan' => 0,
                'potongan' => 0,
                'total_gaji' => $position->gaji_pokok,
            ]);
        }

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil ditambahkan! Password default: password123');
    }

    public function show(string $id){
        $employee = Employee::with(['department', 'position', 'salaries'])->findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    public function edit(string $id){
        $employee = Employee::find($id);
        $departments = Department::all();
        $positions = Position::all();
        return view('employees.edit', compact('employee', 'departments', 'positions'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|string|max:50',
            'departemen_id' => 'required|exists:departments,id',
            'jabatan_id' => 'required|exists:positions,id',
        ]);
        
        $employee = Employee::findOrFail($id);
        $employee->update($request->only([
            'nama_lengkap',
            'email',
            'nomor_telepon',
            'tanggal_lahir',
            'alamat',
            'tanggal_masuk',
            'status',
            'departemen_id',
            'jabatan_id',
        ]));

        // Update data user jika ada perubahan email atau nama
        $user = \App\Models\User::where('employee_id', $employee->id)->first();
        if ($user) {
            $user->update([
                'name' => $employee->nama_lengkap,
                'email' => $employee->email,
            ]);
        }

        return redirect()->route('employees.index')->with('success', 'Data pegawai berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        
        // Hapus user terkait
        $user = \App\Models\User::where('employee_id', $employee->id)->first();
        if ($user) {
            $user->delete();
        }
        
        // Hapus data gaji terkait
        \App\Models\Salary::where('karyawan_id', $employee->id)->delete();
        
        $employee->delete();

        return redirect()->route('employees.index')
                        ->with('success', 'Data pegawai berhasil dihapus!');
    }
}