<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin(){
        return view('auth.login');
    }

    public function showRegister(){
        // Ambil data departments dan positions
        $departments = Department::all();
        $positions = Position::all();
        
        return view('auth.register', compact('departments', 'positions'));
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return back()->withErrors(['email'=>'Email tidak ditemukan.'])->withInput();
        }

        if(!$user->isActive()){
            return back()->withErrors(['email'=>'Akun tidak aktif.'])->withInput();
        }

        if(!$user->verifyPassword($request->password)){
            return back()->withErrors(['password'=>'Password salah.'])->withInput();
        }

        Session::put('user_id', $user->id);
        Session::put('user_name', $user->name);
        Session::put('user_role', $user->role);
        Session::put('employee_id', $user->employee_id);

        $user->updateLastLogin();

        return redirect()->intended('/employees')->with('success', 'Login berhasil!');
    }

    public function register(Request $request){
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'nomor_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:500',
            'departemen_id' => 'required|exists:departments,id',
            'jabatan_id' => 'required|exists:positions,id',
        ]);
        
        try {
            // 1. Buat Employee
            $employee = Employee::create([
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'nomor_telepon' => $request->nomor_telepon,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'tanggal_masuk' => now(),
                'status' => 'aktif',
                'departemen_id' => $request->departemen_id,
                'jabatan_id' => $request->jabatan_id,
            ]);

            // 2. Buat User
            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'employee_id' => $employee->id,
                'role' => 'employee',
                'is_active' => true,
            ]);

            $position = Position::find($employee->jabatan_id);
            if($position){
                Salary::create([
                    'karyawan_id' => $employee->id,
                    'bulan' => now()->format('Y-m'),
                    'gaji_pokok' => $position->gaji_pokok,
                    'tunjangan' => 0,
                    'potongan' => 0,
                    'total_gaji' => $position->gaji_pokok,
                ]); 
            }

            return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function logout(Request $request){
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Session::flush();
        return redirect('/login')->with('success', 'Logout berhasil!');
    }

    public function dashboard(){
        return redirect('/employees');
    }
}