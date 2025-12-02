@extends('master')
@section('title', 'Daftar Pegawai')
@section('content')
<div class="container mx-auto mt-5 p-4">
    <!-- NAVBAR -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    @if(session('user_role') === 'admin')
                        Sistem Manajemen Karyawan
                    @else
                        Dashboard Karyawan
                    @endif
                </h1>
                <p class="text-gray-600 text-sm">
                    Selamat datang, {{ session('user_name') }} 
                    <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                        {{ session('user_role') }}
                    </span>
                </p>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Tombol Logout -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition duration-200 inline-flex items-center"
                            onclick="return confirm('Yakin ingin logout?')">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- KONTEN UTAMA -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                @if(session('user_role') === 'admin')
                    Daftar Pegawai
                @else
                    Profil Saya
                @endif
            </h1>
            
            @if(session('user_role') === 'admin')
                <a href="{{ route('employees.create') }}" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition duration-200 inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Pegawai
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 border-collapse">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="border border-gray-300 py-2 px-3">Nama Lengkap</th>
                        <th class="border border-gray-300 py-2 px-3">Email</th>
                        <th class="border border-gray-300 py-2 px-3">Nomor Telepon</th>
                        <th class="border border-gray-300 py-2 px-3">Tanggal Lahir</th>
                        <th class="border border-gray-300 py-2 px-3">Alamat</th>
                        <th class="border border-gray-300 py-2 px-3">Tanggal Masuk</th>
                        <th class="border border-gray-300 py-2 px-3">Status</th>
                        <th class="border border-gray-300 py-2 px-3">Departemen</th>
                        <th class="border border-gray-300 py-2 px-3">Jabatan</th>
                        <th class="border border-gray-300 py-2 px-3">Gaji Pokok</th>
                        <th class="border border-gray-300 py-2 px-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($employees as $employee)
                    <tr>
                        <td class="border border-gray-300 py-2 px-3">{{ $employee->nama_lengkap }}</td>
                        <td class="border border-gray-300 py-2 px-3">{{ $employee->email }}</td>
                        <td class="border border-gray-300 py-2 px-3">{{ $employee->nomor_telepon }}</td>
                        <td class="border border-gray-300 py-2 px-3">{{ \Carbon\Carbon::parse($employee->tanggal_lahir)->format('d/m/Y') }}</td>
                        <td class="border border-gray-300 py-2 px-3">{{ Str::limit($employee->alamat, 30) }}</td>
                        <td class="border border-gray-300 py-2 px-3">{{ \Carbon\Carbon::parse($employee->tanggal_masuk)->format('d/m/Y') }}</td>
                        <td class="border border-gray-300 py-2 px-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $employee->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $employee->status }}
                            </span>
                        </td>
                        <td class="border border-gray-300 py-2 px-3">{{ $employee->department->nama_departemen ?? '-' }}</td>
                        <td class="border border-gray-300 py-2 px-3">{{ $employee->position->nama_jabatan ?? '-' }}</td>
                        <td class="border border-gray-300 py-2 px-3">
                            <div class="flex flex-col">
                                Rp {{ number_format($employee->position->gaji_pokok ?? 0, 0, ',', '.') }} 
                            </div>
                        </td>
                        
                        <!-- KOLOM AKSI - Tergantung Role -->
                        <td class="border border-gray-300 py-2 px-3">
                            <div class="flex flex-col space-y-1">
                                <!-- Tombol Detail (Semua Role) -->
                                <a href="{{ route('employees.show', $employee->id) }}" 
                                   class="bg-green-500 hover:bg-green-600 text-white text-center py-1 px-2 rounded text-sm transition duration-200">
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection