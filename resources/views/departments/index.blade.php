@extends('master')
@section('title', 'Daftar Pegawai')
@section('content')
<div class="container mx-auto mt-5 p-4">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Departemen</h1>
            <div class="flex justify-between items-center gap-3">
                <a href="{{ route('departments.create') }}" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">Tambah Department</a>
                <a href="{{ route('positions.create') }}" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">Tambah Jabatan dan Gaji</a>
            </div>
        </div>

        @foreach($departments as $department)
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-700 mb-4 p-3 bg-blue-50 rounded-lg">{{ $department->nama_departemen }}</h2>
            @if($department->employees->count() > 0)
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full border border-gray-300 border-collapse">
                        <thead class="bg-blue-500 text-white">
                            <tr>
                                <td class="border border-gray-300 py-2 px-3 w-1/4">Nama Pegawai</td>
                                <td class="border border-gray-300 py-2 px-3 w-1/4">Jabatan</td>
                                <td class="border border-gray-300 py-2 px-3 w-1/4">Tanggal Masuk</td>
                                <td class="border border-gray-300 py-2 px-3 w-1/4">Status</td>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($department->employees as $employee)
                                <tr class="border border-gray-300 py-2 px-3">
                                    <td class="border border-gray-300 py-2 px-3">{{ $employee->nama_lengkap }}</td>
                                    <td class="border border-gray-300 py-2 px-3">{{ $employee->position->nama_jabatan ?? '-' }}</td>
                                    <td class="border border-gray-300 py-2 px-3">{{ $employee->tanggal_masuk }}</td>
                                    <td class="border border-gray-300 py-2 px-3">{{ $employee->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>Tidak ada pegawai di departemen ini</p>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection


