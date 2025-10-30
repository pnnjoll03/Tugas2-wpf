@extends('master')
@section('title', 'Tambah Absensi')
@section('content')
    <div class="container mx-auto mt-5 p-4">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Data Pegawai</h1>

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <!-- Nama Lengkap -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700">Nama Lengkap:</label>
                        <div class="md:col-span-2">
                            <input type="text" name="nama_lengkap" 
                                   class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   value="{{ old('nama_lengkap', $employee->nama_lengkap) }}">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700">Email:</label>
                        <div class="md:col-span-2">
                            <input type="email" name="email"
                                   class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   value="{{ old('email', $employee->email) }}">
                        </div>
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700">Nomor Telepon:</label>
                        <div class="md:col-span-2">
                            <input type="text" name="nomor_telepon"
                                   class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   value="{{ old('nomor_telepon', $employee->nomor_telepon) }}">
                        </div>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700">Tanggal Lahir:</label>
                        <div class="md:col-span-2">
                            <input type="date" name="tanggal_lahir"
                                   class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   value="{{ old('tanggal_lahir', $employee->tanggal_lahir) }}">
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label class="font-medium text-gray-700">Alamat:</label>
                        <div class="md:col-span-2">
                            <textarea name="alamat" rows="3"
                                      class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('alamat', $employee->alamat) }}</textarea>
                        </div>
                    </div>

                    <!-- Tanggal Masuk -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700">Tanggal Masuk:</label>
                        <div class="md:col-span-2">
                            <input type="date" name="tanggal_masuk"
                                   class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   value="{{ old('tanggal_masuk', $employee->tanggal_masuk) }}">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700">Status:</label>
                        <div class="md:col-span-2">
                            <select name="status"
                                    class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="aktif" {{ old('status', $employee->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak aktif" {{ old('status', $employee->status) == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Departemen -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700">Departemen:</label>
                        <div class="md:col-span-2">
                            <select name="departemen_id" id="departemen_id"
                                    class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('departemen_id', $employee->departemen_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->nama_departemen }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Jabatan -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700">Jabatan:</label>
                        <div class="md:col-span-2">
                            <select name="jabatan_id" id="jabatan_id"
                                    class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}" {{ old('jabatan_id', $employee->jabatan_id) == $position->id ? 'selected' : '' }}>
                                        {{ $position->nama_jabatan }} - Rp {{ number_format($position->gaji_pokok, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                    <a href="{{ route('employees.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-6 rounded-lg transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-green-500 hover:bg-green-600 text-white py-2 px-6 rounded-lg transition duration-200">
                        Update
                    </button>
                </div>
            </form>
        </div>
@endsection