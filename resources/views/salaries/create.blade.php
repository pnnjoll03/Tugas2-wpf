@extends('master')
@section('title', 'Tambah Data Gaji')
@section('content')
    <div class="container mx-auto mt-5 p-4">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Data Gaji</h1>

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('salaries.store') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <!-- Pilih Pegawai -->
                    <div>
                        <label for="karyawan_id" class="block font-medium text-gray-700 mb-2">Pegawai</label>
                        <select name="karyawan_id" id="karyawan_id" required
                                class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('karyawan_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->nama_lengkap }} 
                                    ({{ $employee->position->nama_jabatan ?? '-' }},
                                    {{ $employee->department->nama_departemen ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bulan -->
                    <div>
                        <label for="bulan" class="block font-medium text-gray-700 mb-2">Bulan</label>
                        <input type="text" name="bulan" id="bulan" placeholder="Contoh: Oktober 2025" required
                               class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('bulan') }}">
                    </div>

                    <!-- Tunjangan -->
                    <div>
                        <label for="tunjangan" class="block font-medium text-gray-700 mb-2">Tunjangan</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                            <input type="number" name="tunjangan" id="tunjangan" value="{{ old('tunjangan', 0) }}" required
                                   class="w-full border border-gray-300 rounded-lg py-2 px-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   min="0">
                        </div>
                    </div>

                    <!-- Potongan -->
                    <div>
                        <label for="potongan" class="block font-medium text-gray-700 mb-2">Potongan</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                            <input type="number" name="potongan" id="potongan" value="{{ old('potongan', 0) }}" required
                                   class="w-full border border-gray-300 rounded-lg py-2 px-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   min="0">
                        </div>
                    </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                    <a href="{{ route('salaries.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-6 rounded-lg transition duration-200">
                        Kembali
                    </a>
                    <button type="submit" 
                            class="bg-green-500 hover:bg-green-600 text-white py-2 px-6 rounded-lg transition duration-200">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
