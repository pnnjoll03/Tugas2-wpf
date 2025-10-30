@extends('master')
@section('title', 'Tambah Absensi')
@section('content')
    <div class="container mx-auto mt-5 p-4">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Detail Pegawai</h1>
                <a href="{{ route('employees.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition duration-200">
                    Kembali
                </a>
            </div>

            <div class="overflow-hidden rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50 w-1/3">
                                Nama Lengkap
                            </th>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $employee->nama_lengkap }}
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                Email
                            </th>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $employee->email }}
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                Nomor Telepon
                            </th>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $employee->nomor_telepon ?? '-' }}
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                Tanggal Lahir
                            </th>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($employee->tanggal_lahir)->format('d F Y') }}
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                Alamat
                            </th>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $employee->alamat ?? '-' }}
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                Tanggal Masuk
                            </th>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($employee->tanggal_masuk)->format('d F Y') }}
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                Status
                            </th>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $employee->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($employee->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                Departemen
                            </th>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $employee->department->nama_departemen ?? '-' }}
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                Jabatan
                            </th>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $employee->position->nama_jabatan ?? '-' }}
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                Gaji Pokok
                            </th>
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold">
                                Rp {{ number_format($employee->position->gaji_pokok ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                <a href="{{ route('employees.edit', $employee->id) }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg transition duration-200">
                    Edit
                </a>
                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white py-2 px-6 rounded-lg transition duration-200"
                            onclick="return confirm('Yakin ingin menghapus pegawai ini?')">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection