@extends('master')
@section('title', 'Edit Data Gaji')
@section('content')
<div class="container mx-auto mt-5 p-4">
    <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Data Gaji</h1>
        <form action="{{ route('salaries.update', $salary->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <label for="karyawan_id" class="font-medium text-gray-700">Pegawai</label>
                    <select name="karyawan_id" id="karyawan_id" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}"
                                {{ $salary->karyawan_id == $employee->id ? 'selected' : '' }}>
                                {{ $employee->nama_lengkap }} 
                                ({{ $employee->position->nama_jabatan ?? '-' }},
                                {{ $employee->department->nama_departemen ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <label for="bulan" class="font-medium text-gray-700">Bulan</label>
                    <input type="text" name="bulan" id="bulan" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{ old('bulan', $salary->bulan) }}" required>
                </div>

                <div class="row">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label for="gaji_pokok" class="font-medium text-gray-700">Gaji Pokok</label>
                        <input type="text" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="Rp {{ number_format($salary->gaji_pokok, 0, ',', '.') }}" readonly>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label for="tunjangan" class="font-medium text-gray-700">Tunjangan</label>
                        <input type="number" name="tunjangan" id="tunjangan" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            value="{{ old('tunjangan', $salary->tunjangan) }}" min="0" required>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label for="potongan" class="font-medium text-gray-700">Potongan</label>
                        <input type="number" name="potongan" id="potongan" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            value="{{ old('potongan', $salary->potongan) }}" min="0" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <label for="total_gaji" class="font-medium text-gray-700">Total Gaji</label>
                    <input type="text" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                        value="Rp {{ number_format($salary->total_gaji, 0, ',', '.') }}" readonly>
                </div>

                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-6 rounded-lg transition duration-200">Simpan Perubahan</button>
                    <a href="{{ route('employees.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-6 rounded-lg transition duration-200">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
