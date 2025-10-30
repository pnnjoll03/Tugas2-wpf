@extends('master')
@section('title', 'Tambah Absensi')
@section('content')
    <div class="container mx-auto mt-5 p-4">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Absensi</h1>

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('attendances.store') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <!-- Pilih Pegawai -->
                    <div>
                        <label for="karyawan_id" class="block font-medium text-gray-700 mb-2">Pegawai</label>
                        <select name="karyawan_id" id="karyawan_id" 
                                class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">Pilih Pegawai</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" 
                                    {{ $selectedEmployee && $selectedEmployee->id == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label for="tanggal" class="block font-medium text-gray-700 mb-2">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" 
                               class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    </div>

                    <!-- Waktu Masuk & Keluar -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="waktu_masuk" class="block font-medium text-gray-700 mb-2">Waktu Masuk</label>
                            <input type="time" name="waktu_masuk" id="waktu_masuk" 
                                   class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   value="{{ old('waktu_masuk') }}">
                        </div>
                        <div>
                            <label for="waktu_keluar" class="block font-medium text-gray-700 mb-2">Waktu Keluar</label>
                            <input type="time" name="waktu_keluar" id="waktu_keluar" 
                                   class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   value="{{ old('waktu_keluar') }}">
                        </div>
                    </div>

                    <!-- Status Absensi -->
                    <div>
                        <label for="status_absensi" class="block font-medium text-gray-700 mb-2">Status Absensi</label>
                        <select name="status_absensi" id="status_absensi" 
                                class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="hadir" {{ old('status_absensi') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="izin" {{ old('status_absensi') == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="sakit" {{ old('status_absensi') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="alpha" {{ old('status_absensi') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                        </select>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                    <a href="{{ route('employees.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-6 rounded-lg transition duration-200">
                        Kembali
                    </a>
                    <button type="submit" 
                            class="bg-green-500 hover:bg-green-600 text-white py-2 px-6 rounded-lg transition duration-200">
                        Simpan Absensi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection