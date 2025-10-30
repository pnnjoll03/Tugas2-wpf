@extends('master')
@section('title', 'Daftar Pegawai')
@section('content')
<div class="container mx-auto mt-5 p-4">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="mb-4 text-3xl font-bold text-gray-800">Daftar Pegawai</h1>
            <a href="{{ route('employees.create') }}" class="bg bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">Tambah Data</a>
        </div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 border-collapse">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Nama Lengkap</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Email</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Nomor Telepon</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Tanggal Lahir</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Alamat</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Tanggal Masuk</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Status</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Departemen</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Jabatan</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Gaji</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($employees as $employee)
                    <tr>
                        <td class="border border-gray-300 py-2 px-3">{{ $employee->nama_lengkap }}</td>
                        <td class="border border-gray-300 py-2 px-3">{{ $employee->email }}</td>
                        <td class="border border-gray-300 py-2 px-3">{{ $employee->nomor_telepon }}</td>
                        <td class="border border-gray-300 py-2 px-3">{{ $employee->tanggal_lahir }}</td>
                        <td class="border border-gray-300 py-2 px-3">{{ $employee->alamat }}</td>
                        <td class="border border-gray-300 py-2 px-3">{{ $employee->tanggal_masuk }}</td>
                        <td class="border border-gray-300 py-2 px-3">
                            <span class="badge bg-{{ $employee->status == 'aktif' ? 'success' : 'danger' }}">
                                {{ $employee->status }}
                            </span>
                        </td>
                        <td class="border border-gray-300 py-2 px-3">{{ $employee->department->nama_departemen ?? '-'}}</td>
                        <td class="border border-gray-300 py-2 px-3">{{ $employee->position->nama_jabatan ?? '-'}}</td>
                        <td class="border border-gray-300 py-2 px-3">
                            <div class="flex flex-col">
                                Rp {{ number_format($employee->position->gaji_pokok ?? 0, 0, ',', '.') }} 
                                <a href="{{ route('salaries.index') }}" class="text-blue-500 text-xs mt-1">Detail Gaji</a></td>
                            </div>
                        <td class="border border-gray-300 py-2 px-3">
                            <div class="flex flex-col space-y-1">
                                <a href="{{ route('employees.show', $employee->id) }}" class="bg bg-green-500 hover:bg-green-600 rounded text-sm py-1 px-2 text-center">Detail</a>
                                <a href="{{ route('employees.edit', $employee->id) }}" class="bg bg-blue-500 hover:bg-blue-600 text-sm py-1 px-2 text-sm py-1 px-2 text-center">Edit</a>
                                <a href="{{ route('attendances.create', ['employee_id' => $employee->id]) }}" class="bg bg-yellow-600 hover:bg-yellow-500 rounded text-sm py-1 px-2 text-center">Absen</a>
                                
                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 rounded text-sm py-1 px-2 text-center" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection